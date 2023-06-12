<!DOCTYPE html>
<html >
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="css/bootstrap.css" rel="stylesheet">
        <title>Kamienie Ogrodowe</title>
    </head>
    <body>

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand nav-link"><b>Kamienie ogrodowe</b></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
              aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                  <li class="nav-item">
                    <a class="nav-link" href="#oferta">Oferta</a>
                  </li>
                </ul>
              </div>
              <ul class="navbar-nav ml-auto">
                @if(Auth::check() && Auth::user()->isAdmin)
                    <li class="nav-item">
                        <a class="nav-link red-after" href="{{ route('editStones') }}">Edycja towaru</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link red-after" href="{{ route('editUsers') }}">Edycja użytkowników</a>
                    </li>
                @endif
                @guest
                <a class="nav-link btn btn-success" href="{{ route('login') }}">Zaloguj się</a>
                <a class="nav-link btn btn-success" href="{{ route('register') }}">Zarejestruj się</a>
        @else
                <a class="nav-link btn btn-success" href="{{ route('users.show', ['id' => Auth::id()]) }}">Ustawienia</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>

                <a class="nav-link btn btn-success" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Wyloguj
                </a>
        @endguest
              </ul>
            </div>
          </nav>


        <div id="carouselExampleCaptions" class="carousel slide">
            <div class="carousel-indicators">
              <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
              <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
            </div>
            <div class="carousel-inner">
              <div class="carousel-item active">
                <img src="img/carousel.jpg" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                  <h1>Kamienie dekoracyjne ogrodowe</h1>
                  <h1>Oferujemy niskie ceny oraz szybki transport!</h1>
                </div>
              </div>
              <div class="carousel-item">
                <img src="img/carousel2.jpg" class="d-block w-100" alt="...">
              </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </button>
          </div>



          <div class="container mt-4">
            <h3 id="oferta">Polecane</h3>
            <div class="col-md-2 mb-4">

            </div>

            <div class="row">

              @php
              $stones = DB::table('stones')
                ->select('img', 'name', 'description', 'price')
                ->inRandomOrder()
                ->limit(3)
                ->get();
              @endphp
              @foreach ($stones as $stone)
              @php
              $img = $stone->img;
              $name = $stone->name;
              $description = $stone->description;
              $price = $stone->price;
              @endphp
              <div class="col-md-4 mb-4">
                <div class="card">
                  <img src="{{ asset($img) }}" class="card-img-top" alt="Kamień 1">
                  <div class="card-body">
                    <h5 class="card-title">{{ $name }}</h5>
                    <p class="card-text">{{ $description }}</p>
                    <p class="card-text">{{ $price }} zł/1000kg</p>
                    <a href="#" class="btn btn-primary">Kup teraz</a>
                  </div>
                </div>
              </div>
              @endforeach
            </div>

    <div class="row justify-content-center">
            <div class="col-md-8">
                 <div class="text-center">
                    <a href="{{ route('main') }}" class="btn btn-primary">Pokaż pełną ofertę</a>
                </div>
            </div>
        </div>
    </div>






          <script src="js/bootstrap.min.js"></script>
      <script src="js/bootstrap.bundle.min.js"></script>
    </body>
</html>
