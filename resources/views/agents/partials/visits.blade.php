{{-- resources/views/agents/partials/visits.blade.php --}}

<div class="space-y-6">
    <!-- Filters and Search -->
    <div class="bg-gray-50 rounded-lg p-4">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
            <div class="flex items-center space-x-4">
                <div class="flex items-center">
                    <label for="date_filter" class="text-sm font-medium text-gray-700 mr-2">{{ __('agents.filter_by') }}:</label>
                    <select id="date_filter" class="border-gray-300 rounded-md shadow-sm text-sm">
                        <option value="all">{{ __('agents.all_time') }}</option>
                        <option value="today">{{ __('agents.today') }}</option>
                        <option value="week">{{ __('agents.week') }}</option>
                        <option value="month">{{ __('agents.month') }}</option>
                        <option value="quarter">{{ __('agents.quarter') }}</option>
                    </select>
                </div>
                <div class="flex items-center">
                    <label for="status_filter" class="text-sm font-medium text-gray-700 mr-2">{{ __('agents.status') }}:</label>
                    <select id="status_filter" class="border-gray-300 rounded-md shadow-sm text-sm">
                        <option value="all">{{ __('agents.all_status') }}</option>
                        <option value="completed">{{ __('agents.completed') }}</option>
                        <option value="pending">{{ __('agents.pending') }}</option>
                        <option value="cancelled">{{ __('agents.cancelled') }}</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Visits Table -->
    @if($vendorVisits->count() > 0)
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <i class="fas fa-store mr-2"></i>
                                    {{ __('agents.vendor_details') }}
                                </div>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <i class="fas fa-building mr-2"></i>
                                    {{ __('agents.branch') }}
                                </div>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <i class="fas fa-calendar mr-2"></i>
                                    {{ __('agents.visit_date_time') }}
                                </div>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <i class="fas fa-clock mr-2"></i>
                                    {{ __('agents.duration') }}
                                </div>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <i class="fas fa-flag mr-2"></i>
                                    {{ __('agents.status') }}
                                </div>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('agents.actions') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($vendorVisits as $visit)
                        <tr class="hover:bg-gray-50 transition duration-200 cursor-pointer"
                            onclick="window.location.href='{{ route('visits.show', $visit->id) }}'">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <img class="h-10 w-10 rounded-full bg-gray-300"
                                             src="https://ui-avatars.com/api/?name={{ urlencode($visit->vendor->name ?? 'Unknown') }}&background=6b7280&color=fff&size=40"
                                             alt="{{ $visit->vendor->name ?? 'Unknown' }}">
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900 hover:text-blue-600">
                                            {{ $visit->vendor->name ?? __('agents.unknown_vendor') }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            ID: #{{ $visit->vendor->id ?? 'N/A' }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    <a href="{{ route('branches.show', $visit->branch->id ?? '#') }}"
                                       class="hover:text-blue-600 hover:underline"
                                       onclick="event.stopPropagation()">
                                        {{ $visit->branch->name ?? __('agents.unknown_branch') }}
                                    </a>
                                </div>
                                <div class="text-sm text-gray-500">
                                    @if($visit->branch && $visit->branch->address)
                                        <i class="fas fa-map-marker-alt mr-1"></i>
                                        {{ Str::limit($visit->branch->address, 30) }}
                                    @else
                                        <span class="text-gray-400">{{ __('agents.no_address') }}</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $visit->created_at->format('M d, Y') }}
                                </div>
                                <div class="text-sm text-gray-500">
                                    {{ $visit->created_at->format('h:i A') }}
                                </div>
                                <div class="text-xs text-gray-400">
                                    {{ $visit->created_at->diffForHumans() }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    @if(isset($visit->duration))
                                        {{ $visit->duration }} {{ __('agents.mins') }}
                                    @else
                                        <span class="text-gray-400">N/A</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check mr-1"></i>
                                    {{ __('agents.completed') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('visits.show', $visit->id) }}"
                                       class="text-blue-600 hover:text-blue-900 transition duration-200"
                                       title="{{ __('agents.view_details') }}"
                                       onclick="event.stopPropagation()">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('visits.edit', $visit->id) }}"
                                       class="text-indigo-600 hover:text-indigo-900 transition duration-200"
                                       title="{{ __('agents.edit_agent') }}"
                                       onclick="event.stopPropagation()">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button onclick="deleteVisit({{ $visit->id }}); event.stopPropagation();"
                                            class="text-red-600 hover:text-red-900 transition duration-200"
                                            title="{{ __('Delete Visit') }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if(method_exists($vendorVisits, 'links'))
            <div class="mt-6">
                {{ $vendorVisits->appends(['tab' => 'visits'])->links() }}
            </div>
        @endif

    @else
        <!-- Empty State -->
        <div class="bg-white rounded-lg shadow-sm p-12 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-gray-100 mb-4">
                <i class="fas fa-calendar-times text-gray-400 text-xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('agents.no_visits_found') }}</h3>
            <p class="text-gray-500 mb-6">{{ __('agents.agent_no_visits') }}</p>
            <button class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">
                <i class="fas fa-plus mr-2"></i>
                {{ __('agents.schedule_visit') }}
            </button>
        </div>
    @endif
</div>

@push('scripts')
<script>
function viewVisitDetails(visitId) {
    window.location.href = '/visits/' + visitId;
}

function editVisit(visitId) {
    window.location.href = '/visits/' + visitId + '/edit';
}

function deleteVisit(visitId) {
    if (confirm('{{ __('agents.delete_visit_confirm') }}')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/visits/' + visitId;

        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';

        const tokenInput = document.createElement('input');
        tokenInput.type = 'hidden';
        tokenInput.name = '_token';
        tokenInput.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        form.appendChild(methodInput);
        form.appendChild(tokenInput);
        document.body.appendChild(form);
        form.submit();
    }
}

function exportVisits() {
    alert('{{ __('agents.export_visits_coming_soon') }}');
}

function refreshVisits() {
    location.reload();
}

// Filter functionality
document.getElementById('date_filter').addEventListener('change', function() {
    console.log('Date filter changed:', this.value);
});

document.getElementById('status_filter').addEventListener('change', function() {
    console.log('Status filter changed:', this.value);
});
</script>
@endpush