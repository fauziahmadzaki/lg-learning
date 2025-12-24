<x-ui.table :headers="['Siswa', 'Sekolah / Kelas', 'Paket Bimbel', 'Info Tagihan', 'Kontak Ortu', 'Status', '']" :paginator="$students">
    @forelse ($students as $student)
    <x-ui.tr>
        {{-- 1. Nama & Email --}}
        <x-ui.td>
            <div class="flex items-center">
                <div class="flex-shrink-0 h-10 w-10">
                    <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-sm border border-indigo-200">
                        {{ substr($student->name, 0, 2) }}
                    </div>
                </div>
                <div class="ml-4">
                    <a href="{{ route('branch.students.show', [$branch, $student]) }}" class="text-sm font-medium text-gray-900 hover:text-indigo-600 hover:underline">
                        {{ $student->name }}
                    </a>
                    <div class="text-xs text-gray-500">{{ $student->email }}</div>
                </div>
            </div>
        </x-ui.td>

        {{-- 2. Sekolah & Kelas --}}
        <x-ui.td>
            <div class="text-sm text-gray-900">{{ $student->school ?? '-' }}</div>
            <div class="text-xs text-gray-500">Kelas {{ $student->grade ?? '-' }}</div>
        </x-ui.td>



        {{-- 3. Paket --}}
        <x-ui.td>
            <div class="flex flex-wrap gap-1 max-w-[200px]">
                @if($student->package)
                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-blue-50 text-blue-700 border border-blue-100">
                    {{ $student->package->name }}
                </span>
                @else
                <span class="text-xs text-gray-400 italic">- Tidak ada paket -</span>
                @endif
            </div>
        </x-ui.td>

        {{-- 4. Info Tagihan --}}
        <x-ui.td>
            @if($student->billing_cycle == 'monthly')
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">Bulanan</span>
            @elseif($student->billing_cycle == 'weekly')
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">Mingguan</span>
            @else
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Lunas/Full</span>
            @endif

            @if($student->next_bill_date)
            <div class="text-[10px] text-gray-500 mt-1">Next: {{ $student->next_bill_date->format('d M Y') }}</div>
            @endif
        </x-ui.td>

        {{-- 5. Kontak --}}
        <x-ui.td class="text-gray-500">
            <div class="flex items-center gap-1">
                <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                </svg>
                {{ $student->parent_phone }}
            </div>
        </x-ui.td>

        {{-- 6. Status --}}
        <x-ui.td>
            @if($student->status == 'active')
            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Aktif</span>
            @elseif($student->status == 'pending')
            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
            @elseif($student->status == 'finished')
            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Selesai</span>
            @else
            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Non-Aktif</span>
            @endif
        </x-ui.td>

        {{-- 7. Aksi --}}
        <x-ui.td class="text-right font-medium">
            <div class="flex items-center justify-end gap-2">
                <a href="{{ route('branch.students.show', [$branch, $student]) }}" class="text-blue-600 hover:text-blue-900 bg-blue-50 p-1.5 rounded-lg hover:bg-blue-100 transition" title="Lihat Detail">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </a>
                <a href="{{ route('branch.students.edit', [$branch, $student]) }}" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 p-1.5 rounded-lg hover:bg-indigo-100 transition" title="Edit Data">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                    </svg>
                </a>
                <button @click.prevent="$dispatch('trigger-delete-modal', { url: '{{ route('branch.students.destroy', [$branch, $student]) }}', name: '{{ addslashes($student->name) }}' })" class="text-red-600 hover:text-red-900 bg-red-50 p-1.5 rounded-lg hover:bg-red-100 transition" title="Hapus Data">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </button>
            </div>
        </x-ui.td>
    </x-ui.tr>
    @empty
    <x-ui.tr>
        <x-ui.td colspan="7" class="text-center py-12">
            <div class="flex flex-col items-center justify-center">
                <svg class="h-10 w-10 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
                <span class="text-gray-500 font-medium">Tidak ada data siswa ditemukan</span>
                <p class="text-xs text-gray-400 mt-1">Coba kata kunci pencarian lain atau tambahkan siswa baru.</p>
            </div>
        </x-ui.td>
    </x-ui.tr>
    @endforelse
</x-ui.table>
