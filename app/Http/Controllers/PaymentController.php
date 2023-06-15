<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Stripe\Charge;

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
    // Ustawienie klucza tajnego Stripe
    $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));


    // Utworzenie płatności na podstawie tokenu płatności

    $totalAmount = $request->input('totalAmount');
    $token = $request->input('stripeToken');
    $source = $stripe->sources->create([
        'type' => 'card',
        'token' => $token,
    ]);
    try {
        $paymentIntent = $stripe->paymentIntents->create([
            'amount' => $totalAmount * 100,
            'currency' => 'pln',
            'description' => 'Opłata za zamówienie',
            'source' => $source->id,
        ]);

        // Płatność zakończona sukcesem
        return redirect()->route('successPayment');
    } catch (\Exception $e) {
        // Obsługa błędu płatności
        return redirect()->route('errorPayment')->with('error', $e->getMessage());
    }
}

public function successPayment()
    {
        session()->forget('cart');
        session()->save();
        return view('payment.success');
    }

    public function errorPayment()
    {
        // Strona obsługi błędu płatności
        return view('payment.error');
    }

}
