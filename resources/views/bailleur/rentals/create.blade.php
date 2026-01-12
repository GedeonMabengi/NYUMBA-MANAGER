{{-- resources/views/bailleur/rentals/create.blade.php --}}

@extends('layouts.app')

@section('title', 'Nouvelle location')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('bailleur.rentals.index') }}" class="text-indigo-600 hover:underline">
            <i class="fas fa-arrow-left mr-2"></i>Retour à la liste
        </a>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">
            <i class="fas fa-handshake text-green-600 mr-2"></i>Attribuer un locataire
        </h1>

        <form action="{{ route('bailleur.rentals.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Sélection du bien --}}
            <div class="mb-6">
                <label for="property_id" class="block text-gray-700 font-medium mb-2">Bien à louer *</label>
                <select name="property_id" id="property_id" required
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500">
                    <option value="">Sélectionnez un bien</option>
                    @foreach($properties as $property)
                        <option value="{{ $property->id }}" 
                                {{ $selectedProperty && $selectedProperty->id == $property->id ? 'selected' : '' }}>
                            {{ $property->name }} ({{ $property->propertyType->name }})
                            @if($property->city) - {{ $property->city }} @endif
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Sélection ou création du locataire --}}
            <div class="border-t pt-6 mb-6">
                <h3 class="text-lg font-medium text-gray-800 mb-4">
                    <i class="fas fa-user text-blue-500 mr-2"></i>Locataire
                </h3>

                <div class="mb-4">
                    <label class="flex items-center mb-4">
                        <input type="radio" name="tenant_type" value="existing" checked
                               class="text-indigo-600" onchange="toggleTenantForm()">
                        <span class="ml-2">Locataire existant</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="tenant_type" value="new"
                               class="text-indigo-600" onchange="toggleTenantForm()">
                        <span class="ml-2">Nouveau locataire</span>
                    </label>
                </div>

                {{-- Locataire existant --}}
                <div id="existingTenantForm">
                    <select name="tenant_id" id="tenant_id"
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500">
                        <option value="">Sélectionnez un locataire</option>
                        @foreach($tenants as $tenant)
                            <option value="{{ $tenant->id }}">
                                {{ $tenant->full_name }} - {{ $tenant->phone }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Nouveau locataire --}}
                <div id="newTenantForm" class="hidden">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Prénom *</label>
                            <input type="text" name="new_tenant[first_name]" value="{{ old('new_tenant.first_name') }}"
                                   class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Nom *</label>
                            <input type="text" name="new_tenant[last_name]" value="{{ old('new_tenant.last_name') }}"
                                   class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Téléphone *</label>
                            <input type="text" name="new_tenant[phone]" value="{{ old('new_tenant.phone') }}"
                                   class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Email</label>
                            <input type="email" name="new_tenant[email]" value="{{ old('new_tenant.email') }}"
                                   class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Détails de la location --}}
            <div class="border-t pt-6 mb-6">
                <h3 class="text-lg font-medium text-gray-800 mb-4">
                    <i class="fas fa-file-contract text-purple-500 mr-2"></i>Détails de la location
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="start_date" class="block text-gray-700 font-medium mb-2">Date de début *</label>
                        <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}" required
                               class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label for="end_date" class="block text-gray-700 font-medium mb-2">Date de fin</label>
                        <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}"
                               class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label for="rent_amount" class="block text-gray-700 font-medium mb-2">Loyer (€) *</label>
                        <input type="number" step="0.01" name="rent_amount" id="rent_amount" 
                               value="{{ old('rent_amount') }}" required
                               class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label for="deposit_amount" class="block text-gray-700 font-medium mb-2">Dépôt de garantie (€)</label>
                        <input type="number" step="0.01" name="deposit_amount" id="deposit_amount" 
                               value="{{ old('deposit_amount') }}"
                               class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label for="payment_frequency" class="block text-gray-700 font-medium mb-2">Fréquence de paiement *</label>
                        <select name="payment_frequency" id="payment_frequency" required
                                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500">
                            <option value="monthly" {{ old('payment_frequency') === 'monthly' ? 'selected' : '' }}>Mensuel</option>
                            <option value="quarterly" {{ old('payment_frequency') === 'quarterly' ? 'selected' : '' }}>Trimestriel</option>
                            <option value="yearly" {{ old('payment_frequency') === 'yearly' ? 'selected' : '' }}>Annuel</option>
                        </select>
                    </div>
                </div>

                <div class="mt-4">
                    <label for="notes" class="block text-gray-700 font-medium mb-2">Notes</label>
                    <textarea name="notes" id="notes" rows="3"
                              class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500">{{ old('notes') }}</textarea>
                </div>
            </div>

            {{-- Contrat de bail --}}
            <div class="border-t pt-6 mb-6">
                <h3 class="text-lg font-medium text-gray-800 mb-4">
                    <i class="fas fa-file-upload text-red-500 mr-2"></i>Contrat de bail *
                </h3>
                
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center">
                    <input type="file" name="lease_contract" id="lease_contract" required
                           accept=".pdf,.jpg,.jpeg,.png"
                           class="hidden" onchange="updateFileName(this)">
                    <label for="lease_contract" class="cursor-pointer">
                        <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-2"></i>
                        <p class="text-gray-600">Cliquez pour uploader le contrat de bail</p>
                        <p class="text-sm text-gray-400 mt-1">PDF, JPG, PNG (max 10 Mo)</p>
                    </label>
                    <p id="fileName" class="mt-2 text-indigo-600 font-medium hidden"></p>
                </div>

                {{-- Option capture photo --}}
                <div class="mt-4 text-center">
                    <button type="button" onclick="openCamera()" 
                            class="text-indigo-600 hover:underline">
                        <i class="fas fa-camera mr-2"></i>Ou capturer une photo
                    </button>
                </div>
            </div>

            <div class="mt-8 flex justify-end space-x-4">
                <a href="{{ route('bailleur.rentals.index') }}" 
                   class="px-6 py-2 border rounded-lg text-gray-700 hover:bg-gray-50">
                    Annuler
                </a>
                <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                    <i class="fas fa-check mr-2"></i>Créer la location
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Capture Photo --}}
<div id="cameraModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 max-w-lg w-full mx-4">
        <h3 class="text-lg font-bold mb-4">Capturer une photo du contrat</h3>
        <video id="cameraFeed" class="w-full rounded-lg mb-4" autoplay></video>
        <canvas id="photoCanvas" class="hidden"></canvas>
        <div class="flex justify-end space-x-4">
            <button type="button" onclick="closeCamera()" class="px-4 py-2 border rounded-lg">Annuler</button>
            <button type="button" onclick="capturePhoto()" class="px-4 py-2 bg-indigo-600 text-white rounded-lg">
                <i class="fas fa-camera mr-2"></i>Capturer
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
function toggleTenantForm() {
    const tenantType = document.querySelector('input[name="tenant_type"]:checked').value;
    const existingForm = document.getElementById('existingTenantForm');
    const newForm = document.getElementById('newTenantForm');

    if (tenantType === 'existing') {
        existingForm.classList.remove('hidden');
        newForm.classList.add('hidden');
    } else {
        existingForm.classList.add('hidden');
        newForm.classList.remove('hidden');
    }
}

function updateFileName(input) {
    const fileName = document.getElementById('fileName');
    if (input.files.length > 0) {
        fileName.textContent = input.files[0].name;
        fileName.classList.remove('hidden');
    } else {
        fileName.classList.add('hidden');
    }
}

let stream = null;

function openCamera() {
    const modal = document.getElementById('cameraModal');
    const video = document.getElementById('cameraFeed');

    navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' } })
        .then(s => {
            stream = s;
            video.srcObject = stream;
            modal.classList.remove('hidden');
        })
        .catch(err => {
            alert('Impossible d\'accéder à la caméra: ' + err.message);
        });
}

function closeCamera() {
    const modal = document.getElementById('cameraModal');
    if (stream) {
        stream.getTracks().forEach(track => track.stop());
    }
    modal.classList.add('hidden');
}

function capturePhoto() {
    const video = document.getElementById('cameraFeed');
    const canvas = document.getElementById('photoCanvas');
    const ctx = canvas.getContext('2d');

    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    ctx.drawImage(video, 0, 0);

    canvas.toBlob(blob => {
        const file = new File([blob], 'contrat_photo.jpg', { type: 'image/jpeg' });
        const dataTransfer = new DataTransfer();
        dataTransfer.items.add(file);
        document.getElementById('lease_contract').files = dataTransfer.files;
        updateFileName(document.getElementById('lease_contract'));
        closeCamera();
    }, 'image/jpeg', 0.9);
}
</script>
@endpush
@endsection