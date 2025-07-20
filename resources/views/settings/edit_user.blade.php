@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-lg mx-auto bg-white rounded-lg shadow-md p-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Edit User</h1>
        @if($errors->any())
            <div class="mb-4 text-danger">
                <ul class="list-disc list-inside text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ route('settings.users.update', $user->id) }}" class="space-y-6">
            @csrf
            <div>
                <label for="name" class="block text-gray-700 font-medium mb-1">Name</label>
                <input id="name" name="name" type="text" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary" value="{{ old('name', $user->name) }}">
            </div>
            <div>
                <label for="email" class="block text-gray-700 font-medium mb-1">Email</label>
                <input id="email" name="email" type="email" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary" value="{{ old('email', $user->email) }}">
            </div>
            <div>
                <label for="password" class="block text-gray-700 font-medium mb-1">Password <span class="text-xs text-gray-400">(leave blank to keep current)</span></label>
                <input id="password" name="password" type="password" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
            </div>
            <div>
                <label for="role" class="block text-gray-700 font-medium mb-1">Role</label>
                <select id="role" name="role" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
                    <option value="">Select Role</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->name }}" {{ (old('role', $user->roles->first()->name ?? '') == $role->name) ? 'selected' : '' }}>{{ ucfirst($role->name) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex justify-end">
                <a href="{{ route('settings.users') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg mr-2">Cancel</a>
                <button type="submit" class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-blue-700">Update User</button>
            </div>
        </form>
    </div>
</div>
@endsection
