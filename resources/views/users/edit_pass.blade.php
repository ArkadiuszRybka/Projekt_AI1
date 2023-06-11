@extends('layouts.app')

@section('content')
<div class="container w-50">
    <form action="{{ route('user.updatePassword', ['user' => $user->id]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="old_password">Stare hasło:</label>
            <input type="password" class="form-control" name="old_password">
        </div>

        <div class="form-group">
            <label for="new_password">Nowe hasło:</label>
            <input type="password" class="form-control" name="new_password">
        </div>

        <div class="form-group">
            <label for="confirm_password">Potwierdź hasło:</label>
            <input type="password" class="form-control" name="confirm_password">
        </div>

        <button type="submit" class="btn btn-primary">Zmień hasło</button>
    </form>
</div>
@endsection
