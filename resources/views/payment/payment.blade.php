@include('layouts.app')
<body>


    <div class="container col-md-4">
        <h2>Podsumowanie zamówienia</h2>
        <div class="cart-items">
            <form action="{{ route('process_payment') }}" method="POST" id="paymentForm">
                @csrf
                @if (!empty($stones) && !empty($quantities))
                    @foreach($stones as $key => $stone)
                        <div class="item">
                            <h4>{{ $stone }}</h4>
                            <p>Ilość: {{ $quantities[$key] }}000kg</p>
                            <input type="hidden" name="quantities[]" value="{{ $quantities[$key] }}">
                        </div>
                    @endforeach
                @else
                    <p>Brak danych do wyświetlenia.</p>
                @endif

                <div class="total-price">
                    <h3>Kwota do zapłaty: {{ $totalAmount }}zł</h3>
                    <input type="hidden" value="{{ $totalAmount }}" name="totalAmount">
                </div>
                <div id="card-element" class="form-control" data-stripe-key="{{ env('STRIPE_PUBLIC_KEY') }}"></div>
                <div id="card-errors" class="invalid-feedback"></div>
                <input type="hidden" name="stripeToken" value="" id="tokenStripe">
                <button type="submit" class="btn btn-primary">Zapłać</button>
            </form>
        </div>
    </div>



    <script src="https://js.stripe.com/v3/"></script>
    <script>
        var stripeKey = document.getElementById('card-element').getAttribute('data-stripe-key');
        var stripe = Stripe(stripeKey);
        var elements = stripe.elements();
        var cardElement = elements.create('card');
        cardElement.mount('#card-element');

        var form = document.getElementById('paymentForm');
        var stripeTokenInput = document.getElementById('tokenStripe');

        form.addEventListener('submit', function(event) {
            event.preventDefault();

            stripe.createToken(cardElement).then(function(result) {
            if (result.error) {
                // Obsługa błędu tokenizacji
                console.error(result.error.message);
            } else {

                // Pobranie tokenu płatności
                stripeTokenInput.value = result.token.id;

                // Wysłanie formularza
                form.submit();
            }
            });
        });
    </script>
    <script src="js/bootstrap.bundle.js"></script>
</body>
