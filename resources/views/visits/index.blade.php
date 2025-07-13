@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Vendor Visits</h1>
            <p class="text-gray-600 mt-2">Track and manage all vendor visits</p>
        </div>
        <a href="{{ route('visits.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg flex items-center transition-colors">
            <i class="fas fa-plus mr-2"></i>
            Add New Visit
        </a>
    </div>

    <!-- Search and Filters -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <input type="text" id="search" placeholder="Search visits..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <div>
                <select id="status-filter" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">All Status</option>
                    <option value="visited">Visited</option>
                    <option value="closed">Closed</option>
                    <option value="not_found">Not Found</option>
                    <option value="refused">Refused</option>
                </select>
            </div>
            <div>
                <select id="rating-filter" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">All Ratings</option>
                    <option value="very_interested">Very Interested</option>
                    <option value="hesitant">Hesitant</option>
                    <option value="refused">Refused</option>
                    <option value="inappropriate">Inappropriate</option>
                </select>
            </div>
            <div>
                <button onclick="exportVisits()" class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center justify-center">
                    <i class="fas fa-download mr-2"></i>
                    Export
                </button>
            </div>
        </div>
    </div>

    <!-- Visits Table -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Visit Details
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Vendor
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Agent
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status & Rating
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Package
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($visits as $visit)
                    <tr class="hover:bg-gray-50">
                        <!-- Visit Details -->
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                        <i class="fas fa-calendar-check text-blue-600"></i>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        Visit #{{ str_pad($visit->id, 4, '0', STR_PAD_LEFT) }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $visit->visit_date instanceof \Carbon\Carbon ? $visit->visit_date->format('M d, Y H:i') : $visit->visit_date }}
                                    </div>
                                    @if($visit->visit_end_at)
                                    <div class="text-xs text-gray-400">
                                        @if($visit->visit_date instanceof \Carbon\Carbon && $visit->visit_end_at instanceof \Carbon\Carbon)
                                            Duration: {{ $visit->visit_date->diffInMinutes($visit->visit_end_at) }} min
                                        @endif
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </td>

                        <!-- Vendor Info -->
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <img class="h-10 w-10 rounded-full"
                                         src="https://ui-avatars.com/api/?name={{ urlencode($visit->vendor->owner_name ?? $visit->vendor->commercial_name) }}&background=1e40af&color=fff"
                                         alt="Vendor">
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $visit->vendor->owner_name ?? 'N/A' }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $visit->vendor->commercial_name ?? 'N/A' }}
                                    </div>
                                    <div class="text-xs text-gray-400">
                                        {{ $visit->vendor->city ?? 'N/A' }}
                                    </div>
                                </div>
                            </div>
                        </td>

                        <!-- Agent Info -->
                        <td class="px-6 py-4">
                            @if($visit->agent)
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <img class="h-10 w-10 rounded-full"
                                         src="https://ui-avatars.com/api/?name={{ urlencode($visit->agent->name) }}&background=059669&color=fff"
                                         alt="Agent">
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $visit->agent->name }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        Agent #{{ str_pad($visit->agent->id, 3, '0', STR_PAD_LEFT) }}
                                    </div>
                                </div>
                            </div>
                            @else
                            <span class="text-gray-400 text-sm">No Agent</span>
                            @endif
                        </td>

                        <!-- Status & Rating -->
                        <td class="px-6 py-4">
                            <div class="space-y-2">
                                <div>
                                    @php
                                        $statusColors = [
                                            'visited' => 'bg-green-100 text-green-800',
                                            'closed' => 'bg-blue-100 text-blue-800',
                                            'not_found' => 'bg-yellow-100 text-yellow-800',
                                            'refused' => 'bg-red-100 text-red-800'
                                        ];
                                        $statusColor = $statusColors[$visit->visit_status] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span class="px-2 py-1 text-xs font-medium rounded-full {{ $statusColor }}">
                                        {{ ucfirst(str_replace('_', ' ', $visit->visit_status)) }}
                                    </span>
                                </div>
                                @if($visit->vendor_rating)
                                <div>
                                    @php
                                        $ratingColors = [
                                            'very_interested' => 'bg-green-100 text-green-800',
                                            'hesitant' => 'bg-yellow-100 text-yellow-800',
                                            'refused' => 'bg-red-100 text-red-800',
                                            'inappropriate' => 'bg-red-100 text-red-800'
                                        ];
                                        $ratingColor = $ratingColors[$visit->vendor_rating] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span class="px-2 py-1 text-xs font-medium rounded-full {{ $ratingColor }}">
                                        {{ ucfirst(str_replace('_', ' ', $visit->vendor_rating)) }}
                                    </span>
                                </div>
                                @endif
                            </div>
                        </td>

                        <!-- Package -->
                        <td class="px-6 py-4">
                            @if($visit->package)
                            <div class="text-sm text-gray-900">
                                {{ $visit->package->name }}
                            </div>
                            <div class="text-sm text-gray-500">
                                SAR {{ number_format($visit->package->price, 2) }}
                            </div>
                            @else
                            <span class="text-gray-400 text-sm">No Package</span>
                            @endif
                        </td>

                        <!-- Actions -->
                        <td class="px-6 py-4">
                            <div class="flex space-x-2">
                                <a href="{{ route('visits.show', $visit) }}"
                                   class="text-blue-600 hover:text-blue-700 p-2 rounded-lg hover:bg-blue-50 transition-colors"
                                   title="View Details">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('visits.edit', $visit) }}"
                                   class="text-yellow-600 hover:text-yellow-700 p-2 rounded-lg hover:bg-yellow-50 transition-colors"
                                   title="Edit Visit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button onclick="deleteVisit({{ $visit->id }})"
                                        class="text-red-600 hover:text-red-700 p-2 rounded-lg hover:bg-red-50 transition-colors"
                                        title="Delete Visit">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="text-center">
                                <i class="fas fa-calendar-times text-6xl text-gray-300 mb-4"></i>
                                <h3 class="text-xl font-semibold text-gray-600 mb-2">No Visits Found</h3>
                                <p class="text-gray-500 mb-6">Get started by creating your first vendor visit</p>
                                <a href="{{ route('visits.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg inline-flex items-center">
                                    <i class="fas fa-plus mr-2"></i>
                                    Create Visit
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($visits->hasPages())
    <div class="mt-8">
        {{ $visits->links() }}
    </div>
    @endif
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
        <div class="flex items-center mb-4">
            <i class="fas fa-exclamation-triangle text-red-500 text-2xl mr-3"></i>
            <h3 class="text-lg font-semibold text-gray-900">Delete Visit</h3>
        </div>
        <p class="text-gray-600 mb-6">Are you sure you want to delete this visit? This action cannot be undone.</p>
        <div class="flex justify-end space-x-3">
            <button onclick="closeDeleteModal()" class="px-4 py-2 text-gray-600 hover:text-gray-800 border border-gray-300 rounded-lg">
                Cancel
            </button>
            <button id="confirmDelete" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg">
                Delete
            </button>
        </div>
    </div>
</div>

<script>
let visitToDelete = null;

function deleteVisit(id) {
    visitToDelete = id;
    document.getElementById('deleteModal').classList.remove('hidden');
    document.getElementById('deleteModal').classList.add('flex');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
    document.getElementById('deleteModal').classList.remove('flex');
    visitToDelete = null;
}

document.getElementById('confirmDelete').addEventListener('click', function() {
    if (visitToDelete) {
        fetch(`/visits/${visitToDelete}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error deleting visit');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error deleting visit');
        });
    }
    closeDeleteModal();
});

// Search functionality
document.getElementById('search').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const rows = document.querySelectorAll('tbody tr');

    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        if (text.includes(searchTerm)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});

// Status filter
document.getElementById('status-filter').addEventListener('change', function(e) {
    filterVisits();
});

// Rating filter
document.getElementById('rating-filter').addEventListener('change', function(e) {
    filterVisits();
});

function filterVisits() {
    const statusFilter = document.getElementById('status-filter').value;
    const ratingFilter = document.getElementById('rating-filter').value;
    const rows = document.querySelectorAll('tbody tr');

    rows.forEach(row => {
        const statusCell = row.querySelector('td:nth-child(4) span:first-child');
        const ratingCell = row.querySelector('td:nth-child(4) span:last-child');

        const status = statusCell ? statusCell.textContent.toLowerCase().replace(/\s+/g, '_') : '';
        const rating = ratingCell ? ratingCell.textContent.toLowerCase().replace(/\s+/g, '_') : '';

        const statusMatch = !statusFilter || status.includes(statusFilter);
        const ratingMatch = !ratingFilter || rating.includes(ratingFilter);

        if (statusMatch && ratingMatch) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

function exportVisits() {
    window.location.href = '/visits/export';
}
</script>
@endsection
