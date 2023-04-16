<?php

namespace App\Http\Controllers;

use App\Models\Medicament_facture;
use App\Models\Sortie;
use Illuminate\Http\Request;

class VentesController extends Controller
{
    public function ventes()
    {
        return response()->json(
            [
                "sorties" => Sortie::with('medicament')->get(),
                "medicaments_facture" => Medicament_facture::with('medicament')->get()
            ]
        );
    }
}
