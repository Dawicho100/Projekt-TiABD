<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dostawa;
use Illuminate\Support\Facades\Session;

class DostawaController extends Controller
{
    public function index()
    {
        $dostawy = Dostawa::all();
        return view('panels.panel_admina.dostawa', ['dostawy' => $dostawy]);
    }

    public function store(Request $request)
    {
        $dostawa = new Dostawa;
        $dostawa->name = $request->input('name');
        $dostawa->cena = $request->input('cena');
        $dostawa->how_long = $request->input('how_long');
        $dostawa->save();
        return redirect()->route('dostawy.index')->with('success', 'Dostawa została dodana.');
    }

    public function edit($id)
    {
        $dostawa = Dostawa::find($id);
        return view('dostawy.edit', ['dostawa' => $dostawa]);
    }

    public function update(Request $request, $id)
    {
        // Pobierz dane z żądania AJAX
        $newName = $request->input('name');
        $newCena = $request->input('cena');
        $newHowLong = $request->input('how_long');

        // Znajdź rekord w bazie danych do zaktualizowania
        $dostawa = Dostawa::find($id);

        if (!$dostawa) {
            Session::flash('error', 'Rekord nie znaleziony');
        } else {
            // Dokonaj aktualizacji rekordu
            $dostawa->name = $newName;
            $dostawa->cena = $newCena;
            $dostawa->how_long = $newHowLong;
            $dostawa->save();
            Session::flash('success', 'Rekord zaktualizowany pomyślnie');
        }

        return response()->json(['success' => true]);
    }



    public function destroy($id)
    {
        $dostawa = Dostawa::find($id);
        if ($dostawa) {
            $dostawa->delete();
        }
        return redirect()->route('dostawy.index')->with('success', 'Dostawa została usunięta.');
    }
    public function delete($id)
    {
        // Znajdź rekord w bazie danych do usunięcia
        $dostawa = Dostawa::find($id);

        if (!$dostawa) {
            return response()->json(['error' => 'Rekord nie znaleziony'], 404);
        }

        // Usuń dostawę
        $dostawa->delete();

        return response()->json(['success' => 'Dostawa usunięta pomyślnie']);
    }
}

