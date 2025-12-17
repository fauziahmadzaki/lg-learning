<x-app-layout :breadcrumbs="['Manajemen Tutor' => route('admin.tutors.index'), 'Edit Data' => null]">
    <x-slot name="pageTitle">Edit Tutor: {{ $tutor->user->name }}</x-slot>

    <div class="max-w-4xl mx-auto">

        {{-- Card Wrapper --}}
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-200">
            <div class="p-6 md:p-8">

                {{-- Header Form --}}
                <div class="mb-8 border-b border-gray-100 pb-4">
                    <h2 class="text-xl font-bold text-gray-800">Edit Profil Pengajar</h2>
                    <p class="text-sm text-gray-500 mt-1">
                        Perbarui informasi akun, kontak, keahlian, atau foto profil tutor.
                    </p>
                </div>

                {{-- FORM UPDATE --}}
                <form action="{{ route('admin.tutors.update', $tutor) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{--
                        Panggil Partial Form 
                        Variabel $tutor otomatis terkirim dari controller ke sini, lalu diteruskan ke partial
                        karena partial berada di scope yang sama.
                    --}}
                    @include('admin.tutor._form', [
                    'submit_text' => 'Perbarui Data Tutor',
                    'tutor' => $tutor // Eksplisit mengirim variabel agar lebih aman & jelas
                    ])

                </form>

            </div>
        </div>

    </div>
</x-app-layout>