<?php

namespace App\Http\Controllers;

use App\Models\categories; // Zaktualizowano import modelu
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CategoriesController extends Controller
{
    public function index()
    {
        $categories = categories::all(); // Zaktualizowano nazwę modelu
        return view('panels.panel_admina.categories', ['categories' => $categories]); // Zaktualizowano nazwę widoku
    }
    public function index1()
    {
        $categories = categories::all();
        return view('categories.index', compact('categories'));
    }
    public function store(Request $request)
    {
        $category = new categories; // Zaktualizowano nazwę modelu
        $category->name = $request->input('name');
        $category->save();
        return redirect()->route('categories.index')->with('success', 'Kategoria została dodana.'); // Zaktualizowano nazwę trasy
    }

    public function edit($id)
    {
        $category = categories::find($id); // Zaktualizowano nazwę modelu
        return view('panels.panel_admina.categories', ['category' => $category]); // Zaktualizowano nazwę widoku
    }

    public function update(Request $request, $id)
    {
        // Pobierz dane z żądania AJAX
        $newName = $request->input('name');

        // Znajdź rekord w bazie danych do zaktualizowania
        $category = categories::find($id); // Zaktualizowano nazwę modelu

        if (!$category) {
            Session::flash('error', 'Rekord nie znaleziony');
        } else {
            // Dokonaj aktualizacji rekordu
            $category->name = $newName;
            $category->save();
            Session::flash('success', 'Rekord zaktualizowany pomyślnie');
        }

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        $category = categories::find($id); // Zaktualizowano nazwę modelu
        if ($category) {
            $category->delete();
        }
        return redirect()->route('categories.index')->with('success', 'Kategoria została usunięta.'); // Zaktualizowano nazwę trasy
    }

    public function delete($id)
    {
        // Znajdź rekord w bazie danych do usunięcia
        $category = categories::find($id); // Zaktualizowano nazwę modelu

        if (!$category) {
            return response()->json(['error' => 'Rekord nie znaleziony'], 404);
        }

        // Usuń kategorię
        $category->delete();

        return response()->json(['success' => 'Kategoria usunięta pomyślnie']);
    }
}
