{{-- resources/views/agents/partials/branches.blade.php --}}

<div class="space-y-6">
    <!-- Filters and Actions -->
    <div class="bg-gray-50 rounded-lg p-4">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
            <div class="flex items-center space-x-4">
                <div class="flex items-center">
                    <label for="vendor_filter" class="text-sm font-medium text-gray-700 mr-2">Vendor:</label>
                    <select id="vendor_filter" class="border-gray-300 rounded-md shadow-sm text-sm">
                        <option value="all">All Vendors</option>
                        @foreach($branches->unique('vendor.name') as $branch)
                            @if($branch->vendor)
                                <option value="{{ $branch->vendor->id }}">{{ $branch->vendor->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="flex items-center">
                    <label for="activity_filter" class="text-sm font-medium text-gray-700 mr-2">Activity:</label>
                    <select id="activity_filter" class="border-gray-300 rounded-md shadow-sm text-sm">
                        <option value="all">All Branches</option>
                        <option value="active">Active (with visits)</option>
                        <option value="inactive">Inactive (no visits)</option>
                    </select>
                </div>
            </div>

            <div class="flex items-center space-x-2">
                <button onclick="assignNewBranch()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm flex items-center">
                    <i class="fas fa-plus mr-2"></i>
                    Assign Branch
                </button>
                <button onclick="exportBranches()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm flex items-center">
                    <i class="fas fa-download mr-2"></i>
                    Export
                </button>
            </div>
        </div>
    </div>

    <!-- Branches Grid/List -->
    @if($branches->count() > 0)
        <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
            @foreach($branches as $branch)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition duration-200 cursor-pointer"
                 onclick="window.location.href='{{ route('branches.show', $branch->id) }}'">
                <!-- Branch Header -->
                <div class="p-6 border-b border-gray-200">
                    <div class="flex items-start justify-between">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <img class="h-12 w-12 rounded-lg bg-gray-300"
                                     src="https://ui-avatars.com/api/?name={{ urlencode($branch->name) }}&background=059669&color=fff&size=48"
                                     alt="{{ $branch->name }}">
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-gray-900 hover:text-green-600">{{ $branch->name }}</h3>
                                <p class="text-sm text-gray-600">
                                    {{ $branch->vendor->name ?? 'Unknown Vendor' }}
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-1">
                            <a href="{{ route('branches.edit', $branch->id) }}"
                               class="text-gray-400 hover:text-blue-600 transition duration-200"
                               title="Edit Branch"
                               onclick="event.stopPropagation()">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button onclick="removeBranch({{ $branch->id }}); event.stopPropagation();"
                                    class="text-gray-400 hover:text-red-600 transition duration-200"
                                    title="Remove Branch">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Branch Details -->
                <div class="p-6">
                    <!-- Address -->
                    @if($branch->address)
                    <div class="mb-4">
                        <div class="flex items-start">
                            <i class="fas fa-map-marker-alt text-gray-400 mt-1 mr-3 w-4"></i>
                            <div>
                                <p class="text-sm text-gray-900">{{ $branch->address }}</p>
                                @if($branch->city || $branch->state)
                                <p class="text-xs text-gray-500 mt-1">
                                    {{ $branch->city }}{{ $branch->city && $branch->state ? ', ' : '' }}{{ $branch->state }}
                                </p>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Contact Info -->
                    <div class="space-y-2 mb-4">
                        @if($branch->phone)
                        <div class="flex items-center text-sm">
                            <i class="fas fa-phone text-gray-400 mr-3 w-4"></i>
                            <span class="text-gray-900">{{ $branch->phone }}</span>
                        </div>
                        @endif

                        @if($branch->email)
                        <div class="flex items-center text-sm">
                            <i class="fas fa-envelope text-gray-400 mr-3 w-4"></i>
                            <span class="text-gray-900">{{ $branch->email }}</span>
                        </div>
                        @endif
                    </div>

                    <!-- Statistics -->
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div class="bg-blue-50 p-3 rounded-lg text-center">
                            <div class="text-2xl font-bold text-blue-600">{{ $branch->vendor_visits_count }}</div>
                            <div class="text-xs text-blue-600">Total Visits</div>
                        </div>
                        <div class="bg-green-50 p-3 rounded-lg text-center">
                            <div class="text-2xl font-bold text-green-600">
                                @if($branch->vendor_visits_count > 0)
                                    {{ $branch->vendorVisits()->where('created_at', '>=', now()->subDays(30))->count() }}
                                @else
                                    0
                                @endif
                            </div>
                            <div class="text-xs text-green-600">This Month</div>
                        </div>
                    </div>

                    <!-- Status and Actions -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            @if($branch->vendor_visits_count > 0)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check mr-1"></i>
                                    Active
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    <i class="fas fa-clock mr-1"></i>
                                    No Visits
                                </span>
                            @endif
                        </div>

                        <div class="flex items-center space-x-2">
                            <a href="{{ route('branches.show', $branch->id) }}"
                               class="text-blue-600 hover:text-blue-800 text-sm"
                               onclick="event.stopPropagation()">
                                <i class="fas fa-eye mr-1"></i>
                                View
                            </a>
                            <a href="{{ route('visits.create', ['branch_id' => $branch->id]) }}"
                               class="text-green-600 hover:text-green-800 text-sm"
                               onclick="event.stopPropagation()">
                                <i class="fas fa-calendar-plus mr-1"></i>
                                Visit
                            </a>
                        </div>
                    </div>

                    <!-- Last Visit Info -->
                    @if($branch->vendor_visits_count > 0)
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <div class="flex items-center text-xs text-gray-500">
                            <i class="fas fa-history mr-2"></i>
                            Last visit:
                            @php
                                $lastVisit = $branch->vendorVisits()->latest()->first();
                            @endphp
                            @if($lastVisit)
                                <a href="{{ route('visits.show', $lastVisit->id) }}"
                                   class="text-blue-600 hover:underline ml-1"
                                   onclick="event.stopPropagation()">
                                    {{ $lastVisit->created_at->diffForHumans() }}
                                </a>
                            @else
                                Never
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endforeachxs text-blue-600">Total Visits</div>
                        </div>
                        <div class="bg-green-50 p-3 rounded-lg text-center">
                            <div class="text-2xl font-bold text-green-600">
                                @if($branch->vendor_visits_count > 0)
                                    {{ $branch->vendorVisits()->where('created_at', '>=', now()->subDays(30))->count() }}
                                @else
                                    0
                                @endif
                            </div>
                            <div class="text-xs text-green-600">This Month</div>
                        </div>
                    </div>

                    <!-- Status and Actions -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            @if($branch->vendor_visits_count > 0)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check mr-1"></i>
                                    Active
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    <i class="fas fa-clock mr-1"></i>
                                    No Visits
                                </span>
                            @endif
                        </div>

                        <div class="flex items-center space-x-2">
                            <button onclick="viewBranchDetails({{ $branch->id }})"
                                    class="text-blue-600 hover:text-blue-800 text-sm">
                                <i class="fas fa-eye mr-1"></i>
                                View
                            </button>
                            <button onclick="scheduleBranchVisit({{ $branch->id }})"
                                    class="text-green-600 hover:text-green-800 text-sm">
                                <i class="fas fa-calendar-plus mr-1"></i>
                                Visit
                            </button>
                        </div>
                    </div>

                    <!-- Last Visit Info -->
                    @if($branch->vendor_visits_count > 0)
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <div class="flex items-center text-xs text-gray-500">
                            <i class="fas fa-history mr-2"></i>
                            Last visit:
                            @php
                                $lastVisit = $branch->vendorVisits()->latest()->first();
                            @endphp
                            @if($lastVisit)
                                {{ $lastVisit->created_at->diffForHumans() }}
                            @else
                                Never
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if(method_exists($branches, 'links'))
            <div class="mt-6">
                {{ $branches->appends(['tab' => 'branches'])->links() }}
            </div>
        @endif

    @else
        <!-- Empty State -->
        <div class="bg-white rounded-lg shadow-sm p-12 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-gray-100 mb-4">
                <i class="fas fa-building text-gray-400 text-xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No branches assigned</h3>
            <p class="text-gray-500 mb-6">This agent doesn't have any branches assigned yet.</p>
            <button onclick="assignNewBranch()" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg">
                <i class="fas fa-plus mr-2"></i>
                Assign First Branch
            </button>
        </div>
    @endif
</div>

@push('scripts')
<script>
function assignNewBranch() {
    // Implementation for assigning new branch
    alert('Assign new branch functionality coming soon!');
}

function editBranch(branchId) {
    // Implementation for editing branch
    alert('Edit branch: ' + branchId);
}

function removeBranch(branchId) {
    if (confirm('Are you sure you want to remove this branch assignment?')) {
        // Implementation for removing branch
        alert('Remove branch: ' + branchId);
    }
}

function viewBranchDetails(branchId) {
    // Implementation for viewing branch details
    alert('View branch details: ' + branchId);
}

function scheduleBranchVisit(branchId) {
    // Implementation for scheduling branch visit
    alert('Schedule visit for branch: ' + branchId);
}

function exportBranches() {
    // Implementation for exporting branches
    alert('Export branches functionality coming soon!');
}

// Filter functionality
document.getElementById('vendor_filter').addEventListener('change', function() {
    // Implementation for vendor filtering
    console.log('Vendor filter changed:', this.value);
});

document.getElementById('activity_filter').addEventListener('change', function() {
    // Implementation for activity filtering
    console.log('Activity filter changed:', this.value);
});
</script>
@endpush
