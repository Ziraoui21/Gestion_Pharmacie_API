<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function get_infos()
    {
        $ventes1 = DB::table('medicament_facture')
        ->select(DB::raw('sum(medicaments.prix_vente * qte) as total_ventes1'))
        ->join('medicaments','medicament_id','=','medicaments.id')
        ->first()->total_ventes1;

        $ventes2 = DB::table('sorties')
        ->select(DB::raw('sum(medicaments.prix_vente * qte) as total_ventes2'))
        ->join('medicaments','medicaments.id','=','medicament_id')
        ->first()->total_ventes2;

        $ventesJrs1 = DB::table('factures')
        ->select(DB::raw('sum(medicaments.prix_vente * medicament_facture.qte) as ventes_jour'))
        ->join('medicament_facture','medicament_facture.facture_id','=','factures.id')
        ->join('medicaments','medicament_facture.medicament_id','=','medicaments.id')
        ->where('factures.date_facture',now()->toDateString())
        ->first()->ventes_jour;

        $ventesJrs2 = DB::table('sorties')
        ->select(DB::raw('sum(medicaments.prix_vente * qte) as ventes_jour'))
        ->join('medicaments','medicament_id','=','medicaments.id')
        ->where('date_sortie',now()->toDateString())
        ->first()->ventes_jour;

        $ventesMois1 = DB::table('sorties')
        ->select(DB::raw('sum(medicaments.prix_vente * qte) as ventes_mois'))
        ->join('medicaments','medicament_id','=','medicaments.id')
        ->whereYear('date_sortie',now()->year)
        ->whereMonth('date_sortie',now()->month)
        ->first()->ventes_mois;

        $ventesMois2 = DB::table('factures')
        ->select(DB::raw('sum(medicaments.prix_vente * medicament_facture.qte) as ventes_mois'))
        ->join('medicament_facture','medicament_facture.facture_id','=','factures.id')
        ->join('medicaments','medicament_facture.medicament_id','=','medicaments.id')
        ->whereYear('factures.date_facture',now()->year)
        ->whereMonth('factures.date_facture',now()->month)
        ->first()->ventes_mois;


        return response()->json([
            'total_ventes' => $ventes1 + $ventes2,
            'ventes_jour' => $ventesJrs1 + $ventesJrs2,
            'ventes_mois' => $ventesMois1 + $ventesMois2,
            'avances_total' => DB::table('factures')
                ->select(DB::raw('sum(prix_avance) as avances_total'))
                ->first()->avances_total,
            'nombre_clients' => DB::table('clients')
                ->select(DB::raw('count(*) as nombre_clients'))
                ->whereNot('deleted',true)
                ->first()->nombre_clients,
            'nombre_medicaments' => DB::table('medicaments')
                ->select(DB::raw('count(*) as nombre_medicaments'))
                ->whereNot('deleted',true)
                ->first()->nombre_medicaments,
            'medicaments_date_expire' => DB::table('medicaments')
                ->select(DB::raw('count(*) as medicaments_date_expire'))
                ->whereNot('deleted',true)
                ->where('date_expiration','<',now())
                ->first()->medicaments_date_expire,
            'medicaments_qte_expire' =>  DB::table('medicaments')
                ->select(DB::raw('count(*) as medicaments_qte_expire'))
                ->whereNot('deleted',true)
                ->where('qte_s',0)
                ->first()->medicaments_qte_expire,
            'factues_non_confirme' => DB::table('factures')
                ->select(DB::raw('count(*) as factues_non_confirme'))
                ->where('prix_avance','<>',0)
                ->first()->factues_non_confirme,
            'factures_confirme' => DB::table('factures')
                ->select(DB::raw('count(*) as factues_confirme'))
                ->where('prix_avance',0)
                ->first()->factues_confirme,
            'entree_jour' => DB::table('entrees')
                ->select(DB::raw('count(*) as entree_jour'))
                ->whereDay('date_entree',now()->day)
                ->whereYear('date_entree',now()->year)
                ->whereMonth('date_entree',now()->month)
                ->first()->entree_jour
        ]);
    }
}
