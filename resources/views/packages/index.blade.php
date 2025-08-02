@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">{{ __('packages.packages_management') }}</h1>
            <p class="text-gray-600 mt-2">{{ __('packages.manage_packages_description') }}</p>
        </div>
        <a href="{{ route('packages.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg flex items-center transition-colors">
            <i class="fas fa-plus mr-2"></i>
            {{ __('packages.add_new_package') }}
        </a>
    </div>

    <!-- Search and Filters -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <input type="text" id="search" placeholder="{{ __('packages.search_packages') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <div class="flex gap-2">
                <select id="status-filter" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">{{ __('packages.all_status') }}</option>
                    <option value="1">{{ __('packages.active') }}</option>
                    <option value="0">{{ __('packages.inactive') }}</option>
                </select>
                {{-- <button onclick="exportPackages()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center">
                    <i class="fas fa-download mr-2"></i>
                    {{ __('packages.export') }}
                </button> --}}
            </div>
        </div>
    </div>

    <!-- Packages Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="packages-grid">
        @forelse($packages as $package)
        <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow border border-gray-200">
            <!-- Package Header -->
            <div class="p-6 border-b border-gray-200">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900">{{ $package->name }}</h3>
                        <p class="text-gray-600 text-sm mt-1">{{ Str::limit($package->description, 80) }}</p>
                    </div>
                    <div class="flex items-center">
                        <span class="px-3 py-1 rounded-full text-xs font-medium {{ $package->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $package->is_active ? __('packages.active') : __('packages.inactive') }}
                        </span>
                    </div>
                </div>

                <!-- Price -->
                <div class="text-center mb-4">
                    <div class="text-3xl font-bold text-blue-600">SAR {{ number_format($package->price, 2) }}</div>
                    <p class="text-gray-500 text-sm">{{ __('packages.package_price') }}</p>
                </div>

                <!-- Features -->
                <div class="space-y-2">
                    @if($package->product_limit)
                    <div class="flex items-center text-sm text-gray-600">
                        <i class="fas fa-box text-blue-500 mr-2"></i>
                        {{ __('packages.product_limit', ['count' => number_format($package->product_limit)]) }}
                    </div>
                    @endif
                    @if($package->duration_in_days)
                    <div class="flex items-center text-sm text-gray-600">
                        <i class="fas fa-calendar text-green-500 mr-2"></i>
                        {{ __('packages.duration_days', ['count' => $package->duration_in_days]) }}
                    </div>
                    @endif
                </div>
            </div>

            <!-- Actions -->
            <div class="p-6">
                <div class="flex justify-between items-center">
                    <div class="text-sm text-gray-500">
                        {{ __('packages.created_at', ['date' => $package->created_at->format('M d, Y')]) }}
                    </div>
                    <div class="flex space-x-2">
                        <a href="{{ route('packages.show', $package) }}" class="text-blue-600 hover:text-blue-700 p-2 rounded-lg hover:bg-blue-50 transition-colors" title="{{ __('packages.view') }}">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('packages.edit', $package) }}" class="text-yellow-600 hover:text-yellow-700 p-2 rounded-lg hover:bg-yellow-50 transition-colors" title="{{ __('packages.edit') }}">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button onclick="deletePackage({{ $package->id }})" class="text-red-600 hover:text-red-700 p-2 rounded-lg hover:bg-red-50 transition-colors" title="{{ __('packages.delete') }}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full">
            <div class="text-center py-12">
                <i class="fas fa-box text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-600 mb-2">{{ __('packages.no_packages_found') }}</h3>
                <p class="text-gray-500 mb-6">{{ __('packages.get_started') }}</p>
                <a href="{{ route('packages.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg inline-flex items-center">
                    <i class="fas fa-plus mr-2"></i>
                    {{ __('packages.create_package') }}
                </a>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($packages->hasPages())
    <div class="mt-8">
        {{ $packages->links() }}
    </div>
    @endif
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
        <div class="flex items-center mb-4">
            <i class="fas fa-exclamation-triangle text-red-500 text-2xl mr-3"></i>
            <h3 class="text-lg font-semibold text-gray-900">{{ __('packages.delete_package') }}</h3>
        </div>
        <p class="text-gray-600 mb-6">{{ __('packages.delete_confirmation') }}</p>
        <div class="flex justify-end space-x-3">
            <button onclick="closeDeleteModal()" class="px-4 py-2 text-gray-600 hover:text-gray-800 border border-gray-300 rounded-lg">
                {{ __('packages.cancel') }}
            </button>
            <button id="confirmDelete" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg">
                {{ __('packages.delete') }}
            </button>
        </div>
    </div>
</div>

<script>
let packageToDelete = null;

function deletePackage(id) {
    packageToDelete = id;
    document.getElementById('deleteModal').classList.remove('hidden');
    document.getElementById('deleteModal').classList.add('flex');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
    document.getElementById('deleteModal').classList.remove('flex');
    packageToDelete = null;
}

document.getElementById('confirmDelete').addEventListener('click', function() {
    if (packageToDelete) {
        fetch(`/packages/${packageToDelete}`, {
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
                alert('{{ __('packages.package_deleted_error') }}');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('{{ __('packages.package_deleted_error') }}');
        });
    }
    closeDeleteModal();
});

// Search functionality
document.getElementById('search').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const packages = document.querySelectorAll('#packages-grid > div');

    packages.forEach(package => {
        const name = package.querySelector('h3').textContent.toLowerCase();
        const description = package.querySelector('p').textContent.toLowerCase();

        if (name.includes(searchTerm) || description.includes(searchTerm)) {
            package.style.display = 'block';
        } else {
            package.style.display = 'none';
        }
    });
});

// Status filter
document.getElementById('status-filter').addEventListener('change', function(e) {
    const status = e.target.value;
    const packages = document.querySelectorAll('#packages-grid > div');

    packages.forEach(package => {
        const statusBadge = package.querySelector('span');
        const packageStatus = statusBadge.textContent.toLowerCase();

        if (!status || (status === '1' && packageStatus === '{{ strtolower(__('packages.active')) }}') || (status === '0' && packageStatus === '{{ strtolower(__('packages.inactive')) }}')) {
            package.style.display = 'block';
        } else {
            package.style.display = 'none';
        }
    });
});

function exportPackages() {
    window.location.href = '/packages/export';
}
</script>
@endsection