<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class EditUsersController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('adminPanel.editUsers', compact('users'));
    }

    public function deleteUser($id)
{
    $user = User::findOrFail($id);
    $user->delete();

    return redirect()->back()->with('success', 'Użytkownik został pomyślnie usunięty.');
}

}
