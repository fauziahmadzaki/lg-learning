<x-app-layout :breadcrumbs="['Panduan Sistem' => null]">
    <x-slot name="pageTitle">Panduan Sistem (Manual Book)</x-slot>

    <div class="py-12" x-data="{ activeSection: 'intro' }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row gap-6">

                {{-- SIDEBAR NAV (Table of Contents) --}}
                <div class="w-full lg:w-1/4">
                    <div class="bg-white shadow-sm rounded-lg p-4 sticky top-6">
                        <h3 class="font-bold text-gray-900 mb-4 border-b pb-2">Daftar Isi</h3>
                        <nav class="space-y-1">
                            <a href="#intro" 
                               @click.prevent="activeSection = 'intro'; document.getElementById('intro').scrollIntoView({behavior: 'smooth'})"
                               :class="activeSection === 'intro' ? 'bg-indigo-50 text-indigo-700 font-bold' : 'text-gray-600 hover:bg-gray-50'"
                               class="block px-3 py-2 rounded-md text-sm transition">
                                1. Pendahuluan
                            </a>
                            <a href="#siswa"
                               @click.prevent="activeSection = 'siswa'; document.getElementById('siswa').scrollIntoView({behavior: 'smooth'})"
                               :class="activeSection === 'siswa' ? 'bg-indigo-50 text-indigo-700 font-bold' : 'text-gray-600 hover:bg-gray-50'"
                               class="block px-3 py-2 rounded-md text-sm transition">
                                2. Manajemen Siswa
                            </a>
                            <a href="#keuangan"
                               @click.prevent="activeSection = 'keuangan'; document.getElementById('keuangan').scrollIntoView({behavior: 'smooth'})"
                               :class="activeSection === 'keuangan' ? 'bg-indigo-50 text-indigo-700 font-bold' : 'text-gray-600 hover:bg-gray-50'"
                               class="block px-3 py-2 rounded-md text-sm transition">
                                3. Keuangan & Tagihan
                            </a>
                            <a href="#transaksi"
                               @click.prevent="activeSection = 'transaksi'; document.getElementById('transaksi').scrollIntoView({behavior: 'smooth'})"
                               :class="activeSection === 'transaksi' ? 'bg-indigo-50 text-indigo-700 font-bold' : 'text-gray-600 hover:bg-gray-50'"
                               class="block px-3 py-2 rounded-md text-sm transition">
                                4. Riwayat Transaksi
                            </a>
                            <a href="#laporan"
                               @click.prevent="activeSection = 'laporan'; document.getElementById('laporan').scrollIntoView({behavior: 'smooth'})"
                               :class="activeSection === 'laporan' ? 'bg-indigo-50 text-indigo-700 font-bold' : 'text-gray-600 hover:bg-gray-50'"
                               class="block px-3 py-2 rounded-md text-sm transition">
                                5. Laporan
                            </a>
                        </nav>
                    </div>
                </div>

                {{-- MAIN CONTENT --}}
                <div class="w-full lg:w-3/4 space-y-8">

                    {{-- 1. Pendahuluan --}}
                    <div id="intro" class="bg-white shadow-sm rounded-lg p-8 scroll-mt-24">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="bg-indigo-100 p-2 rounded-lg">
                                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-800">1. Pendahuluan</h2>
                        </div>
                        <div class="prose max-w-none text-gray-600">
                            <p>
                                Selamat datang di <strong>Panel Admin Cabang LG Learning</strong>.
                            </p>
                            <p class="mt-2">
                                Sebagai Admin Cabang, Anda memiliki akses untuk mengelola data siswa, memantau pembayaran, dan melihat laporan khusus untuk cabang Anda (<strong>{{ $branch->name }}</strong>).
                            </p>
                        </div>
                    </div>

                    {{-- 2. Manajemen Siswa --}}
                    <div id="siswa" class="bg-white shadow-sm rounded-lg p-8 scroll-mt-24">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="bg-blue-100 p-2 rounded-lg">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-800">2. Manajemen Siswa</h2>
                        </div>
                        <div class="space-y-6">
                            <div>
                                <h3 class="font-bold text-lg text-gray-900 mb-2">Monitoring & Filter Data</h3>
                                <p class="text-gray-600 text-sm mb-4">
                                    Untuk memudahkan pengelolaan kelas, gunakan fitur berikut pada halaman <strong>Data Siswa</strong> atau <strong>Detail Kelas</strong>:
                                </p>
                                
                                <div class="space-y-4">
                                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                        <h4 class="font-bold text-gray-800 text-sm mb-2">1. Filter Status Siswa</h4>
                                        <ul class="list-disc pl-5 text-xs text-gray-600 space-y-1">
                                            <li><strong>Active (Aktif):</strong> Siswa yang sedang belajar.</li>
                                            <li><strong>Pending:</strong> Siswa baru belum bayar pertama.</li>
                                            <li><strong>Inactive (Non-Aktif):</strong> Siswa cuti/berhenti.</li>
                                            <li><strong>Finished (Selesai):</strong> Siswa lulus.</li>
                                        </ul>
                                    </div>

                                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                        <h4 class="font-bold text-gray-800 text-sm mb-2">2. Monitoring Tabungan</h4>
                                        <ul class="list-disc pl-5 text-xs text-gray-600 space-y-1">
                                            <li>Lihat saldo tabungan langsung di tabel siswa.</li>
                                            <li>Lihat <strong>Total Tabungan Kelas</strong> di bagian atas detail kelas.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                             <div>
                                <h3 class="font-bold text-lg text-gray-900 mb-2">Portal Siswa</h3>
                                <p class="text-gray-600 text-sm">
                                    Setiap siswa memiliki <strong>Portal Siswa</strong> (Magic Link). Link ini dikirim via WhatsApp saat pendaftaran. Wali murid membayar tagihan melalui link tersebut.
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- 3. Keuangan --}}
                    <div id="keuangan" class="bg-white shadow-sm rounded-lg p-8 scroll-mt-24">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="bg-green-100 p-2 rounded-lg">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-800">3. Keuangan & Tagihan</h2>
                        </div>
                        <div class="space-y-6">
                            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-4">
                                <p class="text-yellow-700 text-sm font-bold">
                                    💡 Fitur Penting: Tagihan Berulang Otomatis (Auto-Recurring Billing)
                                </p>
                                <p class="text-yellow-600 text-sm mt-1">
                                    Setiap malam, sistem pusat akan mengecek siswa yang masa aktifnya habis. Sistem secara otomatis membuat tagihan baru dan mengirim notifikasi WhatsApp ke orang tua.
                                </p>
                            </div>

                            <div>
                                <h3 class="font-bold text-lg text-gray-900 mb-2">Pelunasan Manual (Tunai/Transfer Langsung)</h3>
                                <p class="text-gray-600 text-sm mb-2">
                                    Jika orang tua membayar secara tunai (cash) di cabang, Admin Cabang wajib mencatat pelunasan ini agar status siswa aktif.
                                </p>
                                <ol class="list-decimal pl-5 text-sm text-gray-600 space-y-1">
                                    <li>Buka <strong>Data Siswa > Detail Siswa</strong>.</li>
                                    <li>Scroll ke bagian <strong>Daftar Tagihan (Invoice)</strong>.</li>
                                    <li>Cari invoice yang statusnya <code>PENDING</code>.</li>
                                    <li>Klik tombol <strong>Bayar Manual / Tunai</strong>.</li>
                                    <li>Sistem akan menandai lunas dan memperbarui tanggal pembayaran.</li>
                                </ol>
                            </div>

                            <div class="border-t border-gray-100 pt-6 mt-6">
                                <h3 class="font-bold text-lg text-gray-900 mb-4 bg-indigo-50 p-2 inline-block rounded">📚 Skenario & Studi Kasus Keuangan</h3>
                                
                                <div class="space-y-4">
                                    {{-- Skenario 1 --}}
                                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                        <h4 class="font-bold text-indigo-700 text-sm mb-1">Kasus 1: Siswa Baru Mendaftar</h4>
                                        <p class="text-xs text-gray-600">
                                            <strong>Alur:</strong> Admin Cabang input data -> Pilih Paket -> Simpan. <br>
                                            <strong>Hasil:</strong> Siswa status <code>Inactive</code>. Invoice status <code>PENDING</code>. WA terkirim. <br>
                                            <strong>Tindakan:</strong> Tunggu orang tua membayar. Jika bayar tunai, gunakan fitur "Bayar Manual".
                                        </p>
                                    </div>

                                    {{-- Skenario 3 --}}
                                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                        <h4 class="font-bold text-indigo-700 text-sm mb-1">Kasus 2: Orang Tua Salah Bayar / Batal</h4>
                                        <p class="text-xs text-gray-600">
                                            <strong>Masalah:</strong> Invoice sudah terbit tapi anak berhenti les. <br>
                                            <strong>Tindakan:</strong> Hubungi Admin Pusat untuk menonaktifkan siswa atau abaikan invoice hingga expired.
                                        </p>
                                    </div>

                                    {{-- Skenario 6 --}}
                                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                        <h4 class="font-bold text-indigo-700 text-sm mb-1">Kasus 3: Siswa Lama (Migrasi Data)</h4>
                                        <p class="text-xs text-gray-600">
                                            <strong>Kondisi:</strong> Siswa migrasi dari sistem lama.<br>
                                            <strong>Tindakan:</strong> Jika status belum sesuai, hubungi Admin Pusat untuk penyesuaian data.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- 4. Transaksi --}}
                    <div id="transaksi" class="bg-white shadow-sm rounded-lg p-8 scroll-mt-24">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="bg-purple-100 p-2 rounded-lg">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-800">4. Riwayat Transaksi</h2>
                        </div>
                        <div class="prose max-w-none text-gray-600 text-sm">
                            <p>
                                Menu <strong>Riwayat Transaksi</strong> menampilkan semua pembayaran yang masuk ke cabang Anda.
                            </p>
                            <ul>
                                <li>Semua pembayaran via Xendit akan otomatis tercatat 'PAID'.</li>
                                <li>Jika ada orang tua yang membayar TUNAI ke Admin Cabang, harap lapor ke Admin Pusat agar dicatat, atau gunakan fitur pelunasan manual jika diberikan akses.</li>
                            </ul>
                        </div>
                    </div>

                    {{-- 4. Laporan --}}
                    <div id="laporan" class="bg-white shadow-sm rounded-lg p-8 scroll-mt-24">
                         <div class="flex items-center gap-3 mb-4">
                            <div class="bg-teal-100 p-2 rounded-lg">
                                <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-800">5. Laporan</h2>
                        </div>
                        <div class="space-y-4 text-sm text-gray-600">
                            <p>
                                Anda memiliki akses ke dua jenis laporan:
                            </p>
                            <ul class="list-disc pl-5 space-y-1">
                                <li><strong>Laporan Pemasukan:</strong> Ringkasan uang masuk per periode.</li>
                                <li><strong>Laporan Siswa:</strong> Data status siswa (Aktif, Baru, Berhenti).</li>
                            </ul>
                            <p>Gunakan filter tanggal untuk melihat laporan bulanan/mingguan.</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
