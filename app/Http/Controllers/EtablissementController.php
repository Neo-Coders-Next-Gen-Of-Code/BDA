<?php

namespace App\Http\Controllers;

use App\Models\Etablissement;
use Illuminate\Http\Request;

class EtablissementController extends Controller
{
    public function index()
    {
        $etablissements = Etablissement::orderBy('n_etab')->get();
        return view('etablissements.index', compact('etablissements'));
    }

    public function create()
    {
        return view('etablissements.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom'            => 'required|string|max:100',
            'montant_budget' => 'required|numeric|min:0',
        ]);

        Etablissement::create($request->only('nom', 'montant_budget'));

        return redirect()->route('etablissements.index')
                         ->with('success', 'Établissement créé avec succès.');
    }

    public function edit(Etablissement $etablissement)
    {
        return view('etablissements.edit', compact('etablissement'));
    }

    public function update(Request $request, Etablissement $etablissement)
    {
        $request->validate([
            'nom'            => 'required|string|max:100',
            'montant_budget' => 'required|numeric|min:0',
        ]);

        $etablissement->update($request->only('nom', 'montant_budget'));

        return redirect()->route('etablissements.index')
                         ->with('success', 'Établissement mis à jour.');
    }

    public function destroy(Etablissement $etablissement)
    {
        $etablissement->delete();
        return redirect()->route('etablissements.index')
                         ->with('success', 'Établissement supprimé.');
    }
}
