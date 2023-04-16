<?php

namespace App\Http\Controllers;

use App\Models\Entree;
use App\Models\Medicament;
use Illuminate\Http\Request;

class EntreeController extends Controller
{
    public function medicaments()
    {
        return response()->json(
            Medicament::with('fournisseur')->whereNot('deleted',true)->get()
        );
    }

    public function create(Request $request)
    {
        $medicament = Medicament::find($request->id);
        $entree = Entree::create([
            'medicament_id' => $medicament->id,
            'qte' => $request->qte,
            'date_entree' => now()
        ]);

        $medicament->update([
            'qte_s' => $medicament->qte_s + $entree->qte
        ]);

        return response()->json(['status' => true]);
    }
}
