{{-- resources/views/agents/partials/overview.blade.php --}}

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Recent Visits -->
    <div class="bg-gray-50 rounded-lg p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                <i class="fas fa-clock mr-2 text-blue-600"></i>
                {{ __('agents.recent_visits') }}
            </h3>
            <a href="{{ route('agents.show', ['agent' => $agent, 'tab' => 'visits']) }}"
               class="text-blue-600 hover:text-blue-800 text-sm flex items-center">
                {{ __('agents.view_all') }} <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>

        @if($vendorVisits->count() > 0)
            <div class="space-y-3">
                @foreach($vendorVisits as $visit)
                <div class="bg-white p-4 rounded-lg border-l-4 border-blue-500 hover:shadow-md transition duration-200 cursor-pointer"
                     onclick="window.location.href='{{ route('visits.show', $visit->id) }}'">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <h4 class="font-medium text-gray-900 hover:text-blue-600">{{ $visit->vendor->owner_name ?? __('agents.unknown_vendor') }}</h4>
                            <p class="text-sm text-gray-600 mt-1">
                                <i class="fas fa-building mr-1"></i>
                                <a href="{{ route('branches.show', $visit->branch->id ?? '#') }}"
                                   class="hover:text-blue-600 hover:underline"
                                   onclick="event.stopPropagation()">
                                    {{ $visit->branch->name ?? __('agents.unknown_branch') }}
                                </a>
                            </p>
                            <p class="text-xs text-gray-500 mt-2">
                                <i class="fas fa-calendar mr-1"></i>
                                {{ $visit->created_at->format('M d, Y H:i') }}
                            </p>
                        </div>
                        <div class="flex flex-col items-end space-y-2">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <i class="fas fa-check mr-1"></i>
                                {{ __('agents.completed') }}
                            </span>
                            <a href="{{ route('visits.show', $visit->id) }}"
                               class="text-blue-600 hover:text-blue-800 text-xs flex items-center"
                               onclick="event.stopPropagation()">
                                <i class="fas fa-eye mr-1"></i>
                                {{ __('agents.view_details') }}
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8">
                <i class="fas fa-calendar-times text-gray-400 text-4xl mb-4"></i>
                <p class="text-gray-500">{{ __('agents.no_visits') }}</p>
            </div>
        @endif
    </div>

    <!-- Branch Summary -->
    <div class="bg-gray-50 rounded-lg p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                <i class="fas fa-building mr-2 text-green-600"></i>
                {{ __('agents.branch_overview') }}
            </h3>
            <a href="{{ route('agents.show', ['agent' => $agent, 'tab' => 'branches']) }}"
               class="text-blue-600 hover:text-blue-800 text-sm flex items-center">
                {{ __('agents.view_all') }} <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>

        @if($branches->count() > 0)
            <div class="space-y-3">
                @foreach($branches as $branch)
                <div class="bg-white p-4 rounded-lg border-l-4 border-green-500 hover:shadow-md transition duration-200 cursor-pointer"
                     onclick="window.location.href='{{ route('branches.show', $branch->id) }}'">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <h4 class="font-medium text-gray-900 hover:text-green-600">{{ $branch->name }}</h4>
                            <p class="text-sm text-gray-600 mt-1">
                                <i class="fas fa-store mr-1"></i>
                                {{ $branch->vendor->name ?? __('agents.unknown_vendor') }}
                            </p>
                            <div class="flex items-center mt-2 text-xs text-gray-500">
                                <i class="fas fa-calendar-check mr-1"></i>
                                {{ $branch->vendor_visits_count }} {{ __('agents.visits') }}
                                <span class="mx-2">•</span>
                                <i class="fas fa-clock mr-1"></i>
                                {{ __('agents.added') }} {{ $branch->created_at->diffForHumans() }}
                            </div>
                        </div>
                        <div class="flex flex-col items-end space-y-2">
                            @if($branch->vendor_visits_count > 0)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ __('agents.active') }}
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    {{ __('agents.no_visits') }}
                                </span>
                            @endif
                            <a href="{{ route('branches.show', $branch->id) }}"
                               class="text-green-600 hover:text-green-800 text-xs flex items-center"
                               onclick="event.stopPropagation()">
                                <i class="fas fa-eye mr-1"></i>
                                {{ __('agents.view_details') }}
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8">
                <i class="fas fa-building text-gray-400 text-4xl mb-4"></i>
                <p class="text-gray-500">{{ __('agents.no_branches_assigned') }}</p>
            </div>
        @endif
    </div>
</div>

<!-- Quick Actions -->
<div class="mt-6 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-6">
    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
        <i class="fas fa-bolt mr-2 text-yellow-600"></i>
        {{ __('agents.quick_actions') }}
    </h3>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <a href="{{ route('agents.edit', $agent) }}"
           class="bg-white p-4 rounded-lg shadow-sm hover:shadow-md transition duration-200 flex items-center">
            <div class="bg-blue-100 p-3 rounded-full mr-4">
                <i class="fas fa-edit text-blue-600"></i>
            </div>
            <div>
                <h4 class="font-medium text-gray-900">{{ __('agents.edit_agent') }}</h4>
                <p class="text-sm text-gray-600">{{ __('agents.update_agent_info') }}</p>
            </div>
        </a>

        <a href="#" onclick="exportAgentData({{ $agent->id }})"
           class="bg-white p-4 rounded-lg shadow-sm hover:shadow-md transition duration-200 flex items-center">
            <div class="bg-green-100 p-3 rounded-full mr-4">
                <i class="fas fa-download text-green-600"></i>
            </div>
            <div>
                <h4 class="font-medium text-gray-900">{{ __('agents.export_data') }}</h4>
                <p class="text-sm text-gray-600">{{ __('agents.download_agent_report') }}</p>
            </div>
        </a>

        <a href="#" onclick="sendMessage({{ $agent->id }})"
           class="bg-white p-4 rounded-lg shadow-sm hover:shadow-md transition duration-200 flex items-center">
            <div class="bg-purple-100 p-3 rounded-full mr-4">
                <i class="fas fa-envelope text-purple-600"></i>
            </div>
            <div>
                <h4 class="font-medium text-gray-900">{{ __('agents.send_message') }}</h4>
                <p class="text-sm text-gray-600">{{ __('agents.contact_agent') }}</p>
            </div>
        </a>
    </div>
</div>

@push('scripts')
<script>
function exportAgentData(agentId) {
    alert('{{ __('agents.export_functionality_coming_soon') }}');
}

function sendMessage(agentId) {
    alert('{{ __('agents.messaging_functionality_coming_soon') }}');
}
</script>
@endpush
