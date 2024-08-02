<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use IcehouseVentures\LaravelMermaid\Facades\Mermaid;

class UserController extends Controller
{
    public function show() {
        $collection = User::with('posts')->get();
        
        $mermaid = Mermaid::build()->generateDiagramFromCollection($collection);

        return view('from-user-model', compact('mermaid'));
    }
}
