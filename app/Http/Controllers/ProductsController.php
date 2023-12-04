<?php
namespace App\Http\Controllers;

use App\Models\categories;
use App\Models\Category;
use App\Models\Parameter;
use App\Models\parameters;
use App\Models\Product;
use App\Models\products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductsController extends Controller
{
    public function index()
    {
        $products = products::with('categories', 'parameters')->get();
        $categories = categories::all();
        $parameters = parameters::all();
        return view('panels.panel_admina.products', compact('products', 'categories', 'parameters'));
    }
    public function index2()
    {
        $products = products::all();

        return view('main', compact('products'));    }
    public function index1($category)
    {
        $category = Categories::with('products')->findOrFail($category);
        $products = $category->products;
        return view('products', compact('products'));
    }
    public function store(Request $request)
    {
        // Sprawdź, czy dane dotyczące kategorii i parametrów są dostarczone w formularzu
        if ($request->has('categories') && is_array($request->input('categories'))) {
            $categories = $request->input('categories');
        } else {
            $categories = [];
        }

        if ($request->has('parameters') && is_array($request->input('parameters'))) {
            $parameters = $request->input('parameters');
        } else {
            $parameters = [];
        }

        // Tworzenie nowego produktu
        $product = new products;
        $product->name = $request->input('name');
        $product->odnosnik = $request->input('odnosnik');
        $product->ilosc = $request->input('ilosc');
        $product->cena = $request->input('cena');

        $product->opis = $request->input('opis');

        $product->save();

        // Przypisanie zaznaczonych kategorii i parametrów do produktu
        $product->categories()->attach($categories);
        $product->parameters()->attach($parameters);

        return redirect()->route('products.index')->with('success', 'Produkt został dodany.');
    }


    public function update(Request $request, $id)
    {
        $product = products::find($id);

        if ($product) {
            $product->name = $request->input('name');
            $product->odnosnik = $request->input('odnosnik');
            $product->ilosc = $request->input('ilosc');
            $product->cena = $request->input('cena');
            $product->opis = $request->input('opis');
            $product->save();

            if ($request->has('categories')) {
                $product->categories()->sync($request->input('categories'));
            }

            if ($request->has('parameters')) {
                $product->parameters()->sync($request->input('parameters'));
            }

            return redirect()->back()->with('success', 'Produkt został zaktualizowany.');
        }

        return redirect()->back()->with('error', 'Nie znaleziono produktu.');
    }

    public function destroy($id)
    {
        $product = products::find($id);

        if ($product) {
            $product->categories()->detach();
            $product->parameters()->detach();
            $product->delete();
            return redirect()->route('products.index')->with('success', 'Produkt został usunięty.');
        }

        return redirect()->route('products.index')->with('error', 'Nie znaleziono produktu.');
    }
    public function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // Adjust the file types and size as needed
        ]);

        $image = $request->file('image');
        $imageName = $image->getClientOriginalName(); // Use the original name of the uploaded file
        $image->move(public_path('images'), $imageName);

        return redirect()->back()->with('success', 'Obrazek zuploadowany');
    }
    public function show1($id)
    {
        $product = Products::findOrFail($id);

        return view('product', compact('product'));
    }


}
