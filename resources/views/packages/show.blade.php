@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="flex items-center mb-6">
            <a href="{{ route('packages.index') }}" class="text-blue-600 hover:text-blue-700 mr-4">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Package Details</h1>
        </div>
        <div class="bg-white rounded-lg shadow-md p-8">
            <div class="mb-6">
                <h2 class="text-2xl font-semibold text-gray-900 mb-2">{{ $package->name }}</h2>
                <span class="px-3 py-1 rounded-full text-xs font-medium {{ $package->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ $package->is_active ? 'Active' : 'Inactive' }}
                </span>
            </div>
            <div class="mb-4">
                <p class="text-gray-700 mb-2"><span class="font-semibold">Description:</span> {{ $package->description ?? 'N/A' }}</p>
                <p class="text-gray-700 mb-2"><span class="font-semibold">Price:</span> SAR {{ number_format($package->price, 2) }}</p>
                <p class="text-gray-700 mb-2"><span class="font-semibold">Product Limit:</span> {{ $package->product_limit ?? 'Unlimited' }}</p>
                <p class="text-gray-700 mb-2"><span class="font-semibold">Duration:</span> {{ $package->duration_in_days ? $package->duration_in_days . ' days' : 'N/A' }}</p>
                <p class="text-gray-700 mb-2"><span class="font-semibold">Created At:</span> {{ $package->created_at->format('M d, Y H:i') }}</p>
                <p class="text-gray-700 mb-2"><span class="font-semibold">Last Updated:</span> {{ $package->updated_at->format('M d, Y H:i') }}</p>
            </div>
            <div class="flex justify-end space-x-4 mt-8">
                <a href="{{ route('packages.edit', $package) }}" class="px-6 py-3 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg transition-colors flex items-center">
                    <i class="fas fa-edit mr-2"></i> Edit
                </a>
                <form id="deleteForm" action="{{ route('packages.destroy', $package) }}" method="POST">
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
    if (confirm('Are you sure you want to delete this package? This action cannot be undone.')) {
        document.getElementById('deleteForm').submit();
    }
}
</script>
@endsection
