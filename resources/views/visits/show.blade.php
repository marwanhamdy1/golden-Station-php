@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <div class="flex items-center mb-6">
            <a href="{{ route('visits.index') }}" class="text-blue-600 hover:text-blue-700 mr-4">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="text-3xl font-bold text-gray-900">{{ __('visits.visit_details') }}</h1>
        </div>

        <div class="bg-white rounded-lg shadow-md p-8 mb-8">
            <div class="mb-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-2">Visit #{{ str_pad($visit->id, 4, '0', STR_PAD_LEFT) }}</h2>
                <div class="flex flex-wrap gap-2">
                    <span class="px-3 py-1 rounded-full text-xs font-medium {{ $visit->visit_status === 'visited' ? 'bg-green-100 text-green-800' : ($visit->visit_status === 'closed' ? 'bg-blue-100 text-blue-800' : ($visit->visit_status === 'not_found' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800')) }}">
                        {{ __('visits.'.$visit->visit_status) }}
                    </span>
                    @if($visit->vendor_rating)
                    <span class="px-3 py-1 rounded-full text-xs font-medium {{ $visit->vendor_rating === 'very_interested' ? 'bg-green-100 text-green-800' : ($visit->vendor_rating === 'hesitant' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                        {{ __('visits.'.$visit->vendor_rating) }}
                    </span>
                    @endif
                    @if($visit->delivery_service_requested)
                    <span class="px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                        {{ __('visits.delivery_requested') }}
                    </span>
                    @endif
                </div>
            </div>

            <!-- Vendor and Agent Info -->
            <div class="mb-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="font-semibold text-gray-700 mb-3">{{ __('visits.vendor_information') }}</h3>
                    <div class="flex items-center mb-3">
                        <img class="h-12 w-12 rounded-full mr-3" src="https://ui-avatars.com/api/?name={{ urlencode($visit->vendor->owner_name ?? $visit->vendor->commercial_name) }}&background=1e40af&color=fff" alt="Vendor">
                        <div>
                            <div class="text-gray-900 font-medium">{{ $visit->vendor->owner_name ?? __('visits.na') }}</div>
                            <div class="text-gray-500 text-sm">{{ $visit->vendor->commercial_name ?? __('visits.na') }}</div>
                            <div class="text-xs text-gray-400">{{ $visit->vendor->city ?? __('visits.na') }}</div>
                        </div>
                    </div>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-700 mb-3">{{ __('visits.agent_information') }}</h3>
                    @if($visit->agent)
                    <div class="flex items-center mb-3">
                        <img class="h-12 w-12 rounded-full mr-3" src="https://ui-avatars.com/api/?name={{ urlencode($visit->agent->name) }}&background=059669&color=fff" alt="Agent">
                        <div>
                            <div class="text-gray-900 font-medium">{{ $visit->agent->name }}</div>
                            <div class="text-gray-500 text-sm">{{ __('visits.agent') }} #{{ str_pad($visit->agent->id, 3, '0', STR_PAD_LEFT) }}</div>
                            <div class="text-xs text-gray-400">{{ __('visits.total_visits_to_vendor') }}: {{ $agentVendorVisitsCount }}</div>
                        </div>
                    </div>
                    @else
                    <span class="text-gray-400 text-sm">{{ __('visits.no_agent_assigned') }}</span>
                    @endif
                </div>
            </div>

            <!-- Visit Details -->
            <div class="mb-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div>
                    <h3 class="font-semibold text-gray-700 mb-3">{{ __('visits.visit_information') }}</h3>
                    <p class="text-gray-700 mb-2"><span class="font-semibold">{{ __('visits.date') }}:</span> {{ $visit->visit_date instanceof \Carbon\Carbon ? $visit->visit_date->format('M d, Y H:i') : $visit->visit_date }}</p>
                    <p class="text-gray-700 mb-2"><span class="font-semibold">{{ __('visits.report_created') }}:</span> {{ $visit->created_at instanceof \Carbon\Carbon ? $visit->created_at->format('M d, Y H:i') : $visit->created_at }}</p>
                    @if($visit->visit_end_at)
                    <p class="text-gray-700 mb-2"><span class="font-semibold">{{ __('visits.end_time') }}:</span> {{ $visit->visit_end_at instanceof \Carbon\Carbon ? $visit->visit_end_at->format('M d, Y H:i') : $visit->visit_end_at }}</p>
                    @if($visit->visit_date instanceof \Carbon\Carbon && $visit->visit_end_at instanceof \Carbon\Carbon)
                    <p class="text-gray-700 mb-2"><span class="font-semibold">{{ __('visits.duration') }}:</span> {{ $visit->visit_date->diffInMinutes($visit->visit_end_at) }} {{ __('visits.minutes') }}</p>
                    @endif
                    @endif
                    <p class="text-gray-700 mb-2"><span class="font-semibold">{{ __('visits.branch') }}:</span> {{ $visit->branch->name ?? __('visits.na') }}</p>
                </div>

                <div>
                    <h3 class="font-semibold text-gray-700 mb-3">{{ __('visits.location_contact') }}</h3>
                    <p class="text-gray-700 mb-2"><span class="font-semibold">{{ __('visits.gps_coordinates') }}:</span></p>
                    <p class="text-sm text-gray-600 mb-2">{{ __('visits.lat') }}: {{ $visit->gps_latitude ?? __('visits.na') }}</p>
                    <p class="text-sm text-gray-600 mb-3">{{ __('visits.lng') }}: {{ $visit->gps_longitude ?? __('visits.na') }}</p>

                    @if($visit->met_person_name)
                    <p class="text-gray-700 mb-2"><span class="font-semibold">{{ __('visits.met_person') }}:</span> {{ $visit->met_person_name }}</p>
                    <p class="text-gray-700 mb-2"><span class="font-semibold">{{ __('visits.person_role') }}:</span>
                        @if($visit->met_person_role === 'other' && $visit->custom_role)
                            {{ $visit->custom_role }}
                        @else
                            {{ ucfirst(str_replace('_', ' ', $visit->met_person_role ?? __('visits.na'))) }}
                        @endif
                    </p>
                    @endif
                </div>

                <div>
                    <h3 class="font-semibold text-gray-700 mb-3">{{ __('visits.package_information') }}</h3>
                    @if($visit->package)
                    <div class="mb-3">
                        <div class="text-gray-900 font-medium">{{ $visit->package->name }}</div>
                        <div class="text-gray-500 text-sm">SAR {{ number_format($visit->package->price, 2) }}</div>
                        <div class="text-xs text-gray-400">{{ __('visits.duration') }}: {{ $visit->package->duration_in_days ?? __('visits.na') }} {{ __('visits.days') }}</div>
                    </div>
                    @else
                    <span class="text-gray-400 text-sm">{{ __('visits.no_package') }}</span>
                    @endif
                </div>
            </div>

            <!-- Notes Section -->
            <div class="mb-6">
                <h3 class="font-semibold text-gray-700 mb-3">{{ __('visits.notes_comments') }}</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h4 class="font-semibold text-gray-600 mb-2">{{ __('visits.general_notes') }}</h4>
                        <p class="text-gray-700 text-sm">{{ $visit->notes ?? __('visits.no_general_notes') }}</p>
                    </div>
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <h4 class="font-semibold text-gray-600 mb-2">{{ __('visits.agent_notes') }}</h4>
                        <p class="text-gray-700 text-sm">{{ $visit->agent_notes ?? __('visits.no_agent_notes') }}</p>
                    </div>
                    <div class="bg-yellow-50 p-4 rounded-lg">
                        <h4 class="font-semibold text-gray-600 mb-2">{{ __('visits.internal_notes') }}</h4>
                        <p class="text-gray-700 text-sm">{{ $visit->internal_notes ?? __('visits.no_internal_notes') }}</p>
                    </div>
                </div>
            </div>

            <!-- Media Section -->
            <div class="mb-6">
                <h3 class="font-semibold text-gray-700 mb-3">{{ __('visits.media_documents') }}</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @if($visit->audio_recording)
                    <div class="bg-green-50 p-4 rounded-lg">
                        <label class="block text-gray-600 font-medium mb-2">
                            <i class="fas fa-microphone mr-2"></i>{{ __('visits.audio_recording') }}
                        </label>
                        <audio controls class="w-full">
                            <source src="{{ asset('storage/' . $visit->audio_recording) }}" type="audio/mpeg">
                            <source src="{{ asset('storage/' . $visit->audio_recording) }}" type="audio/wav">
                            {{ __('visits.browser_not_support_audio') }}
                        </audio>
                    </div>
                    @endif

                    @if($visit->video_recording)
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <label class="block text-gray-600 font-medium mb-2">
                            <i class="fas fa-video mr-2"></i>{{ __('visits.video_recording') }}
                        </label>
                        <video controls class="w-full max-w-xs">
                            <source src="{{ asset('storage/' . $visit->video_recording) }}" type="video/mp4">
                            <source src="{{ asset('storage/' . $visit->video_recording) }}" type="video/avi">
                            <source src="{{ asset('storage/' . $visit->video_recording) }}" type="video/mov">
                            {{ __('visits.browser_not_support_video') }}
                        </video>
                    </div>
                    @endif

                    @if($visit->signature_image)
                    <div class="bg-purple-50 p-4 rounded-lg">
                        <label class="block text-gray-600 font-medium mb-2">
                            <i class="fas fa-signature mr-2"></i>{{ __('visits.signature') }}
                        </label>
                        <img src="{{ asset('storage/' . $visit->signature_image) }}" alt="Signature" class="max-w-full h-auto border rounded">
                    </div>
                    @endif

                    @if(!$visit->audio_recording && !$visit->video_recording && !$visit->signature_image)
                    <div class="bg-gray-50 p-4 rounded-lg col-span-full text-center">
                        <i class="fas fa-file-slash text-gray-400 text-2xl mb-2"></i>
                        <p class="text-gray-400">{{ __('visits.no_media_files') }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end space-x-4 mt-8">
                <a href="{{ route('visits.edit', $visit) }}" class="px-6 py-3 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg transition-colors flex items-center">
                    <i class="fas fa-edit mr-2"></i> {{ __('visits.edit_visit') }}
                </a>
                <form id="deleteForm" action="{{ route('visits.destroy', $visit) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" onclick="confirmDelete()" class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors flex items-center">
                        <i class="fas fa-trash mr-2"></i> {{ __('visits.delete_visit') }}
                    </button>
                </form>
            </div>
        </div>

        <!-- Visit History Section -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="px-8 py-6 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-history mr-3 text-blue-600"></i>
                    {{ __('visits.visit_history') }} {{ $visit->vendor->commercial_name ?? $visit->vendor->owner_name }}
                </h2>
                <p class="text-gray-600 text-sm mt-1">{{ __('visits.all_visits_made') }} ({{ $allVendorVisits->count() }} {{ __('visits.total_visits') }})</p>
            </div>

            <div class="p-8">
                @if($allVendorVisits->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('visits.visit_number', ['number' => '']) }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('visits.agent') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('visits.date') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('visits.status_rating') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('visits.vendor_rating') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('visits.package_value') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('visits.duration') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('visits.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($allVendorVisits as $historyVisit)
                            <tr class="{{ $historyVisit->id === $visit->id ? 'bg-blue-50 border-l-4 border-blue-500' : 'hover:bg-gray-50' }}">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        @if($historyVisit->id === $visit->id)
                                        <i class="fas fa-eye text-blue-600 mr-2"></i>
                                        @endif
                                        <span class="text-sm font-medium text-gray-900">#{{ str_pad($historyVisit->id, 4, '0', STR_PAD_LEFT) }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                    <img class="h-8 w-8 rounded-full mr-3" src="https://ui-avatars.com/api/?name={{ urlencode($historyVisit->agent->name ?? __('visits.unknown')) }}&background=059669&color=fff" alt="Agent">
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $historyVisit->agent->name ?? __('visits.na') }}</div>
                                        <div class="text-sm text-gray-500">{{ __('visits.agent') }} #{{ str_pad($historyVisit->agent->id ?? 0, 3, '0', STR_PAD_LEFT) }}</div>
                                    </div>
                                </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $historyVisit->visit_date instanceof \Carbon\Carbon ? $historyVisit->visit_date->format('M d, Y') : $historyVisit->visit_date }}</div>
                                    <div class="text-sm text-gray-500">{{ $historyVisit->visit_date instanceof \Carbon\Carbon ? $historyVisit->visit_date->format('H:i') : '' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $historyVisit->visit_status === 'visited' ? 'bg-green-100 text-green-800' : ($historyVisit->visit_status === 'closed' ? 'bg-blue-100 text-blue-800' : ($historyVisit->visit_status === 'not_found' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800')) }}">
                                        {{ __('visits.'.$historyVisit->visit_status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($historyVisit->vendor_rating)
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $historyVisit->vendor_rating === 'very_interested' ? 'bg-green-100 text-green-800' : ($historyVisit->vendor_rating === 'hesitant' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                        {{ __('visits.'.$historyVisit->vendor_rating) }}
                                    </span>
                                    @else
                                    <span class="text-gray-400 text-sm">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($historyVisit->package)
                                    <div class="text-sm text-gray-900">{{ $historyVisit->package->name }}</div>
                                    <div class="text-sm text-gray-500">SAR {{ number_format($historyVisit->package->price, 2) }}</div>
                                    @else
                                    <span class="text-gray-400 text-sm">{{ __('visits.no_package') }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    @if($historyVisit->visit_date instanceof \Carbon\Carbon && $historyVisit->visit_end_at instanceof \Carbon\Carbon)
                                    {{ $historyVisit->visit_date->diffInMinutes($historyVisit->visit_end_at) }} {{ __('visits.min') }}
                                    @else
                                    -
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    @if($historyVisit->id !== $visit->id)
                                    <a href="{{ route('visits.show', $historyVisit) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('visits.edit', $historyVisit) }}" class="text-yellow-600 hover:text-yellow-900">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @else
                                    <span class="text-blue-600 font-medium">{{ __('visits.current_visit') }}</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Visit Statistics -->
                <div class="mt-8 grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="bg-blue-50 p-4 rounded-lg text-center">
                        <div class="text-2xl font-bold text-blue-600">{{ $allVendorVisits->count() }}</div>
                        <div class="text-sm text-gray-600">{{ __('visits.total_visits') }}</div>
                    </div>
                    <div class="bg-green-50 p-4 rounded-lg text-center">
                        <div class="text-2xl font-bold text-green-600">{{ $allVendorVisits->where('visit_status', 'visited')->count() }}</div>
                        <div class="text-sm text-gray-600">{{ __('visits.successful_visits') }}</div>
                    </div>
                    <div class="bg-yellow-50 p-4 rounded-lg text-center">
                        <div class="text-2xl font-bold text-yellow-600">{{ $allVendorVisits->whereNotNull('package_id')->count() }}</div>
                        <div class="text-sm text-gray-600">{{ __('visits.with_packages') }}</div>
                    </div>
                    <div class="bg-purple-50 p-4 rounded-lg text-center">
                        <div class="text-2xl font-bold text-purple-600">{{ $allVendorVisits->groupBy('agent_id')->count() }}</div>
                        <div class="text-sm text-gray-600">{{ __('visits.different_agents') }}</div>
                    </div>
                </div>
                @else
                <div class="text-center py-12">
                    <i class="fas fa-clipboard-list text-gray-400 text-4xl mb-4"></i>
                    <p class="text-gray-500">{{ __('visits.no_visit_history') }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete() {
    document.getElementById('deleteVisitModal').classList.remove('hidden');
}

document.getElementById('cancelDeleteBtn')?.addEventListener('click', function() {
    document.getElementById('deleteVisitModal').classList.add('hidden');
});
</script>
@endsection
