@extends('layouts.app')

@section('content')
    <div class="container w-50">
        <form action="{{ route('users.update', ['user' => $user->id]) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="first_name">Imię:</label>
                <input type="text" class="form-control" name="first_name" value="{{ $user->first_name }}" required>
            </div>

            <div class="form-group">
                <label for="last_name">Nazwisko:</label>
                <input type="text" class="form-control" name="last_name" value="{{ $user->last_name }}" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" name="email" value="{{ $user->email }}" required>
            </div>

            <div class="form-group">
                <label for="address">Adres:</label>
                <input type="text" class="form-control" name="address" value="{{ $user->address }}" required>
            </div>

            <div class="form-group">
                <label for="city">Miasto:</label>
                <input type="text" class="form-control" name="city" value="{{ $user->city }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Zapisz zmiany</button>
        </form>
    </div>
@endsection
