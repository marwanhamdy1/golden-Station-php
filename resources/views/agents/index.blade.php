@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">{{ __('agents.agents_list') }}</h1>
        <a href="{{ route('agents.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg flex items-center">
            <i class="fas fa-plus mr-2"></i> {{ __('agents.add_agent') }}
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Search and Filter -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="flex flex-wrap gap-4">
            <div class="flex-1 min-w-64">
                <input type="text" id="search" placeholder="{{ __('agents.search_agents') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <div class="flex gap-2">
                <select id="filter-visits" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">{{ __('agents.all_visits') }}</option>
                    <option value="0">{{ __('agents.no_visits') }}</option>
                    <option value="1-10">1-10 {{ __('agents.visits') }}</option>
                    <option value="11-50">11-50 {{ __('agents.visits') }}</option>
                    <option value="50+">50+ {{ __('agents.visits') }}</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Agents Table -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('agents.agent') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('agents.contact') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('agents.visits') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('agents.location') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('agents.status') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('agents.actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200" id="agents-table-body">
                    @foreach($agents as $agent)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <img class="h-10 w-10 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode($agent->name) }}&background=1e40af&color=fff" alt="{{ $agent->name }}">
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $agent->name }}</div>
                                    <div class="text-sm text-gray-500">{{ __('agents.agent_number', ['number' => $agent->id]) }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $agent->email }}</div>
                            <div class="text-sm text-gray-500">{{ $agent->phone }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $agent->vendor_visits_count }}</div>
                            <div class="text-sm text-gray-500">{{ __('agents.visits') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($agent->last_latitude && $agent->last_longitude)
                                <div class="text-sm text-gray-900">
                                    <i class="fas fa-map-marker-alt text-red-500 mr-1"></i>
                                    {{ __('agents.active') }}
                                </div>
                                <div class="text-sm text-gray-500">
                                    {{ number_format($agent->last_latitude, 4) }}, {{ number_format($agent->last_longitude, 4) }}
                                </div>
                            @else
                                <div class="text-sm text-gray-500">{{ __('agents.no_location') }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($agent->vendor_visits_count > 0)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    {{ __('agents.active') }}
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    {{ __('agents.inactive') }}
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="{{ route('agents.show', $agent) }}" class="text-blue-600 hover:text-blue-900" title="{{ __('agents.view') }}">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('agents.edit', $agent) }}" class="text-indigo-600 hover:text-indigo-900" title="{{ __('agents.edit') }}">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('agents.destroy', $agent) }}" method="POST" class="inline" onsubmit="return confirm('{{ __('agents.confirm_delete') }}')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" title="{{ __('agents.delete') }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
            {{ $agents->links() }}
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search');
    const filterVisits = document.getElementById('filter-visits');
    const tableBody = document.getElementById('agents-table-body');
    const rows = tableBody.querySelectorAll('tr');

    function filterTable() {
        const searchTerm = searchInput.value.toLowerCase();
        const visitFilter = filterVisits.value;

        rows.forEach(row => {
            const name = row.querySelector('td:first-child').textContent.toLowerCase();
            const email = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
            const visitsText = row.querySelector('td:nth-child(3)').textContent.trim();
            const visits = parseInt(visitsText);

            let showRow = name.includes(searchTerm) || email.includes(searchTerm);

            if (visitFilter) {
                switch(visitFilter) {
                    case '0':
                        showRow = showRow && visits === 0;
                        break;
                    case '1-10':
                        showRow = showRow && visits >= 1 && visits <= 10;
                        break;
                    case '11-50':
                        showRow = showRow && visits >= 11 && visits <= 50;
                        break;
                    case '50+':
                        showRow = showRow && visits > 50;
                        break;
                }
            }

            row.style.display = showRow ? '' : 'none';
        });
    }

    searchInput.addEventListener('input', filterTable);
    filterVisits.addEventListener('change', filterTable);
});
</script>
@endsection