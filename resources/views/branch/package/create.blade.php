<x-app-layout :breadcrumbs="['Paket Bimbel' => route('branch.packages.index', $branch), 'Tambah Baru' => null]">
    <x-slot name="pageTitle">Buat Paket Belajar Baru - {{ $branch->name }}</x-slot>

    <div class="max-w-4xl mx-auto">

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-200">
            <div class="p-6 md:p-8">

                <div class="mb-8 border-b border-gray-100 pb-4">
                    <h2 class="text-xl font-bold text-gray-800">Formulir Paket - {{ $branch->name }}</h2>
                    <p class="text-sm text-gray-500 mt-1">
                        Lengkapi data paket, tentukan harga, dan keuntungan.
                    </p>
                </div>

                {{-- FORM WRAPPER --}}
                <form action="{{ route('branch.packages.store', $branch) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    {{-- Pass $branch so _form knows we are in branch context (optional logic) --}}
                    @include('branch.package.partials.form', [
                    'submit_text' => 'Simpan & Terbitkan Paket',
                    'branch' => $branch
                    ])

                </form>

            </div>
        </div>

    </div>
</x-app-layout>
