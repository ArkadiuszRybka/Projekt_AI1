@include('layouts.app')
<div class="container text-white">
    <h1>Błąd płatności</h1>
    <a href="{{ route('cart') }}" class="btn btn-primary">Powrót do koszyka</a>
    <p>{{Session('error')}}</p>
</div>
