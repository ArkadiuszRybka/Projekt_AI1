@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Profil użytkownika</div>

                <div class="card-body">
                    <div class="form-group row">
                        <label for="first_name" class="col-md-4 col-form-label text-md-right"><b>Imię: </b></label>
                        <span>{{ $user->first_name }}</span>
                    </div>

                    <div class="form-group row">
                        <label for="last_name" class="col-md-4 col-form-label text-md-right"><b>Nazwisko: </b></label>
                        <span>{{ $user->last_name }}</span>
                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-md-4 col-form-label text-md-right"><b>Email</b></label>
                        <span>{{ $user->email }}</span>
                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-md-4 col-form-label text-md-right"><b>Adres</b></label>
                        <span>{{ $user->address }}</span>
                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-md-4 col-form-label text-md-right"><b>Miasto</b></label>
                        <span>{{ $user->city }}</span>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <a href="{{ route('user.editPassword', ['user' => $user->id]) }}" class="btn btn-primary">Zmień hasło</a>
                            <a href="{{ route('user.edit', ['user' => $user->id]) }}" class="btn btn-primary">Zmień dane</a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
