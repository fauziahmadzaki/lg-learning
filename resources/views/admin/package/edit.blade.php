<x-app-layout :breadcrumbs="['Paket Bimbel' => route('admin.packages.index'), 'Tambah Baru' => null]">
    <x-slot name="pageTitle">Edit Paket Belajar Baru</x-slot>

    <div class="max-w-4xl mx-auto">

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-200">
            <div class="p-6 md:p-8">

                <div class="mb-8 border-b border-gray-100 pb-4">
                    <h2 class="text-xl font-bold text-gray-800">Formulir Paket</h2>
                    <p class="text-sm text-gray-500 mt-1">
                        Lengkapi data paket, tentukan harga, dan pilih pengajar yang sesuai.
                    </p>
                </div>

                {{-- FORM WRAPPER --}}
                {{-- Penting: enctype="multipart/form-data" wajib ada untuk upload gambar --}}
                <form action="{{ route('admin.packages.update', $package) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    {{-- Panggil Partial Form --}}
                    {{-- Variable $branches dan $tutors otomatis tembus dari controller ke sini, lalu ke partial --}}
                    @include('admin.package.partials.form', [
                    'submit_text' => 'Simpan & Terbitkan Paket',
                    'package' => $package,
                    'branches' => $branches
                    ])

                </form>

            </div>
        </div>

    </div>
</x-app-layout>