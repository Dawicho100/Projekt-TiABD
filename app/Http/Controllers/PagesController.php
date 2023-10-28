<?php

namespace App\Http\Controllers;

use App\Models\Pages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PagesController extends Controller
{
    public function index()
    {
        $pages = Pages::all();
        return view('panels.panel_admina.pages', ['pages' => $pages]);
    }

    public function store(Request $request)
    {
        $page = new Pages();
        $page->name = $request->input('name');
        $page->text = $request->input('text');
        $page->slug = $request->input('slug');
        $page->save();
        return redirect()->route('pages.index')->with('success', 'Strona została dodana.');
    }

    public function update(Request $request, $id)
    {
        $page = Pages::find($id);

        if (!$page) {
            Session::flash('error', 'Rekord nie znaleziony');
        } else {
            $page->name = $request->input('name');
            $page->text = $request->input('text');
            $page->slug = $request->input('slug');
            $page->save();
            Session::flash('success', 'Strona zaktualizowana pomyślnie');
        }

        return response()->json(['success' => true]);
    }

    public function delete($id)
    {
        $page = Pages::find($id);

        if (!$page) {
            return response()->json(['error' => 'Rekord nie znaleziony'], 404);
        }

        $page->delete();

        return response()->json(['success' => 'Strona usunięta pomyślnie']);
    }
}
