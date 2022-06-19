<?php

namespace App\Http\Controllers;

use App\Models\Fournisseur;
use App\Models\Medicament;
use Illuminate\Http\Request;

class MedicamentController extends Controller
{
    public function medicaments()
    {
        return response()->json(Medicament::with(['fournisseur','entrees','factures','sorties'])
        ->whereNot('deleted',true)
        ->get());
    }

    public function getFournisseurs()
    {
        return response()->json(Fournisseur::all());
    }

    public function create(Request $request)
    {
        $medicament = Medicament::create([
            'libelle' => $request->libelle,
            'prix_achat' => $request->prix_achat,
            'prix_vente' => $request->prix_vente,
            'date_expiration' => $request->date_expiration,
            'qte_s' => $request->qte_s,
            'fournisseur_id' => $request->fournisseur_id,
        ]);

        return response()->json(['status' => true]);
    }

    public function update(Request $request)
    {
        $medicament = Medicament::find($request->id);

        $medicament->update([
            'libelle' => $request->libelle,
            'prix_achat' => $request->prix_achat,
            'prix_vente' => $request->prix_vente,
            'date_expiration' => $request->date_expiration,
            'qte_s' => $request->qte_s,
            'fournisseur_id' => $request->fournisseur_id,
        ]);

        return response()->json(['status' => true]);
    }

    public function delete(Request $request)
    {
        $medicament = Medicament::find($request->id);

        $medicament->update([
            'deleted' => true,
        ]);

        return response()->json(['status' => true]);
    }
    
}
