<?php

namespace App\Http\Controllers;

use App\Models\Platnosci; // Zaktualizowano import modelu
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PlatnosciController extends Controller
{
    public function index()
    {
        $platnosci = Platnosci::all(); // Zaktualizowano nazwę modelu
        return view('panels.panel_admina.platnosci', ['platnosci' => $platnosci]); // Zaktualizowano nazwę widoku
    }

    public function store(Request $request)
    {
        $platnosc = new Platnosci; // Zaktualizowano nazwę modelu
        $platnosc->name = $request->input('name');
        $platnosc->save();
        return redirect()->route('platnosci.index')->with('success', 'Platnosc została dodana.'); // Zaktualizowano nazwę trasy
    }

    public function edit($id)
    {
        $platnosc = Platnosci::find($id); // Zaktualizowano nazwę modelu
        return view('panels.panel_admina.platnosci', ['platnosc' => $platnosc]); // Zaktualizowano nazwę widoku
    }

    public function update(Request $request, $id)
    {
        // Pobierz dane z żądania AJAX
        $newName = $request->input('name');

        // Znajdź rekord w bazie danych do zaktualizowania
        $platnosc = Platnosci::find($id); // Zaktualizowano nazwę modelu

        if (!$platnosc) {
            Session::flash('error', 'Rekord nie znaleziony');
        } else {
            // Dokonaj aktualizacji rekordu
            $platnosc->name = $newName;
            $platnosc->save();
            Session::flash('success', 'Rekord zaktualizowany pomyślnie');
        }

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        $platnosc = Platnosci::find($id); // Zaktualizowano nazwę modelu
        if ($platnosc) {
            $platnosc->delete();
        }
        return redirect()->route('platnosci.index')->with('success', 'Platnosc została usunięta.'); // Zaktualizowano nazwę trasy
    }

    public function delete($id)
    {
        // Znajdź rekord w bazie danych do usunięcia
        $platnosc = Platnosci::find($id); // Zaktualizowano nazwę modelu

        if (!$platnosc) {
            return response()->json(['error' => 'Rekord nie znaleziony'], 404);
        }

        // Usuń platnosc
        $platnosc->delete();

        return response()->json(['success' => 'Platnosc usunięta pomyślnie']);
    }
}
