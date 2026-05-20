@props(['branches' => []])

{{-- GRID CONTAINER --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

    @forelse ($branches as $branch)
        @include('admin.branch.partials.card', ['branch' => $branch])
    @empty
        <div class="col-span-full flex flex-col items-center justify-center p-12 bg-white rounded-xl border border-dashed border-gray-300">
            <div class="bg-gray-50 p-4 rounded-full mb-3">
                <svg class="h-10 w-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                    </path>
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900">Belum ada Cabang</h3>
            <p class="text-gray-500 mt-1 mb-6">Tambahkan lokasi cabang bimbel Anda atau coba kata kunci lain.</p>
            <a href="{{ route('admin.branches.create') }}">
                <x-buttons.primary>Tambah Cabang</x-buttons.primary>
            </a>
        </div>
    @endforelse

</div>

{{-- Pagination --}}
@if($branches instanceof \Illuminate\Pagination\LengthAwarePaginator)
<div class="mt-6">
    {{ $branches->links() }}
</div>
@endif
