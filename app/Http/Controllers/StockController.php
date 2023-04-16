<?php

namespace App\Http\Controllers;

use App\Mail\CommanderMail;
use App\Models\Fournisseur;
use App\Models\Medicament;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class StockController extends Controller
{
    public function medicaments()
    {
        return response()->json(
            Medicament::with('fournisseur')->whereNot('deleted',true)->get()
        );
    }

    public function commander(Request $request)
    {
        $fournisseur = Fournisseur::find($request->idF);
        $medicament = Medicament::find($request->idM);

        Mail::to($fournisseur->email)
        ->send(new CommanderMail($request->qte,$medicament->libelle));

        return response()->json(['status' => true]);
    }
}
