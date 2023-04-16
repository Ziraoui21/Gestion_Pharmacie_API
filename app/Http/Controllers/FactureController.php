<?php

namespace App\Http\Controllers;

use App\Models\Facture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FactureController extends Controller
{
    public function factures()
    {
        return response()->json(
            Facture::with(['medicaments','client'])->get()
        );
    }

    public function confirmer(Request $request)
    {
        $facture = Facture::find($request->id);

        $facture->update(['prix_avance' => 0]);

        return response()->json(['status' => true]);
    }

    public function calcul(Request $request)
    {
        $res = DB::table('medicament_facture')
        ->select(DB::raw('sum(medicaments.prix_vente * qte) as HT'))
        ->join('medicaments','medicament_id','=','medicaments.id')
        ->where('facture_id',$request->id)->first();

        return response()->json($res);
    }
}
