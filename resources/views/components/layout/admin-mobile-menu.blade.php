<x-layout.responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
    {{ __('Dashboard') }}
</x-layout.responsive-nav-link>

<x-layout.mobile-menu-label>Master Data</x-layout.mobile-menu-label>

<x-layout.responsive-nav-link :href="route('admin.students.index')" :active="request()->routeIs('admin.students.*')">
    {{ __('Data Siswa') }}
</x-layout.responsive-nav-link>

<x-layout.responsive-nav-link :href="route('admin.tutors.index')" :active="request()->routeIs('admin.tutors.*')">
    {{ __('Data Tutor') }}
</x-layout.responsive-nav-link>

<x-layout.responsive-nav-link :href="route('admin.packages.index')" :active="request()->routeIs('admin.packages.*')">
    {{ __('Paket Belajar') }}
</x-layout.responsive-nav-link>

<x-layout.responsive-nav-link :href="route('admin.package-categories.index')" :active="request()->routeIs('admin.package-categories.*')">
    {{ __('Kategori Paket') }}
</x-layout.responsive-nav-link>

<x-layout.responsive-nav-link :href="route('admin.schedules.index')" :active="request()->routeIs('admin.schedules.*')">
    {{ __('Jadwal Belajar') }}
</x-layout.responsive-nav-link>

<x-layout.responsive-nav-link :href="route('admin.branches.index')" :active="request()->routeIs('admin.branches.*')">
    {{ __('Data Cabang') }}
</x-layout.responsive-nav-link>

<x-layout.responsive-nav-link :href="route('admin.contents.index')" :active="request()->routeIs('admin.contents.*')">
    {{ __('Galeri & Konten') }}
</x-layout.responsive-nav-link>

<x-layout.mobile-menu-label>Keuangan</x-layout.mobile-menu-label>

<x-layout.responsive-nav-link :href="route('admin.transactions.index')" :active="request()->routeIs('admin.transactions.*')">
    {{ __('Riwayat Transaksi') }}
</x-layout.responsive-nav-link>

<x-layout.mobile-menu-label>Laporan & Log</x-layout.mobile-menu-label>

<x-layout.responsive-nav-link :href="route('admin.reports.index')" :active="request()->routeIs('admin.reports.index')">
    {{ __('Laporan Keuangan') }}
</x-layout.responsive-nav-link>

<x-layout.responsive-nav-link :href="route('admin.reports.students')" :active="request()->routeIs('admin.reports.students')">
    {{ __('Laporan Siswa') }}
</x-layout.responsive-nav-link>

<x-layout.responsive-nav-link :href="route('admin.activity-logs.index')" :active="request()->routeIs('admin.activity-logs.index*')">
    {{ __('Log Aktivitas') }}
</x-layout.responsive-nav-link>

<x-layout.mobile-menu-label>Pengaturan</x-layout.mobile-menu-label>

<x-layout.responsive-nav-link :href="route('admin.settings.index')" :active="request()->routeIs('admin.settings.*')">
    {{ __('Pengaturan Website') }}
</x-layout.responsive-nav-link>
