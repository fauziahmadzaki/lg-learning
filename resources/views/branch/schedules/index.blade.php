@php
    $breadcrumbs = [
        'Dashboard' => route('branch.dashboard', $branch),
        'Jadwal Belajar' => null,
    ];

    $days = [
        'monday' => 'Senin',
        'tuesday' => 'Selasa',
        'wednesday' => 'Rabu',
        'thursday' => 'Kamis',
        'friday' => 'Jumat',
        'saturday' => 'Sabtu',
        'sunday' => 'Minggu',
    ];
@endphp

<x-app-layout :breadcrumbs="$breadcrumbs">
    <x-slot name="pageTitle">Jadwal Belajar - {{ $branch->name }}</x-slot>

    <div class="space-y-8">
        
        @foreach($days as $dayKey => $dayName)
            @if(isset($schedules[$dayKey]) && count($schedules[$dayKey]) > 0)
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            {{ $dayName }}
                        </h3>
                        <span class="bg-white border border-gray-200 text-gray-500 text-xs font-bold px-2 py-1 rounded-full shadow-sm">
                            {{ count($schedules[$dayKey]) }} Sesi
                        </span>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-center">
                            <thead class="bg-gray-50/50 text-gray-500 font-medium border-b border-gray-100">
                                <tr>
                                    <th class="py-3 px-4 w-32">Waktu</th>
                                    <th class="py-3 px-4 text-left">Kelas / Paket</th>
                                    <th class="py-3 px-4 text-left">Tutor Pengampu</th>
                                    <th class="py-3 px-4 w-24">Kuota</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($schedules[$dayKey] as $schedule)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="py-4 px-4 font-bold text-gray-700">
                                            {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} - 
                                            {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}
                                        </td>
                                        <td class="py-4 px-4 text-left">
                                            <div class="font-bold text-gray-800">{{ $schedule->package->name }}</div>
                                            <div class="text-xs text-gray-500 mt-1">
                                                {{ $schedule->package->category }} &bull; {{ $schedule->package->grade }}
                                            </div>
                                        </td>
                                        <td class="py-4 px-4 text-left">
                                            <div class="flex flex-wrap gap-2">
                                                @forelse($schedule->package->tutors as $tutor)
                                                    <a href="{{ route('branch.profile', $branch) }}" class="inline-flex items-center gap-1.5 px-2 py-1 rounded bg-indigo-50 text-indigo-700 text-xs font-medium hover:bg-indigo-100 transition">
                                                        @if($tutor->image)
                                                            <img src="{{ asset('storage/' . $tutor->image) }}" class="w-4 h-4 rounded-full object-cover">
                                                        @else
                                                            <div class="w-4 h-4 rounded-full bg-indigo-200 flex items-center justify-center text-[8px] font-bold text-indigo-700">
                                                                {{ substr($tutor->user->name, 0, 1) }}
                                                            </div>
                                                        @endif
                                                        {{ explode(' ', $tutor->user->name)[0] }}
                                                    </a>
                                                @empty
                                                    <span class="text-xs text-gray-400 italic">Belum ada tutor</span>
                                                @endforelse
                                            </div>
                                        </td>
                                        <td class="py-4 px-4">
                                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-bold {{ $schedule->quota > 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                                {{ $schedule->quota }} Siswa
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        @endforeach

        @if($schedules->isEmpty())
            <div class="text-center py-16 bg-white rounded-xl border border-dashed border-gray-300">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-50 border border-gray-200 text-gray-400 mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900">Belum Ada Jadwal</h3>
                <p class="text-gray-500 mt-2">Belum ada jadwal belajar yang diatur untuk cabang ini.</p>
            </div>
        @endif

    </div>
</x-app-layout>
