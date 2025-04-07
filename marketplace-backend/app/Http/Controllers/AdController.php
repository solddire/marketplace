<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use Illuminate\Http\Request;

class AdController extends Controller
{
    // Получение всех объявлений
    public function index()
    {
        return response()->json(Ad::all());
    }

    // Создание нового объявления
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'nullable|numeric',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'nullable|exists:subcategories,id',
        ]);

        $ad = Ad::create($validated);

        return response()->json($ad, 201);
    }

    // Просмотр конкретного объявления
    public function show($id)
    {
        $ad = Ad::findOrFail($id);
        return response()->json($ad);
    }

    // Обновление объявления
    public function update(Request $request, $id)
    {
        $ad = Ad::findOrFail($id);

        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'price' => 'nullable|numeric',
            'category_id' => 'sometimes|exists:categories,id',
            'subcategory_id' => 'nullable|exists:subcategories,id',
        ]);

        $ad->update($validated);

        return response()->json($ad);
    }

    // Удаление объявления
    public function destroy($id)
    {
        $ad = Ad::findOrFail($id);
        $ad->delete();

        return response()->json(['message' => 'Объявление удалено']);
    }
}
