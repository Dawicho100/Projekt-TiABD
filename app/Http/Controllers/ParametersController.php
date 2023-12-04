<?php

namespace App\Http\Controllers;

use App\Models\Parameters;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ParametersController extends Controller
{
    public function index()
    {
        $parameters = Parameters::all();
        return view('panels.panel_admina.parameters', ['parameters' => $parameters]);
    }

    public function store(Request $request)
    {
        $parameter = new Parameters;
        $parameter->name = $request->input('name');
        $parameter->save();
        return redirect()->route('parameters.index')->with('success', 'Parametr został dodany.');
    }

    public function update(Request $request, $id)
    {
        // Pobierz dane z żądania AJAX
        $newName = $request->input('name');

        // Znajdź rekord w bazie danych do zaktualizowania
        $parameter = Parameters::find($id);

        if (!$parameter) {
            Session::flash('error', 'Rekord nie znaleziony');
        } else {
            // Dokonaj aktualizacji rekordu
            $parameter->name = $newName;
            $parameter->save();
            Session::flash('success', 'Rekord zaktualizowany pomyślnie');
        }

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        $parameter = Parameters::find($id);
        if ($parameter) {
            $parameter->delete();
        }
        return redirect()->route('parameters.index')->with('success', 'Parametr został usunięty.');
    }

    public function delete($id)
    {
        // Znajdź rekord w bazie danych do usunięcia
        $parameter = Parameters::find($id);

        if (!$parameter) {
            return response()->json(['error' => 'Rekord nie znaleziony'], 404);
        }

        // Usuń parametr
        $parameter->delete();

        return response()->json(['success' => 'Parametr usunięty pomyślnie']);
    }
}
