@extends('layouts.app')

@section('content')
<div class="container w-50">
    <form action="{{ route('user.updatePassword', ['user' => $user->id]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="old_password">Stare hasło:</label>
            <input type="password" required class="form-control" name="old_password">
        </div>

        <div class="form-group">
            <label for="new_password">Nowe hasło:</label>
            <input type="password" min="8" required class="form-control" name="new_password">
        </div>

        <div class="form-group">
            <label for="confirm_password">Potwierdź hasło:</label>
            <input type="password" required class="form-control" name="confirm_password">
        </div>

        <button type="submit" class="btn btn-primary">Zmień hasło</button>
    </form>
</div>
<div class="col-6 text-right">
        @if ($errors->any())
            <div class="alert alert-danger mt-3">
                @foreach ($errors->all() as $error)
                    {{ $error }}
                @endforeach
            </div>
        @elseif (session('success'))
            <div class="alert alert-success mt-3">
                {{ session('success') }}
            </div>
        @endif
    </div>
@endsection
