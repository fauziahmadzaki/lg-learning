<x-landing-layout title="Info Jadwal">
    {{-- Header Section --}}
    <div class="h-20 bg-white"></div>

    {{-- PAGE HEADER --}}
    <section class="bg-orange-50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl font-extrabold text-gray-900 mb-4">Jadwal Belajar</h1>
            <p class="text-lg text-gray-500 max-w-2xl mx-auto">
                Temukan jadwal kelas yang sesuai dengan kebutuhan belajarmu di berbagai cabang kami.
            </p>
        </div>
    </section>

    {{-- Main Content --}}
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        
        {{-- Card Container --}}
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
            <div class="p-6 sm:p-8 bg-white border-b border-gray-100 flex flex-col sm:flex-row justify-between items-center gap-4">
                <h2 class="text-2xl font-bold text-gray-900">Jadwal Minggu Ini</h2>
                <div class="text-sm text-gray-500">
                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-green-100 text-green-800">
                        <span class="w-2 h-2 mr-2 bg-green-400 rounded-full animate-pulse"></span>
                        Status: Terupdate
                    </span>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 text-gray-600 uppercase text-xs tracking-wider border-b border-gray-200">
                            <th class="px-6 py-4 font-bold">Hari</th>
                            <th class="px-6 py-4 font-bold">Jam</th>
                            <th class="px-6 py-4 font-bold">Kelas / Paket</th>
                            <th class="px-6 py-4 font-bold">Cabang</th>
                            <th class="px-6 py-4 font-bold">Status</th>
                            <th class="px-6 py-4 font-bold text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($schedules as $schedule)
                            @php
                                $dayMap = [
                                    'monday' => 'Senin',
                                    'tuesday' => 'Selasa',
                                    'wednesday' => 'Rabu',
                                    'thursday' => 'Kamis',
                                    'friday' => 'Jumat',
                                    'saturday' => 'Sabtu',
                                    'sunday' => 'Minggu',
                                ];
                                $dayLabel = $dayMap[strtolower($schedule->day_of_week)] ?? $schedule->day_of_week;
                                
                                // Determine Status based on Package Category or Type
                                // Assuming 'category' field in packages exists or name contains 'Privat'
                                $isPrivat = false;
                                if ($schedule->package) {
                                     $isPrivat = stripos($schedule->package->category, 'privat') !== false || stripos($schedule->package->name, 'privat') !== false;
                                }
                            @endphp
                            <tr class="hover:bg-gray-50/50 transition duration-150">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium bg-indigo-50 text-indigo-700">
                                        {{ $dayLabel }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-semibold">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        {{ substr($schedule->start_time, 0, 5) }} - {{ substr($schedule->end_time, 0, 5) }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-gray-900">{{ $schedule->package->name ?? '-' }}</div>
                                    <div class="text-xs text-gray-500">{{ $schedule->package->grade ?? '' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center text-sm text-gray-600">
                                        <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        {{ $schedule->branch->name ?? '-' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($isPrivat)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800 border border-purple-200">
                                            Privat
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 border border-blue-200">
                                            Reguler / Rombel
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    @if($schedule->package)
                                        <a href="{{ route('packages.show', $schedule->package->id) }}" class="text-orange-600 hover:text-orange-900 hover:underline">
                                            Detail Paket &rarr;
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                    <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <p class="mt-2 text-base font-medium">Belum ada jadwal yang tersedia.</p>
                                    <p class="text-sm">Silakan hubungi kami untuk informasi lebih lanjut.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            {{-- Footer Note --}}
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 text-xs text-center text-gray-500">
                * Jadwal dapat berubah sewaktu-waktu. Hubungi Admin cabang untuk konfirmasi slot.
            </div>
        </div>
    </div>
</x-landing-layout>
