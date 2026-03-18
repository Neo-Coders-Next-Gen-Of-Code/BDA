<?php

namespace App\Http\Controllers;

use App\Models\Depense;
use App\Models\Etablissement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DepenseController extends Controller
{
    /**
     * Définit la variable de session PostgreSQL app.current_user
     * avec le nom de l'utilisateur connecté à l'application.
     */
    private function setAppUser(): void
    {
        $username = Auth::check() ? Auth::user()->name : 'inconnu';
        DB::statement("SELECT set_config('app.current_user', ?, false)", [$username]);
    }

    public function index()
    {
        $depenses = Depense::with('etablissement')->orderBy('n_depense')->get();
        return view('depenses.index', compact('depenses'));
    }

    public function create()
    {
        $etablissements = Etablissement::orderBy('nom')->get();
        return view('depenses.create', compact('etablissements'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'n_etab'  => 'required|exists:etablissements,n_etab',
            'depense' => 'required|numeric',
        ]);

        $this->setAppUser();
        Depense::create($request->only('n_etab', 'depense'));

        return redirect()->route('depenses.index')
                         ->with('success', 'Dépense ajoutée. Budget mis à jour automatiquement.');
    }

    public function edit(Depense $depense)
    {
        $etablissements = Etablissement::orderBy('nom')->get();
        return view('depenses.edit', compact('depense', 'etablissements'));
    }

    public function update(Request $request, Depense $depense)
    {
        $request->validate([
            'n_etab'  => 'required|exists:etablissements,n_etab',
            'depense' => 'required|numeric',
        ]);

        $this->setAppUser();
        $depense->update($request->only('n_etab', 'depense'));

        return redirect()->route('depenses.index')
                         ->with('success', 'Dépense modifiée. Budget recalculé automatiquement.');
    }

    public function destroy(Depense $depense)
    {
        $this->setAppUser();
        $depense->delete();
        return redirect()->route('depenses.index')
                         ->with('success', 'Dépense supprimée. Budget recalculé automatiquement.');
    }
}
