<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clothes;

class ClothesController extends Controller
{
    public function index()
    {
        return response()->json(Clothes::all());
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'image' => 'nullable|string',
        ]);

        $clothingItem = Clothes::create($request->all());

        return response()->json(['message' => 'Item added successfully', 'item' => $clothingItem], 201);
    }
    public function destroy($id)
    {
        $item = Clothes::findOrFail($id);
        $item->delete();

        return response()->json(['message' => 'Item deleted successfully']);
    }
    public function update(Request $request, $id)
    {
    $request->validate([
        'name' => 'required|string|max:255',
        'category' => 'required|string|max:255',
        'image' => 'required|string'
    ]);

    $clothingItem = Clothes::find($id);

    if (!$clothingItem) {
        return response()->json(['error' => 'Item not found'], 404);
    }

    $clothingItem->name = $request->input('name');
    $clothingItem->category = $request->input('category');
    $clothingItem->image = $request->input('image');
    $clothingItem->save();

    return response()->json(['message' => 'Item updated successfully', 'item' => $clothingItem], 200);
    }
}
