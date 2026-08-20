@php
$breadcrumbs = [
    'Master Data' => null,
    'Siswa'       => route('admin.students.index'),
    $student->name => route('admin.students.show', $student),
    'Edit Hasil Belajar' => null,
];
@endphp

<x-app-layout :breadcrumbs="$breadcrumbs">
    <x-slot name="pageTitle">Edit Hasil Belajar</x-slot>

    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">

            <div class="h-2 bg-gradient-to-r from-amber-400 to-orange-500"></div>
            <div class="px-8 py-6 border-b border-gray-100">
                <h2 class="text-lg font-bold text-gray-900">Edit Hasil Belajar</h2>
                <p class="text-sm text-gray-500 mt-1">
                    Siswa: <span class="font-semibold text-indigo-600">{{ $student->name }}</span>
                    &bull; Sesi #{{ $learningResult->session_number }}
                </p>
            </div>

            <form action="{{ route('admin.learning-results.update', $learningResult) }}" method="POST" class="px-8 py-6 space-y-5">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Sesi</label>
                        <input type="date" name="session_date"
                            value="{{ old('session_date', $learningResult->session_date->format('Y-m-d')) }}"
                            class="w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm @error('session_date') border-red-400 @enderror">
                        @error('session_date') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pertemuan Ke-</label>
                        <input type="number" name="session_number" min="1"
                            value="{{ old('session_number', $learningResult->session_number) }}"
                            class="w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tutor <span class="text-gray-400 font-normal">(opsional)</span></label>
                    <select name="tutor_id" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        <option value="">-- Pilih Tutor --</option>
                        @foreach($tutors as $tutor)
                            <option value="{{ $tutor->id }}" {{ old('tutor_id', $learningResult->tutor_id) == $tutor->id ? 'selected' : '' }}>
                                {{ $tutor->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Materi yang Diajarkan</label>
                    <input type="text" name="topic"
                        value="{{ old('topic', $learningResult->topic) }}"
                        class="w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm @error('topic') border-red-400 @enderror">
                    @error('topic') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kehadiran</label>
                        <select name="attendance" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                            <option value="hadir" {{ old('attendance', $learningResult->attendance) == 'hadir' ? 'selected' : '' }}>✅ Hadir</option>
                            <option value="izin"  {{ old('attendance', $learningResult->attendance) == 'izin'  ? 'selected' : '' }}>🟡 Izin</option>
                            <option value="alfa"  {{ old('attendance', $learningResult->attendance) == 'alfa'  ? 'selected' : '' }}>❌ Alfa</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nilai <span class="text-gray-400 font-normal">(0–100)</span></label>
                        <input type="number" name="score" min="0" max="100"
                            value="{{ old('score', $learningResult->score) }}"
                            class="w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Catatan untuk Orang Tua</label>
                    <textarea name="notes" rows="3"
                        class="w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">{{ old('notes', $learningResult->notes) }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">PR / Tugas</label>
                    <input type="text" name="homework"
                        value="{{ old('homework', $learningResult->homework) }}"
                        class="w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                </div>

                <div class="flex items-center justify-between pt-2 border-t border-gray-100">
                    {{-- Tombol hapus --}}
                    <form action="{{ route('admin.learning-results.destroy', $learningResult) }}" method="POST"
                          onsubmit="return confirm('Yakin ingin menghapus data sesi ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-red-600 bg-red-50 border border-red-200 rounded-xl hover:bg-red-100 transition">
                            Hapus
                        </button>
                    </form>

                    <div class="flex gap-3">
                        <a href="{{ route('admin.students.show', $student) }}"
                            class="px-5 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 transition">
                            Batal
                        </a>
                        <button type="submit"
                            class="px-6 py-2 bg-indigo-600 text-white text-sm font-bold rounded-xl hover:bg-indigo-700 shadow-lg shadow-indigo-200 transition">
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
