{{-- resources/views/notifications/index.blade.php --}}

@extends('layouts.app')

@section('title', 'Notifications')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-gray-800">
        <i class="fas fa-bell text-yellow-600 mr-2"></i>Notifications
    </h1>
    @if(auth()->user()->unreadNotifications->count() > 0)
        <form action="{{ route('notifications.read-all') }}" method="POST">
            @csrf
            <button type="submit" class="text-indigo-600 hover:underline">
                <i class="fas fa-check-double mr-1"></i>Tout marquer comme lu
            </button>
        </form>
    @endif
</div>

<div class="bg-white rounded-lg shadow">
    @if($notifications->isEmpty())
        <div class="p-8 text-center text-gray-500">
            <i class="fas fa-bell-slash text-4xl mb-4"></i>
            <p>Aucune notification</p>
        </div>
    @else
        <div class="divide-y">
            @foreach($notifications as $notification)
                <div class="p-4 {{ $notification->read_at ? 'bg-white' : 'bg-blue-50' }} hover:bg-gray-50">
                    <div class="flex items-start justify-between">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 mt-1">
                                @php
                                    $type = $notification->data['type'] ?? 'default';
                                @endphp
                                @if($type === 'property_created')
                                    <i class="fas fa-building text-blue-500"></i>
                                @elseif($type === 'rental_created')
                                    <i class="fas fa-handshake text-green-500"></i>
                                @elseif($type === 'rental_cancelled')
                                    <i class="fas fa-times-circle text-red-500"></i>
                                @else
                                    <i class="fas fa-info-circle text-gray-500"></i>
                                @endif
                            </div>
                            <div class="ml-3">
                                <p class="text-gray-800">{{ $notification->data['message'] ?? 'Notification' }}</p>
                                <p class="text-xs text-gray-400 mt-1">
                                    {{ $notification->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            @if(!$notification->read_at)
                                <form action="{{ route('notifications.read', $notification->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-indigo-600 hover:text-indigo-800" title="Marquer comme lu">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                            @endif
                            <form action="{{ route('notifications.destroy', $notification->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800" title="Supprimer">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="p-4 border-t">
            {{ $notifications->links() }}
        </div>
    @endif
</div>
@endsection