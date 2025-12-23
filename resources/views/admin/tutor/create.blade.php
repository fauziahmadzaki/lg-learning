<x-app-layout :breadcrumbs="['Manajemen Tutor' => route('admin.tutors.index'), 'Tambah Baru' => null]">
    <x-slot name="pageTitle">Tambah Tutor Baru</x-slot>

    <div class="max-w-4xl mx-auto">

        {{-- Card Wrapper (Style konsisten dengan Packages) --}}
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-200">
            <div class="p-6 md:p-8">

                {{-- Header Form --}}
                <div class="mb-8 border-b border-gray-100 pb-4">
                    <h2 class="text-xl font-bold text-gray-800">Formulir Tutor</h2>
                    <p class="text-sm text-gray-500 mt-1">
                        Lengkapi data pribadi, keahlian, dan informasi akun untuk pengajar baru.
                    </p>
                </div>

                {{-- FORM CREATE --}}
                <form action="{{ route('admin.tutors.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{--
                        Panggil Partial Form
                        Pastikan path 'tutor._form' sesuai dengan lokasi file partial Anda sebenarnya.
                        (Biasanya di: admin.tutors.partials._form atau tutor._form sesuai struktur folder Anda)
                    --}}
                    @include('admin.tutor.partials.form', [
                    'submit_text' => 'Simpan & Tambah Tutor'
                    ])

                </form>

            </div>
        </div>

    </div>
</x-app-layout>