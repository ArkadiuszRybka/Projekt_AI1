@include('layouts.app')
<body>


        <div class="container col-md-4">
            <h2>Podsumowanie zamówienia</h2>
            <div class="cart-items">
                <form action="{{ route('process_payment') }}" method="POST" >
                    @csrf
                    @if (!empty($stones) && !empty($quantities))
                        @for ($i = 0; $i < count($stones); $i++)
                            <div class="item">
                                <h4>{{ $stones[$i] }} <p>Ilość: {{ $quantities[$i] }}000kg</p></h4>
                            </div>
                        @endfor
                    @else
                        <p>Brak danych do wyświetlenia.</p>
                    @endif

                    <input type="hidden" name="stripeToken" value="" id="tokenStripe">

                    <div class="total-price">
                        <h3>Kwota do zapłaty: {{ $totalAmount }}zł</h3>
                        <input type="hidden" value="{{ $totalAmount }}" name="totalAmount">
                    </div>
                    <div id="card-element" class="form-control"></div>
                    <div id="card-errors" class="invalid-feedback"></div>
                    <input type="hidden" name="stripeToken" value="" id="tokenStripe">
                    <button type="submit" class="btn btn-primary">Zapłać</button>
                </form>
            </div>
        </div>


    {{-- pk_test_51NIc4GBWDnVcNSkWL9DjadBXYnGD36Wd65up6EcUjiQsSGZz7G2jarDa00aomw1mflKTBrVAz7FHlWPh6iaRfn1a00YREJvE7L --}}
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        var stripe = Stripe('pk_test_51NIc4GBWDnVcNSkWL9DjadBXYnGD36Wd65up6EcUjiQsSGZz7G2jarDa00aomw1mflKTBrVAz7FHlWPh6iaRfn1a00YREJvE7L');
        var elements = stripe.elements();
        var cardElement = elements.create('card');
        cardElement.mount('#card-element');

        var form = document.querySelector('form');
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
