@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">{{ __('vendors.vendors_list') }}</h1>
        <a href="{{ route('vendors.create') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg flex items-center">
            <i class="fas fa-plus mr-2"></i> {{ __('vendors.add_vendor') }}
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
                <input type="text" id="search" placeholder="{{ __('vendors.search_vendors') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
            </div>
            <div class="flex gap-2">
                <select id="filter-activity" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                    <option value="">{{ __('vendors.all_activities') }}</option>
                    <option value="wholesale">{{ __('vendors.wholesale') }}</option>
                    <option value="retail">{{ __('vendors.retail') }}</option>
                    <option value="both">{{ __('vendors.both') }}</option>
                </select>
                <select id="filter-city" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                    <option value="">{{ __('vendors.all_cities') }}</option>
                    <option value="Riyadh">{{ __('vendors.riyadh') }}</option>
                    <option value="Jeddah">{{ __('vendors.jeddah') }}</option>
                    <option value="Dammam">{{ __('vendors.dammam') }}</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Vendors Table -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('vendors.vendor') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('vendors.contact') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('vendors.location') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('vendors.activity') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('vendors.branches') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('vendors.status') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('vendors.added_by_agent') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('vendors.actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200" id="vendors-table-body">
                    @foreach($vendors as $vendor)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <img class="h-10 w-10 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode($vendor->commercial_name) }}&background=059669&color=fff" alt="{{ $vendor->commercial_name }}">
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $vendor->commercial_name }}</div>
                                    <div class="text-sm text-gray-500">{{ $vendor->owner_name }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $vendor->mobile }}</div>
                            <div class="text-sm text-gray-500">{{ $vendor->email ?: __('vendors.no_email') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $vendor->city ?: __('vendors.not_available') }}</div>
                            <div class="text-sm text-gray-500">{{ $vendor->district ?: __('vendors.not_available') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($vendor->activity_type)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $vendor->activity_type === 'wholesale' ? 'bg-blue-100 text-blue-800' :
                                       ($vendor->activity_type === 'retail' ? 'bg-green-100 text-green-800' : 'bg-purple-100 text-purple-800') }}">
                                    {{ __('vendors.' . $vendor->activity_type) }}
                                </span>
                            @else
                                <span class="text-sm text-gray-500">{{ __('vendors.not_specified') }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $vendor->branches_count }}</div>
                            <div class="text-sm text-gray-500">{{ __('vendors.branches') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($vendor->has_commercial_registration === 'yes')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check mr-1"></i> {{ __('vendors.registered') }}
                                </span>
                            @elseif($vendor->has_commercial_registration === 'no')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    <i class="fas fa-times mr-1"></i> {{ __('vendors.not_registered') }}
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    <i class="fas fa-question mr-1"></i> {{ __('vendors.unknown') }}
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($vendor->added_by && $vendor->added_by_role)
                                <span class="text-sm text-gray-900">{{ $vendor->added_by }}</span>
                                <span class="text-xs text-gray-500">
                                    (
                                    @if(strtolower($vendor->added_by_role) == 'admin' || strtolower($vendor->added_by_role) == 'superadmin')
                                        {{ __('vendors.admin') }}
                                    @elseif(strtolower($vendor->added_by_role) == 'agent')
                                        {{ __('vendors.agent') }}
                                    @else
                                        {{ ucfirst($vendor->added_by_role) }}
                                    @endif
                                    )
                                </span>
                            @elseif($vendor->agent)
                                <span class="text-sm text-gray-900">{{ $vendor->agent->name }}</span>
                                <span class="text-xs text-gray-500">({{ __('vendors.agent') }})</span>
                            @else
                                <span class="text-gray-400">{{ __('vendors.unknown') }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="{{ route('vendors.show', $vendor) }}" class="text-blue-600 hover:text-blue-900" title="{{ __('vendors.view') }}">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('vendors.edit', $vendor) }}" class="text-indigo-600 hover:text-indigo-900" title="{{ __('vendors.edit') }}">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('vendors.destroy', $vendor) }}" method="POST" class="inline" onsubmit="return confirm('{{ __('vendors.confirm_delete') }}')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" title="{{ __('vendors.delete') }}">
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
            {{ $vendors->links() }}
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search');
    const filterActivity = document.getElementById('filter-activity');
    const filterCity = document.getElementById('filter-city');
    const tableBody = document.getElementById('vendors-table-body');
    const rows = tableBody.querySelectorAll('tr');

    function filterTable() {
        const searchTerm = searchInput.value.toLowerCase();
        const activityFilter = filterActivity.value;
        const cityFilter = filterCity.value;

        rows.forEach(row => {
            const commercialName = row.querySelector('td:first-child').textContent.toLowerCase();
            const ownerName = row.querySelector('td:first-child div:nth-child(2)').textContent.toLowerCase();
            const contact = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
            const location = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
            const activity = row.querySelector('td:nth-child(4)').textContent.toLowerCase();

            let showRow = commercialName.includes(searchTerm) || ownerName.includes(searchTerm) || contact.includes(searchTerm);

            if (activityFilter) {
                showRow = showRow && activity.includes(activityFilter);
            }

            if (cityFilter) {
                showRow = showRow && location.includes(cityFilter.toLowerCase());
            }

            row.style.display = showRow ? '' : 'none';
        });
    }

    searchInput.addEventListener('input', filterTable);
    filterActivity.addEventListener('change', filterTable);
    filterCity.addEventListener('change', filterTable);
});
</script>
@endsection