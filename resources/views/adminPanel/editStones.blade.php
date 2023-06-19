@extends('layouts.app')

@section('content')
<style>
    @media (max-width: 576px) {
        #addStoneForm {
            display: block;
        }

        .col-md-4 {
            flex: 0 0 100%;
            max-width: 100%;
        }
    }
</style>

<div class="container">
    <div class="row">
        <div class="col-md-12 mb-4">
            <button class="btn btn-primary" id="addStoneButton">Dodaj</button>
        </div>
        <div class="col-md-12 mb-4" id="addStoneForm" style="display: none;">
            <form action="" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="name"><b>Nazwa</b></label>
                    <input type="text" class="form-control" name="name" id="name">
                </div>
                <div class="form-group">
                    <label for="description"><b>Opis</b></label>
                    <textarea class="form-control" name="description" id="description" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label for="price"><b>Cena</b></label>
                    <input type="text" class="form-control" name="price" id="price">
                </div>
                <div class="form-group">
                    <label for="image"><b>Obrazek</b></label>
                    <input type="file" class="form-control" name="img" id="img">
                </div>
                <button type="submit" class="btn btn-primary">Zatwierdź</button>
            </form>
        </div>
        @foreach ($stones as $stone)
        <div class="col-md-4 col-sm-6 mb-4">
            <div class="card">
                <img src="{{ asset($stone->img) }}" class="card-img-top" alt="Kamień 1">
                <div class="card-body">
                    <form action="{{ route('stones.update', ['stone' => $stone->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Nazwa:</label>
                            <input type="text" class="form-control" name="name" value="{{ $stone->name }}">
                        </div>

                        <div class="form-group">
                            <label for="description">Opis:</label>
                            <textarea class="form-control" name="description">{{ $stone->description }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="price">Cena:</label>
                            <input type="number" class="form-control" name="price" min="1" value="{{ $stone->price }}">
                        </div>
                        <div class="form-group">
                            <input type="file" class="form-control" name="img" id="img">
                        </div>
                        <button type="submit" class="btn btn-primary">Zatwierdź</button>
                        <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $stone->id }})">Usuń</button>
                    </form>

                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<script>
    document.getElementById('addStoneButton').addEventListener('click', function() {
        document.getElementById('addStoneForm').style.display = 'block';
    });
</script>
<script>
    function confirmDelete(stoneId) {
        if (confirm("Czy na pewno chcesz usunąć ten kamień?")) {
            // Wysyłanie żądania do routy deleteStone
            fetch("{{ url('delete-stone') }}/" + stoneId, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => {
                if (response.ok) {
                   location.reload();
                } else {
                    // Obsłuż błąd, jeśli wystąpił
                    console.error('Wystąpił błąd podczas usuwania kamienia.');
                }
            })
            .catch(error => {
                console.error('Wystąpił błąd podczas usuwania kamienia:', error);
            });
        }
    }
</script>


@endsection
