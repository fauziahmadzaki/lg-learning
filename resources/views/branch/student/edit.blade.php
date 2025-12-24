<x-app-layout :breadcrumbs="['Manajemen Siswa' => route('branch.students.index', $branch), 'Edit Data' => null]">
    <x-slot name="pageTitle">Edit Siswa: {{ $student->name }} - {{ $branch->name }}</x-slot>

    <div class="max-w-4xl mx-auto">

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-200">
            <div class="p-6 md:p-8">

                {{-- Header --}}
                <div class="mb-8 border-b border-gray-100 pb-4">
                    <h2 class="text-xl font-bold text-gray-800">Perbarui Data Siswa</h2>
                    <p class="text-sm text-gray-500 mt-1">
                        Edit informasi akademik, kontak, paket belajar, atau status siswa.
                    </p>
                </div>

                <form action="{{ route('branch.students.update', [$branch, $student]) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Panggil Admin Partial --}}
                    {{-- Variable $packages dikirim dari controller --}}
                    @include('admin.student.partials.form', [
                    'student' => $student,
                    'packages' => $packages,
                    'submit_text' => 'Perbarui Data',
                    'branch' => $branch,
                    'cancel_route' => route('branch.students.index', $branch)
                    ])

                </form>

            </div>
        </div>
    </div>
</x-app-layout>
