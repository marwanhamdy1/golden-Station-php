@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <div class="flex items-center mb-6">
            <a href="{{ route('visits.index') }}" class="text-blue-600 hover:text-blue-700 mr-4">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Visit Details</h1>
        </div>
        <div class="bg-white rounded-lg shadow-md p-8">
            <div class="mb-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-2">Visit #{{ str_pad($visit->id, 4, '0', STR_PAD_LEFT) }}</h2>
                <span class="px-3 py-1 rounded-full text-xs font-medium {{ $visit->visit_status === 'visited' ? 'bg-green-100 text-green-800' : ($visit->visit_status === 'closed' ? 'bg-blue-100 text-blue-800' : ($visit->visit_status === 'not_found' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800')) }}">
                    {{ ucfirst(str_replace('_', ' ', $visit->visit_status)) }}
                </span>
                @if($visit->vendor_rating)
                <span class="ml-2 px-3 py-1 rounded-full text-xs font-medium {{ $visit->vendor_rating === 'very_interested' ? 'bg-green-100 text-green-800' : ($visit->vendor_rating === 'hesitant' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                    {{ ucfirst(str_replace('_', ' ', $visit->vendor_rating)) }}
                </span>
                @endif
            </div>
            <div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="font-semibold text-gray-700 mb-2">Vendor</h3>
                    <div class="flex items-center mb-2">
                        <img class="h-10 w-10 rounded-full mr-3" src="https://ui-avatars.com/api/?name={{ urlencode($visit->vendor->owner_name ?? $visit->vendor->commercial_name) }}&background=1e40af&color=fff" alt="Vendor">
                        <div>
                            <div class="text-gray-900 font-medium">{{ $visit->vendor->owner_name ?? 'N/A' }}</div>
                            <div class="text-gray-500 text-sm">{{ $visit->vendor->commercial_name ?? 'N/A' }}</div>
                            <div class="text-xs text-gray-400">{{ $visit->vendor->city ?? 'N/A' }}</div>
                        </div>
                    </div>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-700 mb-2">Agent</h3>
                    @if($visit->agent)
                    <div class="flex items-center mb-2">
                        <img class="h-10 w-10 rounded-full mr-3" src="https://ui-avatars.com/api/?name={{ urlencode($visit->agent->name) }}&background=059669&color=fff" alt="Agent">
                        <div>
                            <div class="text-gray-900 font-medium">{{ $visit->agent->name }}</div>
                            <div class="text-gray-500 text-sm">Agent #{{ str_pad($visit->agent->id, 3, '0', STR_PAD_LEFT) }}</div>
                        </div>
                    </div>
                    @else
                    <span class="text-gray-400 text-sm">No Agent</span>
                    @endif
                </div>
            </div>
            <div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="font-semibold text-gray-700 mb-2">Visit Info</h3>
                    <p class="text-gray-700 mb-1"><span class="font-semibold">Date:</span> {{ $visit->visit_date instanceof \Carbon\Carbon ? $visit->visit_date->format('M d, Y H:i') : $visit->visit_date }}</p>
                    @if($visit->visit_end_at)
                    <p class="text-gray-700 mb-1"><span class="font-semibold">End:</span> {{ $visit->visit_end_at instanceof \Carbon\Carbon ? $visit->visit_end_at->format('M d, Y H:i') : $visit->visit_end_at }}</p>
                    @if($visit->visit_date instanceof \Carbon\Carbon && $visit->visit_end_at instanceof \Carbon\Carbon)
                    <p class="text-gray-700 mb-1"><span class="font-semibold">Duration:</span> {{ $visit->visit_date->diffInMinutes($visit->visit_end_at) }} min</p>
                    @endif
                    @endif
                    <p class="text-gray-700 mb-1"><span class="font-semibold">Branch:</span> {{ $visit->branch->name ?? 'N/A' }}</p>
                    <p class="text-gray-700 mb-1"><span class="font-semibold">GPS:</span> {{ $visit->gps_latitude ?? 'N/A' }}, {{ $visit->gps_longitude ?? 'N/A' }}</p>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-700 mb-2">Package</h3>
                    @if($visit->package)
                    <div class="mb-2">
                        <div class="text-gray-900 font-medium">{{ $visit->package->name }}</div>
                        <div class="text-gray-500 text-sm">SAR {{ number_format($visit->package->price, 2) }}</div>
                        <div class="text-xs text-gray-400">Duration: {{ $visit->package->duration_in_days ?? 'N/A' }} days</div>
                    </div>
                    @else
                    <span class="text-gray-400 text-sm">No Package</span>
                    @endif
                </div>
            </div>
            <div class="mb-4">
                <h3 class="font-semibold text-gray-700 mb-2">Notes</h3>
                <p class="text-gray-700 mb-1"><span class="font-semibold">General:</span> {{ $visit->notes ?? 'N/A' }}</p>
                <p class="text-gray-700 mb-1"><span class="font-semibold">Agent Notes:</span> {{ $visit->agent_notes ?? 'N/A' }}</p>
                <p class="text-gray-700 mb-1"><span class="font-semibold">Internal Notes:</span> {{ $visit->internal_notes ?? 'N/A' }}</p>
            </div>
            <div class="mb-4">
                <h3 class="font-semibold text-gray-700 mb-2">Media</h3>
                @if($visit->audio_recording)
                    <div class="mb-2">
                        <label class="block text-gray-600 font-medium mb-1">Audio Recording:</label>
                        <audio controls>
                            <source src="{{ asset('storage/' . $visit->audio_recording) }}" type="audio/mpeg">
                            <source src="{{ asset('storage/' . $visit->audio_recording) }}" type="audio/wav">
                            Your browser does not support the audio element.
                        </audio>
                    </div>
                @endif
                @if($visit->video_recording)
                    <div class="mb-2">
                        <label class="block text-gray-600 font-medium mb-1">Video Recording:</label>
                        <video controls width="320">
                            <source src="{{ asset('storage/' . $visit->video_recording) }}" type="video/mp4">
                            <source src="{{ asset('storage/' . $visit->video_recording) }}" type="video/avi">
                            <source src="{{ asset('storage/' . $visit->video_recording) }}" type="video/mov">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                @endif
                @if(!$visit->audio_recording && !$visit->video_recording)
                    <span class="text-gray-400 text-sm">No audio or video available.</span>
                @endif
            </div>
            <div class="flex justify-end space-x-4 mt-8">
                <a href="{{ route('visits.edit', $visit) }}" class="px-6 py-3 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg transition-colors flex items-center">
                    <i class="fas fa-edit mr-2"></i> Edit
                </a>
                <form id="deleteForm" action="{{ route('visits.destroy', $visit) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" onclick="confirmDelete()" class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors flex items-center">
                        <i class="fas fa-trash mr-2"></i> Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
function confirmDelete() {
    if (confirm('Are you sure you want to delete this visit? This action cannot be undone.')) {
        document.getElementById('deleteForm').submit();
    }
}
</script>
@endsection
