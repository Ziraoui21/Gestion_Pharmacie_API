<?php

namespace App\Http\Controllers;

use App\Models\Fournisseur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FournisseurController extends Controller
{
    public function fournisseurs()
    {
        return response()->json(
            Fournisseur::with(['medicaments' =>function($q){
                return $q->whereNot('deleted',true);
            }])->get()
        );
    }

    public function create(Request $request)
    {
        $email = $request->only('email');
        $tele = $request->only('tele');

        $request_email = [
            'email' => 'unique:fournisseurs,email',
        ];

        $request_tele = [
            'tele' => 'unique:fournisseurs,tele',
        ];

        $validatorEmail = Validator::make($email, $request_email);
        $validatorTele = Validator::make($tele, $request_tele);

        if(!$validatorEmail->fails() && !$validatorTele->fails())
        {
            Fournisseur::create($request->all());
            return response()->json(['status' => true]);
        }

        if($validatorTele->fails() && $validatorEmail->fails())
            return response()->json(['status' => false,'teleNotValid' => true,'emailNotValid' => true]);

        if($validatorTele->fails())
            return response()->json(['status' => false,'teleNotValid' => true]);
        
        if($validatorEmail->fails())
            return response()->json(['status' => false,'emailNotValid' => true]);
    }

    public function update(Request $request)
    {
        if($this->checkEmail($request) && $this->checkTele($request))
        {
            $fournisseur = Fournisseur::find($request->id);
            $fournisseur->update($request->all());

            return response()->json(['status' => true]);
        }

        if(!$this->checkTele($request) && !$this->checkEmail($request))
            return response()->json(['status' => false,'teleNotValid' => true,'emailNotValid' => true]);

        if(!$this->checkTele($request))
            return response()->json(['status' => false,'teleNotValid' => true]);
        
        if(!$this->checkEmail($request))
            return response()->json(['status' => false,'emailNotValid' => true]);
    }

    public function checkEmail(Request $request)
    {
        $input = $request->only('email');

        $request_data = [
            'email' => 'unique:fournisseurs,email,'.$request->id,
        ];

        $validator = Validator::make($input, $request_data);

        if($validator->fails())
            return false;
        else
            return true;
    }

    public function checkTele(Request $request)
    {
        $input = $request->only('tele');

        $request_data = [
            'tele' => 'unique:fournisseurs,tele,'.$request->id,
        ];

        $validator = Validator::make($input, $request_data);

        if($validator->fails())
            return false;
        else
            return true;
    }

}
