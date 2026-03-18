<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditDepense extends Model
{
    protected $table = 'audit_depenses';
    public $timestamps = false;

    protected $fillable = [
        'type_action', 'date_operation', 'n_depense',
        'nom_etab', 'ancien_depense', 'nouv_depense', 'utilisateur'
    ];
}
