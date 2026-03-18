@extends('layouts.app')
@section('title', 'Établissements')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold mb-0"><i class="bi bi-building me-2 text-primary"></i>Établissements</h5>
    <a href="{{ route('etablissements.create') }}" class="btn btn-sm btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Nouvel établissement
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover table-sm mb-0">
            <thead>
                <tr>
                    <th>N°</th>
                    <th>Nom</th>
                    <th class="text-end">Budget (Ar)</th>
                    <th class="text-center" style="width:100px">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($etablissements as $etab)
                <tr>
                    <td class="text-muted">{{ $etab->n_etab }}</td>
                    <td><strong>{{ $etab->nom }}</strong></td>
                    <td class="text-end">{{ number_format($etab->montant_budget, 0, ',', ' ') }}</td>
                    <td class="text-center">
                        <a href="{{ route('etablissements.edit', $etab->n_etab) }}" class="btn btn-sm btn-outline-warning me-1" title="Modifier">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('etablissements.destroy', $etab->n_etab) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Supprimer {{ $etab->nom }} ?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger" title="Supprimer">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center text-muted py-5">
                        <i class="bi bi-inbox fs-3 d-block mb-2"></i>Aucun établissement enregistré.
                    </td>
                </tr>
                @endforelse
            </tbody>
            @if($etablissements->count() > 0)
            <tfoot class="table-light">
                <tr>
                    <td colspan="2" class="fw-semibold text-end">Total budget</td>
                    <td class="text-end fw-bold">{{ number_format($etablissements->sum('montant_budget'), 0, ',', ' ') }} Ar</td>
                    <td></td>
                </tr>
            </tfoot>
            @endif
        </table>
    </div>
</div>
@endsection
