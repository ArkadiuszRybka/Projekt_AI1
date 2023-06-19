@extends('layouts.app')

@section('content')


<div class="container">
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Imię</th>
                    <th>Nazwisko</th>
                    <th>Email</th>
                    <th>Adres</th>
                    <th>Miasto</th>
                    <th>Akcje</th> <!-- Nowa kolumna dla przycisków "Usuń" -->
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    @if ($user->isAdmin!=1)
                    <td><span>{{ $user->id }}</span></td>
                    <td><span>{{ $user->first_name }}</span></td>
                    <td><span>{{ $user->last_name }}</span></td>
                    <td><span>{{ $user->email }}</span></td>
                    <td><span>{{ $user->address }}</span></td>
                    <td><span>{{ $user->city }}</span></td>
                    <td>
                        <form action="{{ route('deleteUser', $user->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Usuń</button>
                        </form>
                    </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<style>
    @media (max-width: 576px) {
        .card-body {
            overflow-x: auto;
        }

        .card-body table {
            width: 100%;
        }

        .card-body table th,
        .card-body table td {
            white-space: nowrap;
        }
    }
</style>
@endsection
