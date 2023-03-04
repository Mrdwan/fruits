<?php

namespace App\Http\Controllers;

use App\Models\Fruit;
use Illuminate\Http\Request;

class FavoritedFruitsController extends Controller
{
    public function index()
    {
        return view('favorited-fruits', [
            'fruits' => Fruit::with('family')->favorited()->paginate(9)
        ]);
    }

    public function update(Request $request, int $id)
    {
        $fruit = Fruit::findOrFail($id);

        if (Fruit::favorited()->count() >= 10 && ! $fruit->is_favorited) {
            return redirect()->back()->with('message', 'you can not favorite more than 10 fruits');
        }

        $fruit->toggleFavorite();

        return redirect()->back();
    }
}
