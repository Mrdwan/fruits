<?php

namespace App\Http\Controllers;

use App\Models\Fruit;
use App\Models\FruitFamily;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $fruits = Fruit::with('family')
            ->when($request->has('family') && !empty($request->family), function($q) use ($request) {
                return $q->where('fruit_family_id', $request->family);
            })->when($request->has('name'), function($q) use ($request) {
                return $q->where('name', "like", "%{$request->name}%");
            });

        return view('home', [
            'fruits' => $fruits->paginate(9),
            'families' => FruitFamily::all()
        ]);
    }
}
