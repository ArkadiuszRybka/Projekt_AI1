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

// sk_test_51NIc4GBWDnVcNSkWoFxJpI6E8Go0s3zbtcEMP79a23ctGLu4wWAbMTA02uIN0VHIv3L4vIwnm7kkFGbE5V8KA6hO00cAJ6y74i
public function processPayment(Request $request)
{
    // Ustawienie klucza tajnego Stripe
    Stripe::setApiKey('{{ env("STRIPE_SECRET_KEY") }}');
    dd($request->all());

    // Utworzenie płatności na podstawie tokenu płatności

    $totalAmount = $request->input('totalAmount');

    try {
        Charge::create([
            'amount' => $totalAmount*100,
            'currency' => 'pln',
            'description' => 'Opłata za zamówienie',
            'source' =>  $request->stripeToken,
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
