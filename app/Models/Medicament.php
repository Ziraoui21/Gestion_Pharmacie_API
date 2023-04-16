<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicament extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['libelle','prix_achat','prix_vente','qte_s','date_expiration','fournisseur_id','deleted'];


    public function fournisseur()
    {
        return $this->belongsTo(Fournisseur::class);
    }

    public function entrees()
    {
       return $this->hasMany(Entree::class);
    }

    public function sorties()
    {
        return $this->hasMany(Sortie::class);
    }

    public function factures()
    {
        return $this->belongsToMany(Facture::class,"medicament_facture",)->withPivot([
            'qte',
            'created_at'
        ]);
    }
}
