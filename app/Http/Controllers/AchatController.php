<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Facture;
use App\Models\Medicament;
use App\Models\Medicament_facture;
use App\Models\Sortie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AchatController extends Controller
{

    public function clients()
    {
        return response()->json(
            Client::with('factures')
            ->whereNot('deleted',true)
            ->get()
        );
    }

    public function medicaments()
    {
        return response()->json(Medicament::whereNot('deleted',true)
        ->whereNot('date_expiration','<',now())
        ->get());
    }

    public function create_sortie(Request $request)
    {
        $sortie = Sortie::create([
            'medicament_id' => $request->medicament_id,
            'qte' => $request->qte,
            'date_sortie' => now()
        ]);

        $med = Medicament::find($request->medicament_id);
        $med->update([
            'qte_s' => $med->qte_s - $request->qte
        ]);

        return response()->json(['status' => true]);
    }

    public function create_facture(Request $request)
    {
        $facture = Facture::create([
            'client_id' => $request->client_id,
            'prix_avance' => ($request->has('prix_avance'))?$request->prix_avance:0,
            'date_facture' => now(),
            'heure_facture' => now()
        ]);

        $list = json_decode($request->medicaments_facture,true);

        foreach($list as $achat)
        {
            Medicament_facture::create([
                'qte' => $achat['qte'],
                'medicament_id' => $achat['medicament_id'],
                'facture_id' => $facture->id,
            ]);

            $med = Medicament::find($achat['medicament_id']);
            $med->update([
                'qte_s' => $med->qte_s - $achat['qte']
            ]);
        }

        return response()->json(['status' =>true]);
    }
}
