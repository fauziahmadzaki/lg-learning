@php
$breadcrumbs = [
'Cabang' => route('branches.index'),
'Tambah' => route('branches.create')
];
@endphp

<x-app-layout :breadcrumbs="$breadcrumbs">
    <x-slot name="pageTitle">Tambah Cabang</x-slot>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-xl">
                <section>
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            Informasi Cabang
                        </h2>

                        <p class="mt-1 text-sm text-gray-600">
                            Isikan informasi cabang
                        </p>
                    </header>

                    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                        @csrf
                    </form>

                    <form method="post" action="{{ route('branches.store') }}" class="mt-6 space-y-6">
                        @csrf
                        @method('post')


                        @include('admin.branch._form')
                    </form>
                </section>
            </div>
        </div>


    </div>

</x-app-layout>