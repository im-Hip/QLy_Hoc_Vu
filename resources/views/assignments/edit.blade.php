@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold mb-4">Sửa bài tập</h2>

    <form action="{{ route('assignments.update', $assignment->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block font-medium mb-1">Tiêu đề</label>
            <input type="text" name="title" value="{{ old('title', $assignment->title) }}" 
                   class="w-full border p-2 rounded">
        </div>

        <div class="mb-4">
            <label class="block font-medium mb-1">Nội dung</label>
            <textarea name="content" rows="4" class="w-full border p-2 rounded">{{ old('content', $assignment->content) }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block font-medium mb-1">Ngày hết hạn</label>
            <input type="datetime-local" name="due_date" value="{{ old('due_date', \Carbon\Carbon::parse($assignment->due_date)->format('Y-m-d\TH:i')) }}" 
                   class="w-full border p-2 rounded">
        </div>

        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Cập nhật</button>
        <a href="{{ route('assignments.index') }}" class="px-4 py-2 bg-gray-300 text-black rounded ml-2">Hủy</a>
    </form>
</div>
@endsection
