<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facture extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['prix_avance','date_facture','heure_facture','client_id'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function medicaments()
    {
        return $this->belongsToMany(Medicament::class,"medicament_facture")->withPivot('qte');
    }

    public function medicaments_facture()
    {
        return $this->hasMany(Medicament_facture::class);
    }
}
