<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
class UsersController extends Controller
{
    public function show($id)
{
    $user = User::findOrFail($id);

    // Sprawdź, czy zalogowany użytkownik ma dostęp do ustawień
    if (auth()->user()->id === $user->id) {
        return view('users.show', ['user' => $user]);
    } else {
        // Wyświetl komunikat o braku dostępu
        abort(403, 'Brak dostępu do tych ustawień.');
    }
}


    public function edit($id)
{
    $user = User::findOrFail($id);
    return view('users.edit_data', compact('user'));
}

public function update(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
        ]);

        $user->update($validatedData);

        return redirect()->route('users.show', ['id' => $user->id])->with('success', 'Dane zostały zaktualizowane.');
    }


    public function editPassword(User $user)
{
    return view('users.edit_pass', compact('user'));
}

    public function updatePassword(Request $request, User $user)
{
    $validatedData = $request->validate([
        'old_password' => 'required',
        'new_password' => 'required|min:8',
        'confirm_password' => 'required|same:new_password',
    ]);

    if (!Hash::check($validatedData['old_password'], $user->password)) {
        return redirect()->back()->with('error', 'Podane stare hasło jest nieprawidłowe.');
    }

    $user->password = Hash::make($validatedData['new_password']);
    $user->save();

    return redirect()->back()->with('success', 'Hasło zostało zmienione.');
}



}
