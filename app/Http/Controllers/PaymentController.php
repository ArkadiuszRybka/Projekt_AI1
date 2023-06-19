<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Stripe\Charge;
use App\Http\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function showPayment()
{
    $stones = json_decode(request()->get('stones'));
    $quantities = json_decode(request()->get('quantities'));
    $totalAmount = request()->get('totalAmount');

    return view('payment.payment', compact('stones', 'quantities', 'totalAmount'));
}

public function processPayment(Request $request)
{
    $totalAmount = $request->input('totalAmount');
    $cart = session()->get('cart', []);
    $quantities = $request->input('quantities');

    try {
        $paymentStatus = $this->checkPayment($request);

        if ($paymentStatus === 'succeeded') {
            $transactionId = DB::table('transactions')->insertGetId([
            'user_id' => Auth::user()->id,
            'price' => $totalAmount,
            'created_at' => Carbon::now(),
        ]);

        foreach ($cart as $key => $stoneId) {
            DB::table('orders')->insert([
                'stone_id' => $stoneId->id,
                'transactions_id' => $transactionId,
                'quantities' => $quantities[$key],
            ]);
        }

        session()->forget('cart');
        session()->save();
            return redirect()->route('successPayment');
        } else {
            throw new \Exception(session()->get('error'));
        }
    } catch (\Exception $e) {
        // Obsługa błędów płatności
        $errorMessage = $this->getPaymentErrorMessage($e->getMessage());
        return redirect()->route('errorPayment')->with('error', $errorMessage);
    }
}




private function checkPayment(Request $request)
{
    $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
    $token = $request->input('stripeToken');

    $source = $stripe->sources->create([
        'type' => 'card',
        'token' => $token,
    ]);
    $totalAmount = $request->input('totalAmount');

    try {
        $paymentIntent = $stripe->paymentIntents->create([
            'amount' => $totalAmount * 100,
            'currency' => 'pln',
            'description' => 'Opłata zamówienie',
            'source' => $source->id,
        ]);

        $paymentIntentId = $paymentIntent->id;
        $confirmedPaymentIntent = $stripe->paymentIntents->confirm($paymentIntentId);
        $paymentStatus = $confirmedPaymentIntent->status;

        return $paymentStatus;
    } catch (\Exception $e) {
        throw new \Exception($e->getMessage());
    }
}


private function getPaymentErrorMessage($errorMessage)
{
    switch ($errorMessage) {
        case 'Your card was declined.':
            return __('Karta została odrzucona. Prosimy spróbować inną kartę płatniczą.');
        case 'Your card has expired.':
            return __('Karta płatnicza wygasła. Prosimy podać ważną kartę płatniczą.');
        case 'Your card\'s security code is incorrect.':
            return __('Nieprawidłowy kod CVC. Prosimy sprawdzić poprawność wprowadzonego kodu.');
        case 'An error occurred while processing your payment.':
            return __('Wystąpił błąd podczas przetwarzania płatności. Prosimy spróbować ponownie.');
        case 'Your card number is incorrect.':
            return __('Nieprawidłowy numer karty. Prosimy sprawdzić poprawność wprowadzonego numeru.');
        default:
            return __('Wystąpił błąd podczas przetwarzania płatności. Spróbuj ponownie później.');
    }
}


    public function successPayment()
    {
        $user = Auth::user();
        return view('payment.success');
    }

    public function errorPayment()
    {
        $errorMessage = session()->get('error');
        return view('payment.error', ['errorMessage' => $errorMessage]);
    }
}
