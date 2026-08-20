@php
$breadcrumbs = [
    'Master Data' => null,
    'Siswa'       => route('admin.students.index'),
    $student->name => route('admin.students.show', $student),
    'Input Hasil Belajar' => null,
];
@endphp

<x-app-layout :breadcrumbs="$breadcrumbs">
    <x-slot name="pageTitle">Input Hasil Belajar</x-slot>

    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">

            {{-- Header --}}
            <div class="h-2 bg-gradient-to-r from-indigo-500 to-purple-600"></div>
            <div class="px-8 py-6 border-b border-gray-100">
                <h2 class="text-lg font-bold text-gray-900">Input Hasil Belajar</h2>
                <p class="text-sm text-gray-500 mt-1">
                    Siswa: <span class="font-semibold text-indigo-600">{{ $student->name }}</span>
                    &bull; {{ $student->package->name ?? '-' }}
                </p>
            </div>

            <form action="{{ route('admin.learning-results.store', $student) }}" method="POST" class="px-8 py-6 space-y-5">
                @csrf

                <div class="grid grid-cols-2 gap-5">
                    {{-- Tanggal Sesi --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Sesi</label>
                        <input type="date" name="session_date"
                            value="{{ old('session_date', date('Y-m-d')) }}"
                            class="w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm @error('session_date') border-red-400 @enderror">
                        @error('session_date') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Pertemuan Ke- --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pertemuan Ke-</label>
                        <input type="number" name="session_number" min="1"
                            value="{{ old('session_number', $nextSession) }}"
                            class="w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm @error('session_number') border-red-400 @enderror">
                        @error('session_number') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Tutor --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tutor <span class="text-gray-400 font-normal">(opsional)</span></label>
                    <select name="tutor_id" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        <option value="">-- Pilih Tutor --</option>
                        @foreach($tutors as $tutor)
                            <option value="{{ $tutor->id }}" {{ old('tutor_id') == $tutor->id ? 'selected' : '' }}>
                                {{ $tutor->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Materi --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Materi yang Diajarkan</label>
                    <input type="text" name="topic" placeholder="cth: Persamaan Linear, Aljabar Dasar..."
                        value="{{ old('topic') }}"
                        class="w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm @error('topic') border-red-400 @enderror">
                    @error('topic') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-2 gap-5">
                    {{-- Kehadiran --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kehadiran</label>
                        <select name="attendance" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                            <option value="hadir"  {{ old('attendance', 'hadir') == 'hadir' ? 'selected' : '' }}>✅ Hadir</option>
                            <option value="izin"   {{ old('attendance') == 'izin'  ? 'selected' : '' }}>🟡 Izin</option>
                            <option value="alfa"   {{ old('attendance') == 'alfa'  ? 'selected' : '' }}>❌ Alfa</option>
                        </select>
                    </div>

                    {{-- Nilai --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nilai <span class="text-gray-400 font-normal">(0–100, opsional)</span></label>
                        <input type="number" name="score" min="0" max="100"
                            value="{{ old('score') }}"
                            placeholder="cth: 85"
                            class="w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm @error('score') border-red-400 @enderror">
                        @error('score') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Catatan --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Catatan untuk Orang Tua <span class="text-gray-400 font-normal">(opsional)</span></label>
                    <textarea name="notes" rows="3"
                        placeholder="cth: Sudah paham konsep dasar, perlu latihan soal cerita..."
                        class="w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm @error('notes') border-red-400 @enderror">{{ old('notes') }}</textarea>
                    @error('notes') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- PR --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">PR / Tugas <span class="text-gray-400 font-normal">(opsional)</span></label>
                    <input type="text" name="homework"
                        value="{{ old('homework') }}"
                        placeholder="cth: Kerjakan latihan hal. 45–47 no. 1–10"
                        class="w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                </div>

                {{-- Actions --}}
                <div class="flex items-center justify-end gap-3 pt-2 border-t border-gray-100">
                    <a href="{{ route('admin.students.show', $student) }}"
                        class="px-5 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 transition">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-6 py-2 bg-indigo-600 text-white text-sm font-bold rounded-xl hover:bg-indigo-700 shadow-lg shadow-indigo-200 transition">
                        Simpan Hasil Belajar
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
