<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\Models\Stone;

class CartController extends Controller
{
    public function showCart()
{
    $cart = session()->get('cart', []);

    return view('users.cart', ['cart' => $cart]);
}



    public function removeProduct(Request $request)
{
    $productId = $request->input('productId');

    // Usuń produkt o podanym identyfikatorze z koszyka
    $cart = session()->get('cart', []);

    foreach ($cart as $key => $stone) {
        if ($stone->id == $productId) {
            unset($cart[$key]);
            break;
        }
    }

    session()->put('cart', $cart);

    return response()->json(['success' => true]);
}

    public function addToCart($id)
{
    $stoneId = Stone::find($id);

    $cart = session()->get('cart', []);
    $cart[] = $stoneId;
    session()->put('cart', $cart);

    return redirect()->route('main')->with('success', 'Film został dodany do koszyka.');
}







}
