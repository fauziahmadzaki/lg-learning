<x-app-layout :breadcrumbs="['Manajemen Siswa' => route('branch.students.index', $branch), 'Tambah Baru' => null]">
    <x-slot name="pageTitle">Registrasi Siswa Baru - {{ $branch->name }}</x-slot>

    <div class="max-w-4xl mx-auto">

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-200">
            <div class="p-6 md:p-8">

                {{-- Header --}}
                <div class="mb-8 border-b border-gray-100 pb-4">
                    <h2 class="text-xl font-bold text-gray-800">Formulir Pendaftaran</h2>
                    <p class="text-sm text-gray-500 mt-1">
                        Masukkan data diri siswa. Tentukan status awal (Active/Pending) sesuai kondisi pembayaran.
                    </p>
                </div>

                {{-- Form Wrapper --}}
                <form action="{{ route('branch.students.store', $branch) }}" method="POST">
                    @csrf

                    {{-- Panggil Admin Partial --}}
                    {{-- Perlu pass $branch jika _form membutuhkannya --}}
                    @include('admin.student.partials.form', [
                    'submit_text' => 'Simpan & Daftarkan Siswa',
                    'packages' => $packages,
                    'branch' => $branch // Pass just in case
                    ])

                </form>

            </div>
        </div>
    </div>
</x-app-layout>
