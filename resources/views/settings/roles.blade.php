@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Role Management</h1>
            <a href="{{ route('settings.roles.create') }}" class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-blue-700">
                <i class="fas fa-plus mr-2"></i> Add Role
            </a>
        </div>
        @if(session('success'))
            <div class="mb-4 text-green-600 font-medium">{{ session('success') }}</div>
        @endif
        <div class="bg-white rounded-lg shadow-md p-6">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Permissions</th>
                        <th class="px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($roles as $role)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap font-semibold">{{ $role->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($role->permissions->count())
                                    @foreach($role->permissions as $perm)
                                        <span class="inline-block bg-green-100 text-green-800 text-xs px-2 py-1 rounded mr-1">{{ $perm->name }}</span>
                                    @endforeach
                                @else
                                    <span class="text-xs text-gray-400">No permissions</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('settings.roles.edit', $role->id) }}" class="text-primary hover:underline mr-4"><i class="fas fa-edit"></i> Edit</a>
                                <form action="{{ route('settings.roles.delete', $role->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this role?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-danger hover:underline"><i class="fas fa-trash"></i> Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
