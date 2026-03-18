<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Etablissement extends Model
{
    protected $table = 'etablissements';
    protected $primaryKey = 'n_etab';

    protected $fillable = ['nom', 'montant_budget'];

    public function depenses()
    {
        return $this->hasMany(Depense::class, 'n_etab', 'n_etab');
    }
}
