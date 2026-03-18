<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Depense extends Model
{
    protected $table = 'depenses';
    protected $primaryKey = 'n_depense';

    protected $fillable = ['n_etab', 'depense'];

    public function etablissement()
    {
        return $this->belongsTo(Etablissement::class, 'n_etab', 'n_etab');
    }
}
