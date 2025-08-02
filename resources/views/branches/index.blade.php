@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">{{ __('branches.branches_list') }}</h1>
        <a href="{{ route('branches.create') }}" class="bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded-lg flex items-center">
            <i class="fas fa-plus mr-2"></i> {{ __('branches.add_branch') }}
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
                <input type="text" id="search" placeholder="{{ __('branches.search_branches') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
            </div>
            <div class="flex gap-2">
                <select id="filter-city" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500">
                    <option value="">{{ __('branches.all_cities') }}</option>
                    <option value="Riyadh">{{ __('branches.riyadh') }}</option>
                    <option value="Jeddah">{{ __('branches.jeddah') }}</option>
                    <option value="Dammam">{{ __('branches.dammam') }}</option>
                </select>
                <select id="filter-agent" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500">
                    <option value="">{{ __('branches.all_agents') }}</option>
                    <option value="assigned">{{ __('branches.assigned') }}</option>
                    <option value="unassigned">{{ __('branches.unassigned') }}</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Branches Table -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('branches.branch') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('branches.vendor_name') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('branches.contact_info') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('branches.location') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('branches.agent') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('branches.added_by') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('branches.visits_history') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('branches.actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200" id="branches-table-body">
                    @foreach($branches as $branch)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <img class="h-10 w-10 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode($branch->name) }}&background=d97706&color=fff" alt="{{ $branch->name }}">
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $branch->name }}</div>
                                    <div class="text-sm text-gray-500">{{ __('branches.branch') }} #{{ str_pad($branch->id, 3, '0', STR_PAD_LEFT) }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $branch->vendor->commercial_name }}</div>
                            <div class="text-sm text-gray-500">{{ $branch->vendor->owner_name }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $branch->mobile }}</div>
                            <div class="text-sm text-gray-500">{{ $branch->email ?: __('branches.no_email') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $branch->city ?: __('branches.unknown') }}</div>
                            <div class="text-sm text-gray-500">{{ $branch->district ?: __('branches.unknown') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($branch->agent)
                                <div class="flex items-center">
                                    <img class="h-6 w-6 rounded-full mr-2" src="https://ui-avatars.com/api/?name={{ urlencode($branch->agent->name) }}&background=1e40af&color=fff" alt="{{ $branch->agent->name }}">
                                    <div>
                                        <div class="text-sm text-gray-900">{{ $branch->agent->name }}</div>
                                        <div class="text-sm text-gray-500">{{ __('branches.agent') }} #{{ str_pad($branch->agent->id, 3, '0', STR_PAD_LEFT) }}</div>
                                    </div>
                                </div>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    <i class="fas fa-user-slash mr-1"></i> {{ __('branches.unassigned') }}
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($branch->added_by && $branch->added_by_role)
                                <span class="text-sm text-gray-900">{{ $branch->added_by }}</span>
                                <span class="text-xs text-gray-500">
                                    (
                                    @if(strtolower($branch->added_by_role) == 'admin' || strtolower($branch->added_by_role) == 'superadmin')
                                        {{ __('branches.admin') }}
                                    @elseif(strtolower($branch->added_by_role) == 'agent')
                                        {{ __('branches.agent') }}
                                    @else
                                        {{ ucfirst($branch->added_by_role) }}
                                    @endif
                                    )
                                </span>
                            @else
                                <span class="text-gray-400">{{ __('branches.unknown') }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $branch->vendor_visits_count }}</div>
                            <div class="text-sm text-gray-500">{{ __('branches.visits_history') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="{{ route('branches.show', $branch) }}" class="text-blue-600 hover:text-blue-900">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('branches.edit', $branch) }}" class="text-indigo-600 hover:text-indigo-900">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('branches.destroy', $branch) }}" method="POST" class="inline" onsubmit="return confirm('{{ __('branches.confirm_delete') }}')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">
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
            {{ $branches->links() }}
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search');
    const filterCity = document.getElementById('filter-city');
    const filterAgent = document.getElementById('filter-agent');
    const tableBody = document.getElementById('branches-table-body');
    const rows = tableBody.querySelectorAll('tr');

    function filterTable() {
        const searchTerm = searchInput.value.toLowerCase();
        const cityFilter = filterCity.value;
        const agentFilter = filterAgent.value;

        rows.forEach(row => {
            const branchName = row.querySelector('td:first-child').textContent.toLowerCase();
            const vendorName = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
            const contact = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
            const location = row.querySelector('td:nth-child(4)').textContent.toLowerCase();
            const agentCell = row.querySelector('td:nth-child(5)');

            let showRow = branchName.includes(searchTerm) || vendorName.includes(searchTerm) || contact.includes(searchTerm);

            if (cityFilter) {
                showRow = showRow && location.includes(cityFilter.toLowerCase());
            }

            if (agentFilter) {
                const hasAgent = agentCell.querySelector('img') !== null;
                if (agentFilter === 'assigned') {
                    showRow = showRow && hasAgent;
                } else if (agentFilter === 'unassigned') {
                    showRow = showRow && !hasAgent;
                }
            }

            row.style.display = showRow ? '' : 'none';
        });
    }

    searchInput.addEventListener('input', filterTable);
    filterCity.addEventListener('change', filterTable);
    filterAgent.addEventListener('change', filterTable);
});
</script>
@endsection
