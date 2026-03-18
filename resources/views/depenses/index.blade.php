@extends('layouts.app')
@section('title', 'Dépenses')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold mb-0"><i class="bi bi-cash-coin me-2 text-primary"></i>Dépenses</h5>
    <a href="{{ route('depenses.create') }}" class="btn btn-sm btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Nouvelle dépense
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover table-sm mb-0">
            <thead>
                <tr>
                    <th>N°</th>
                    <th>Établissement</th>
                    <th class="text-end">Montant (Ar)</th>
                    <th class="text-center" style="width:100px">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($depenses as $dep)
                <tr>
                    <td class="text-muted">#{{ $dep->n_depense }}</td>
                    <td>{{ $dep->etablissement->nom ?? '—' }}</td>
                    <td class="text-end fw-semibold">{{ number_format($dep->depense, 0, ',', ' ') }}</td>
                    <td class="text-center">
                        <a href="{{ route('depenses.edit', $dep->n_depense) }}" class="btn btn-sm btn-outline-warning me-1" title="Modifier">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('depenses.destroy', $dep->n_depense) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Supprimer la dépense #{{ $dep->n_depense }} ?')">
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
                        <i class="bi bi-inbox fs-3 d-block mb-2"></i>Aucune dépense enregistrée.
                    </td>
                </tr>
                @endforelse
            </tbody>
            @if($depenses->count() > 0)
            <tfoot class="table-light">
                <tr>
                    <td colspan="2" class="fw-semibold text-end">Total</td>
                    <td class="text-end fw-bold">{{ number_format($depenses->sum('depense'), 0, ',', ' ') }} Ar</td>
                    <td></td>
                </tr>
            </tfoot>
            @endif
        </table>
    </div>
</div>
@endsection
