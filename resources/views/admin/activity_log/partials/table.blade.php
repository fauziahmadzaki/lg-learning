<x-ui.table :headers="['Waktu & Cabang', 'Aktor (User)',  'Deskripsi']" :paginator="$logs">
    @forelse ($logs as $log)
    <x-ui.tr>

        {{-- Kolom 1: Waktu & Cabang --}}
        <x-ui.td>
            <div class="flex flex-col">
                <span class="font-bold text-gray-800">{{ $log->created_at->format('d M Y') }}</span>
                <span class="text-xs text-gray-500">{{ $log->created_at->format('H:i') }} WIB</span>

                <div class="mt-1">
                    <span
                        class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">
                        {{ $log->branch ? $log->branch->name : 'Pusat' }}
                    </span>
                </div>
            </div>
        </x-ui.td>

        {{-- Kolom 2: Aktor --}}
        <x-ui.td>
            <div class="flex items-center gap-3">
                <div
                    class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 font-bold text-xs uppercase">
                    {{ substr($log->user ? $log->user->name : 'S', 0, 2) }}
                </div>
                <div>
                    <div class="font-medium text-gray-900">
                        {{ $log->user ? $log->user->name : 'Sistem' }}
                    </div>
                    <div class="text-xs text-gray-500">{{ $log->user ? $log->user->email : '-' }}</div>
                </div>
            </div>
        </x-ui.td>

        {{-- Kolom 4: Deskripsi --}}
        <x-ui.td class="whitespace-normal min-w-[300px]">
            <div class="text-gray-700 text-sm">
                {{ $log->description }}
            </div>
            @if($log->subject_type)
            <div class="text-xs text-gray-400 mt-1 font-mono">
                Target: {{ class_basename($log->subject_type) }} #{{ $log->subject_id }}
            </div>
            @endif
        </x-ui.td>

    </x-ui.tr>
    @empty
    <x-ui.tr>
        <x-ui.td colspan="5" class="px-6 py-12 text-center">
            <div class="flex flex-col items-center justify-center">
                <div class="bg-gray-50 p-4 rounded-full mb-3">
                    <svg class="h-10 w-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900">Belum ada Aktivitas</h3>
                <p class="text-gray-500 mt-1 max-w-sm">
                    Belum ada riwayat perubahan data yang tercatat di sistem.
                </p>
            </div>
        </x-ui.td>
    </x-ui.tr>
    @endforelse
</x-ui.table>
