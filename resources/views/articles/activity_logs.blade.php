@extends('layouts.admin') {{-- Make sure this extends your main admin layout --}}

@section('title', 'Admin Activity Logs')

@section('content')
    <div class="w-full max-w-7xl mx-auto flex flex-col gap-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-1 flex items-center gap-2">
                    <span class="material-icons text-gray-400">history</span>
                    Admin Activity Logs
                </h1>
                <p class="text-gray-700 text-base">Detailed record of administrative actions performed in the system.</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow p-6">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead>
                    <tr class="bg-gray-50">
                        <th class="px-4 py-3 text-xs font-semibold text-gray-700 uppercase tracking-wider text-left">
                            User Name
                        </th>
                        <th class="px-4 py-3 text-xs font-semibold text-gray-700 uppercase tracking-wider text-left">
                            User Email
                        </th>
                        <th class="px-4 py-3 text-xs font-semibold text-gray-700 uppercase tracking-wider text-left">
                            Action
                        </th>
                        <th class="px-4 py-3 text-xs font-semibold text-gray-700 uppercase tracking-wider text-left">
                            Description
                        </th>
                        <th class="px-4 py-3 text-xs font-semibold text-gray-700 uppercase tracking-wider text-left">
                            Item Type
                        </th>
                        <th class="px-4 py-3 text-xs font-semibold text-gray-700 uppercase tracking-wider text-left">
                            Timestamp
                        </th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                    @forelse ($activityLogs as $log)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3 text-gray-700">{{ $log->user->name ?? 'N/A' }}</td>
                            <td class="px-4 py-3 text-gray-700">{{ $log->user->email ?? 'N/A' }}</td> {{-- Added User Email --}}
                            <td class="px-4 py-3">
                                @php
                                    $actionClass = '';
                                    if ($log->action === 'created') {
                                        $actionClass = 'text-green-600';
                                    } elseif ($log->action === 'updated') {
                                        $actionClass = 'text-blue-600';
                                    } elseif ($log->action === 'deleted') {
                                        $actionClass = 'text-red-600';
                                    }
                                @endphp
                                <span class="font-medium {{ $actionClass }}">{{ ucfirst($log->action) }}</span>
                            </td>
                            <td class="px-4 py-3 text-gray-700">
                                {{-- Display truncated title and make it a link if it's an Article --}}
                                @if ($log->loggable_type === \App\Models\Article::class && $log->loggable)
                                    Article "<a href="{{ route('articles.show', $log->loggable) }}" class="text-blue-600 hover:underline">
                                        {{ Str::limit($log->loggable->title, 10) }}
                                    </a>" was {{ $log->action }}.
                                @else
                                    {{ $log->description }}
                                @endif
                            </td>
                            <td class="px-4 py-3 text-gray-700">{{ class_basename($log->loggable_type) }}</td>
                            <td class="px-4 py-3 text-gray-500 text-sm">{{ $log->created_at->diffForHumans() }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-3 text-center text-gray-700">No activity logs found.</td> {{-- Adjusted colspan --}}
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="flex items-center justify-between mt-6">
                <div class="text-sm text-gray-700">
                    Showing <span class="font-medium">{{ $activityLogs->firstItem() }}</span> to
                    <span class="font-medium">{{ $activityLogs->lastItem() }}</span> of
                    <span class="font-medium">{{ $activityLogs->total() }}</span> results
                </div>
                <div class="flex items-center gap-2">
                    {{ $activityLogs->links('pagination::tailwind') }}
                </div>
            </div>
        </div>
    </div>
@endsection
