@extends('layouts.app')
@section('title', 'Comptes')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold mb-0"><i class="bi bi-people-fill me-2 text-primary"></i>Comptes utilisateurs</h5>
    <a href="{{ route('users.create') }}" class="btn btn-sm btn-primary">
        <i class="bi bi-person-plus-fill me-1"></i> Nouveau compte
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover table-sm mb-0">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Rôle</th>
                    <th class="text-muted" style="font-weight:400">Créé le</th>
                    <th class="text-center" style="width:100px">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>
                        <i class="bi bi-person-circle me-1 text-secondary"></i>
                        {{ $user->name }}
                        @if($user->id === auth()->id())
                            <span class="badge bg-secondary ms-1" style="font-size:.7rem">Moi</span>
                        @endif
                    </td>
                    <td class="text-muted">{{ $user->email }}</td>
                    <td>
                        @if($user->role === 'admin')
                            <span class="badge bg-danger">Admin</span>
                        @else
                            <span class="badge bg-primary">Utilisateur</span>
                        @endif
                    </td>
                    <td class="text-muted small">{{ $user->created_at->format('d/m/Y') }}</td>
                    <td class="text-center">
                        <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-outline-warning me-1" title="Modifier">
                            <i class="bi bi-pencil"></i>
                        </a>
                        @if($user->id !== auth()->id())
                        <form method="POST" action="{{ route('users.destroy', $user) }}" class="d-inline"
                              onsubmit="return confirm('Supprimer {{ $user->name }} ?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger" title="Supprimer">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-5">
                        <i class="bi bi-inbox fs-3 d-block mb-2"></i>Aucun compte trouvé.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer bg-white text-muted small py-2">
        {{ $users->count() }} compte(s) —
        <span class="badge bg-danger">Admin</span> {{ $users->where('role','admin')->count() }} &nbsp;
        <span class="badge bg-primary">Utilisateur</span> {{ $users->where('role','user')->count() }}
    </div>
</div>
@endsection
