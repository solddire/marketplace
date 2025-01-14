<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ad;

class AdController extends Controller
{
    public function index(Request $request)
    {
        $ads = Ad::query();

        if ($request->has('category_id')) {
            $ads->where('category_id', $request->category_id);
        }

        if ($request->has('subcategory_id')) {
            $ads->where('subcategory_id', $request->subcategory_id);
        }

        return $ads->get();
    }
}
