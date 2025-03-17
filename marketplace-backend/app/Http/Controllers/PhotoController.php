<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PhotoController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|max:2048' // максимум 2MB
        ]);

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            
            // Сохраняем файл в storage/app/public/avatars
            $path = $file->storeAs('avatars', $filename, 'public');
            
            // Получаем URL для сохранения в базу данных
            $url = Storage::url($path);
            
            // Обновляем аватар пользователя
            $user = auth()->user();
            $user->avatar = $url;
            $user->save();
            
            return response()->json([
                'success' => true,
                'avatar' => $url
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Файл не был загружен'
        ], 400);
    }
} 