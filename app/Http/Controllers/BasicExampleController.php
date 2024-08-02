<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use IcehouseVentures\LaravelMermaid\Facades\Mermaid;

class BasicExampleController extends Controller
{
    public function show() {
        $data = [
            'A-->B',
            'A-->C',
            'B-->D',
            'C-->D',
        ];
        
        $mermaid = Mermaid::build()->generateDiagramFromArray($data);

        return view('basic', compact('mermaid'));
    }
}
