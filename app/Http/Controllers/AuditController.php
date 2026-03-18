<?php

namespace App\Http\Controllers;

use App\Models\AuditDepense;

class AuditController extends Controller
{
    public function index()
    {
        $audits = AuditDepense::orderBy('date_operation', 'desc')->get();

        $nbInsertions    = AuditDepense::where('type_action', 'Ajout')->count();
        $nbModifications = AuditDepense::where('type_action', 'Modification')->count();
        $nbSuppressions  = AuditDepense::where('type_action', 'Suppression')->count();

        return view('audit.index', compact(
            'audits', 'nbInsertions', 'nbModifications', 'nbSuppressions'
        ));
    }
}
