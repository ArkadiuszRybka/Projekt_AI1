@include('layouts.app')
<div class="container text-white">
    <h1>Błąd podczas płatności.</h1>
    <h4>Proszę zapoznać się z podanym błędem.</h4>
    <p>{{Session('error')}}</p>
    <a href="{{ route('cart') }}" class="btn btn-primary">Powrót do koszyka</a>
</div>
