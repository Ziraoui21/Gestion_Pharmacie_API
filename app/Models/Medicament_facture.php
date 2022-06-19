<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Medicament_facture extends Pivot
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'medicament_facture';

    public function medicament()
    {
        return $this->belongsTo(Medicament::class);
    }

    public function facture()
    {
        return $this->belongsTo(Facture::class);
    }
}
