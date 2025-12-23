@props(['tutors' => []])

{{-- GRID CONTAINER --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

    @forelse ($tutors as $tutor)
        @include('admin.tutor.partials.card', ['tutor' => $tutor])
    @empty
        {{-- Empty State --}}
        <div class="col-span-full flex flex-col items-center justify-center p-16 bg-white rounded-2xl border border-dashed border-gray-300 text-center">
            <div class="bg-indigo-50 p-4 rounded-full mb-4">
                <svg class="h-10 w-10 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                    </path>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900">Belum ada Tutor</h3>
            <p class="text-gray-500 mt-2 mb-8 max-w-sm">Data pengajar tidak ditemukan.</p>
            <a href="{{ route('admin.tutors.create') }}">
                <x-buttons.primary class="px-6 py-2.5">Tambah Tutor</x-buttons.primary>
            </a>
        </div>
    @endforelse

</div>

{{-- Pagination --}}
@if($tutors instanceof \Illuminate\Pagination\LengthAwarePaginator)
<div class="mt-8">
    {{ $tutors->links() }}
</div>
@endif
