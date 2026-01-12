@extends('layouts.bailleur')

@section('title', 'Mes avocats')

@section('content')
<div class="max-w-7xl mx-auto p-6 space-y-6">

    {{-- En-tête --}}
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-800">Mes avocats</h1>

        <a href="{{ route('bailleur.avocats.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
            + Associer un avocat
        </a>
    </div>

    {{-- Table --}}
    <div class="bg-white shadow rounded-xl overflow-hidden">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-100 text-gray-600">
                <tr>
                    <th class="px-4 py-3 text-left">Nom</th>
                    <th class="px-4 py-3">Email</th>
                    <th class="px-4 py-3">Téléphone</th>
                    <th class="px-4 py-3">Statut</th>
                    {{-- <th class="px-4 py-3">Actions</th> --}}
                </tr>
            </thead>
            <tbody class="divide-y">

                @forelse($avocats as $avocat)
                    <tr class="hover:bg-gray-50">

                        <td class="px-4 py-3 font-medium">
                            {{ $avocat->name }}
                        </td>

                        <td class="px-4 py-3">
                            {{ $avocat->email }}
                        </td>

                        <td class="px-4 py-3">
                            {{ $avocat->phone ?? '-' }}
                        </td>

                        <td class="px-4 py-3">
                            <span class="px-3 py-1 rounded-full text-xs font-medium
                                {{ $avocat->pivot->is_active
                                    ? 'bg-green-100 text-green-700'
                                    : 'bg-gray-200 text-gray-600' }}">
                                {{ $avocat->pivot->is_active ? 'Actif' : 'Inactif' }}
                            </span>
                        </td>

                        {{-- <td class="px-4 py-3 space-x-2">

                            <form action=""
                            {{-- <form action="{{ route('bailleur.avocats.toggle', $avocat) }}" --}
                            
                            method="POST" class="inline">
                                @csrf
                                <button type="submit"
                                        class="text-yellow-600 hover:underline text-sm">
                                    {{ $avocat->pivot->is_active ? 'Désactiver' : 'Activer' }
                                </button>
                            </form>

                            {{-- <form action="{{ route('bailleur.avocats.detach', $avocat) }}" --}
                            <form action=""
                                  method="POST" class="inline"
                                  onsubmit="return confirm('Retirer cet avocat ?')">
                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="text-red-600 hover:underline text-sm">
                                    Retirer
                                </button>
                            </form>

                        </td> --}}

                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-gray-400 py-6">
                            Aucun avocat associé
                        </td>
                    </tr>
                @endforelse

            </tbody>
        </table>
    </div>

</div>
@endsection
