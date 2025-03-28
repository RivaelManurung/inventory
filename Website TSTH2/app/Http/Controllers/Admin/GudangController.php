<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GudangController extends Controller
{
    public function index()
    {
        return response()->json(['message' => 'Gudang index']);
    }

    public function store(Request $request)
    {
        return response()->json(['message' => 'Gudang created']);
    }

    // ... tambahkan method lainnya sesuai route
}