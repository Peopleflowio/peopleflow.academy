@extends('layouts.admin')
@section('title', 'New Package')
@section('content')
<div class="max-w-xl">
    <h1 class="text-xl font-bold text-gray-900 mb-6">Create New Package</h1>
    <form action="{{ route('admin.academy.packages.store') }}" method="POST" class="bg-white border border-gray-200 rounded-xl p-6 space-y-4">
        @csrf
        <div>
            <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Title</label>
            <input type="text" name="title" value="{{ old('title') }}" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-400">
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Description</label>
            <textarea name="description" rows="3" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm resize-none focus:outline-none focus:border-blue-400">{{ old('description') }}</textarea>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Emoji Icon</label>
                <input type="text" name="emoji_icon" value="{{ old('emoji_icon', '📦') }}" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-400">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Price (cents)</label>
                <input type="number" name="price_cents" value="{{ old('price_cents', 0) }}" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-400">
                <div class="text-xs text-gray-400 mt-1">e.g. 29900 = $299.00</div>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <input type="checkbox" name="is_published" value="1" id="is_published" {{ old('is_published') ? 'checked' : '' }}>
            <label for="is_published" class="text-sm text-gray-700">Publish immediately</label>
        </div>
        <div class="flex gap-3 pt-2">
            <a href="{{ route('admin.academy.packages.index') }}" class="px-4 py-2 border border-gray-200 rounded-lg text-sm text-gray-600">Cancel</a>
            <button type="submit" class="px-5 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700">Create Package</button>
        </div>
    </form>
</div>
@endsection
