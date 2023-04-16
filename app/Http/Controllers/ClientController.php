<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Medicament_facture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
    public function clients()
    {
        return response()->json(
            Client::with('factures')
            ->whereNot('deleted',true)
            ->get()
        );
    }

    public function create(Request $request)
    {
        if($this->checkTele($request))
        {
            $client = Client::create($request->all());

            return response()->json(['status' => true]);
        }
        else
        {
            return response()->json(['status' => false]);
        }
    }

    public function checkTele(Request $request)
    {
        $input = $request->only('tele');

        $request_data = [
            'tele' => 'unique:clients,tele'
        ];

        $validator = Validator::make($input, $request_data);

        if($validator->fails())
            return false;
        else
            return true;
    }

    public function update(Request $request)
    {
        $input = $request->only('tele');

        $request_data = [
            'tele' => 'unique:clients,tele,'.$request->id
        ];

        $validator = Validator::make($input, $request_data);

        if(!$validator->fails())
        {
            $client = Client::find($request->id);

            $client->update($request->all());

            return response()->json(['status' => true]);
        }
        
        return response()->json(['status' => false]);
    }

    public function delete(Request $request)
    {
        $client = Client::find($request->id);
        $client->update([
            'deleted' => true
        ]);

        return response()->json(['status' => true]);
    }
}
