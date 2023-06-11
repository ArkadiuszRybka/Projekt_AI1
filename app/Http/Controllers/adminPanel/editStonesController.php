<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Stone;

class EditStonesController extends Controller
{
    public function index()
    {
        $stones = Stone::all();
        return view('adminPanel.editStones', compact('stones'));
    }


    public function update(Request $request, Stone $stone)
{
    $stone->name = $request->input('name');
    $stone->description = $request->input('description');
    $stone->price = $request->input('price');
    $stone->img = $request->input('img');
    $stone->save();

    return redirect()->back()->with('success', 'Informacje o kamieniu zostały zaktualizowane.');
}

public function store(Request $request)
{
    $stone = new Stone();
    $stone->name = $request->input('name');
    $stone->description = $request->input('description');
    $stone->price = $request->input('price');
    $stone->img = $request->input('img');


    $stone->save();

    return redirect()->route('editStones')->with('success', 'Kamień został dodany do bazy danych.');
}

public function deleteStone($stone)
{
    $stone = Stone::find($stone);
    $stone->delete();

    return redirect()->back()->with('success', 'Kamień został usunięty.');

}


}
