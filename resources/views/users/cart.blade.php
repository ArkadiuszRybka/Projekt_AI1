@extends('layouts.app')

@section('content')
    <section class="shopping-cart dark">
        <div class="container">
            <div class="block-heading">
                <h2>Koszyk</h2>
            </div>
            <div class="content">
                <div class="row">
                    <div class="col-md-12 col-lg-8">
                        <div class="items">
                            @foreach ($cart as $stone)
                                <div class="product">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <img class="img-fluid mx-auto d-block image" src="{{  asset($stone->img) }}">
                                        </div>
                                        <div class="col-md-8">
                                            <div class="info">
                                                <div class="row">
                                                    <div class="col-md-4 product-name ">
                                                        <div>
                                                            <h6><b>{{ $stone->name }}</b></h6>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 quantity">
                                                        <label for="quantity"><b>Ilość:</b></label>
                                                        <input id="quantity" type="number" value="1" class="form-control quantity-input" min="1" data-price="{{ $stone->price }}">
                                                    </div>
                                                    <div class="col-md-3 price">
                                                        <label><b>Cena:</b></label>
                                                        <span class="product-price">{{ $stone->price }}</span>zł/1000kg
                                                    </div>
                                                    <div class="col-md-3">
                                                        <form action="{{ route('cart.remove') }}" method="POST" class="remove-product-form">
                                                            @csrf
                                                            <input type="hidden" name="productId" value="{{ $stone->id }}">
                                                            <button type="submit" class="btn btn-danger remove-product">Usuń</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-4">
                        <div class="summary">
                            <h3>Podsumowanie</h3>
                            <div class="summary-item"><span class="text"><b>Cena: </b> </span><span class="price"></span></div>
                            <div class="summary-item"><span class="text"><b>Zniżka:</b> </span><span class="discount"></span></div>
                            <div class="summary-item"><span class="text"><b>Dostawa:</b> </span><span class="price">0</span></div>
                            <div class="summary-item"><span class="text"><b>Kwota:</b> </span><span class="total-price"></span></div>
                            <div class="summary-item"><a href="{{ route('payment') }}" class="btn btn-primary" id="payment-button">Przejdź do płatności</a></div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        function updateTotalPrice() {
            var totalQuantity = 0;
            var totalPrice = 0;

            var products = document.querySelectorAll('.product');

            products.forEach(function (product) {
                var quantityInput = product.querySelector('.quantity-input');
                var priceElement = product.querySelector('.product-price');
                var quantity = parseInt(quantityInput.value);
                var price = parseFloat(priceElement.textContent);

                if (!isNaN(quantity) && !isNaN(price)) {
                    totalQuantity += quantity;
                    totalPrice += price * quantity;
                }
            });
            var discount = 0;
            if (totalQuantity > 20) {
                discount = 0.17;
            } else if (totalQuantity > 12) {
                discount = 0.13;
            } else if (totalQuantity > 7) {
                discount = 0.1;
            } else if (totalQuantity > 5) {
                discount = 0.08;
            } else if (totalQuantity > 3) {
                discount = 0.05;
            }
            var totalPriceElement = document.querySelector('.summary-item .price');
            var discountElement = document.querySelector('.summary-item .discount');
            var totalAmountElement = document.querySelector('.summary-item .total-price');

            if (totalPriceElement && discountElement && totalAmountElement) {
                totalPriceElement.textContent = totalPrice.toFixed(2);
                discountElement.textContent = (discount * 100).toFixed(0) + '%';
                totalAmountElement.textContent = (totalPrice * (1 - discount)).toFixed(2);
            }
        }

            // Aktualizuj cenę przy zmianie ilości kamieni
            var quantityInputs = document.querySelectorAll('.quantity-input');
            quantityInputs.forEach(function (input) {
                input.addEventListener('input', function () {
                    updateTotalPrice();
                });
            });

        // Pobierz wszystkie formularze "Usuń"
        var removeForms = document.querySelectorAll('.remove-product-form');

        // Dodaj obsługę zdarzenia submit dla każdego formularza "Usuń"
        removeForms.forEach(function (form) {
            form.addEventListener('submit', function (event) {
                event.preventDefault();

                var productContainer = form.closest('.product');
                var productId = form.querySelector('input[name="productId"]').value;

                // Wywołaj funkcję do usuwania produktu z koszyka
                removeProductFromCart(productId, productContainer);
            });
        });



        function removeProductFromCart(productId, productContainer) {
            // Wywołaj odpowiednie zapytanie AJAX do usunięcia produktu z koszyka
            fetch('/cart/remove', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ productId: productId })
            })
                .then(function (response) {
                    if (response.ok) {
                        // Usunięcie z powodzeniem
                        productContainer.remove(); // Usuń kontener produktu z koszyka
                        updateTotalPrice(); // Zaktualizuj cenę po usunięciu produktu
                    } else {
                        // Wystąpił błąd
                        console.log('Wystąpił błąd podczas usuwania produktu z koszyka.');
                    }
                })
                .catch(function (error) {
                    console.log('Wystąpił błąd podczas wykonywania żądania.');
                });
        }

        // Inicjalizacja podsumowania
        updateTotalPrice();



        var paymentButton = document.getElementById('payment-button');

paymentButton.addEventListener('click', function (event) {
    event.preventDefault();

    var stones = [];
    var quantities = [];
    var totalAmountElement = document.querySelector('.summary-item .total-price');

    // Pobierz nazwy kamieni i ich ilości
    var products = document.querySelectorAll('.product');
    products.forEach(function (product) {
        var stoneName = product.querySelector('.product-name h6').textContent;
        var quantityInput = product.querySelector('.quantity-input');
        var quantity = parseInt(quantityInput.value);

        stones.push(stoneName);
        quantities.push(quantity);
    });

    // Pobierz kwotę
    var totalAmount = totalAmountElement.textContent;

    // Przejdź do widoku płatności i przekaż dane jako parametry URL
    window.location.href = '{{ route('payment') }}' + '?stones=' + encodeURIComponent(JSON.stringify(stones)) +
        '&quantities=' + encodeURIComponent(JSON.stringify(quantities)) +
        '&totalAmount=' + encodeURIComponent(totalAmount);
});

    </script>
@endsection
