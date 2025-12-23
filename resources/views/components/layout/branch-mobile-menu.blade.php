@props(['branch'])

@if(Auth::user()->isCentralAdmin())
    <x-layout.responsive-nav-link :href="route('admin.dashboard')" class="bg-indigo-50 text-indigo-700 font-bold border-l-4 border-indigo-500">
        &larr; {{ __('Kembali ke Dashboard Pusat') }}
    </x-layout.responsive-nav-link>
@endif

<x-layout.responsive-nav-link :href="route('branch.dashboard', $branch)" :active="request()->routeIs('branch.dashboard')">
    {{ __('Dashboard Cabang') }}
</x-layout.responsive-nav-link>

<x-layout.mobile-menu-label>Akademik</x-layout.mobile-menu-label>

<x-layout.responsive-nav-link :href="route('branch.students.index', $branch)" :active="request()->routeIs('branch.students.*')">
    {{ __('Data Siswa') }}
</x-layout.responsive-nav-link>

<x-layout.responsive-nav-link :href="route('branch.packages.index', $branch)" :active="request()->routeIs('branch.packages.*')">
    {{ __('Paket Belajar') }}
</x-layout.responsive-nav-link>

<x-layout.responsive-nav-link :href="route('branch.courses.index', $branch)" :active="request()->routeIs('branch.courses.*')">
    {{ __('Data Kelas') }}
</x-layout.responsive-nav-link>

<x-layout.responsive-nav-link :href="route('branch.schedules.index', $branch)" :active="request()->routeIs('branch.schedules.*')">
    {{ __('Jadwal Belajar') }}
</x-layout.responsive-nav-link>

<x-layout.mobile-menu-label>Keuangan</x-layout.mobile-menu-label>

<x-layout.responsive-nav-link :href="route('branch.transactions.index', $branch)" :active="request()->routeIs('branch.transactions.*')">
    {{ __('Riwayat Transaksi') }}
</x-layout.responsive-nav-link>

<x-layout.responsive-nav-link :href="route('branch.reports.index', $branch)" :active="request()->routeIs('branch.reports.index')">
    {{ __('Laporan Pemasukan') }}
</x-layout.responsive-nav-link>

<x-layout.responsive-nav-link :href="route('branch.reports.students', $branch)" :active="request()->routeIs('branch.reports.students')">
    {{ __('Laporan Siswa') }}
</x-layout.responsive-nav-link>
