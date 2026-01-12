@extends('layouts.bailleur')

@section('title', 'Ajouter un avocat')

@section('content')
<div class="max-w-4xl mx-auto p-6">

    <h1 class="text-2xl font-bold mb-6">Ajouter un avocat</h1>

    {{-- Messages --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('bailleur.avocats.store') }}" method="POST" class="space-y-6">
        @csrf

        {{-- Sélection avocat existant --}}
        <div>
            <label class="block font-medium mb-1">Choisir un avocat existant</label>
            <select name="avocat_id" class="w-full border rounded px-3 py-2">
                <option value="">-- Sélectionner --</option>
                @foreach($existingAvocats as $avocat)
                    <option value="{{ $avocat->id }}">
                        {{ $avocat->name }} ({{ $avocat->email }})
                    </option>
                @endforeach
            </select>
            <p class="text-sm text-gray-500 mt-1">Ou créez un nouvel avocat ci-dessous</p>
        </div>

        <hr>

        {{-- Création nouvel avocat --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <div>
                <label class="block font-medium mb-1">Nom complet</label>
                <input type="text" name="name"
                       value="{{ old('name') }}"
                       class="w-full border rounded px-3 py-2">
            </div>

            <div>
                <label class="block font-medium mb-1">Email</label>
                <input type="email" name="email"
                       value="{{ old('email') }}"
                       class="w-full border rounded px-3 py-2">
            </div>

            <div>
                <label class="block font-medium mb-1">Téléphone</label>
                <input type="text" name="phone"
                       value="{{ old('phone') }}"
                       class="w-full border rounded px-3 py-2">
            </div>

        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('bailleur.avocats.index') }}"
               class="px-4 py-2 border rounded text-gray-700">
                Annuler
            </a>

            <button type="submit"
                    class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700">
                Enregistrer
            </button>
        </div>
    </form>

</div>
@endsection
