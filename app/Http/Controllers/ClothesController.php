<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clothes;
use Illuminate\Support\Facades\Auth;

class ClothesController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $clothes = Clothes::where('user_id', $userId)->get();
    
        return response()->json($clothes);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'image' => 'nullable|string',
        ]);

        $clothingItem = Clothes::create([
            'name' => $request->name,
            'category' => $request->category,
            'image' => $request->image,
            'user_id' => Auth::id()
        ]);

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

    $clothingItem = Clothes::where('id', $id)->where('user_id', Auth::id())->first();

    if (!$clothingItem) {
        return response()->json(['error' => 'Item not found or unauthorized'], 403);
    }

    $clothingItem->update($request->only(['name', 'category', 'image']));

    return response()->json(['message' => 'Item updated successfully', 'item' => $clothingItem], 200);
    }
}
