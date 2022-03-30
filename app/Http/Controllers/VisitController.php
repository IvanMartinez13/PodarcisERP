<?php

namespace App\Http\Controllers;

use App\Models\Vao;
use App\Models\Visit;
use Illuminate\Http\Request;

class VisitController extends Controller
{
    public function details($token)
    {
        $visit = Visit::where('token', $token)->with('users')->first();

        $vao = Vao::where('id', $visit->vao_id)->first();

        return view('pages.vao.visits.details', compact('vao', 'visit'));
    }
}
