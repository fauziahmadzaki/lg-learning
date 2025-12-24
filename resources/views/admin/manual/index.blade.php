<x-app-layout>
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
                            <a href="#tagihan"
                               @click.prevent="activeSection = 'tagihan'; document.getElementById('tagihan').scrollIntoView({behavior: 'smooth'})"
                               :class="activeSection === 'tagihan' ? 'bg-indigo-50 text-indigo-700 font-bold' : 'text-gray-600 hover:bg-gray-50'"
                               class="block px-3 py-2 rounded-md text-sm transition">
                                3. Keuangan & Tagihan
                            </a>
                            <a href="#transaksi"
                               @click.prevent="activeSection = 'transaksi'; document.getElementById('transaksi').scrollIntoView({behavior: 'smooth'})"
                               :class="activeSection === 'transaksi' ? 'bg-indigo-50 text-indigo-700 font-bold' : 'text-gray-600 hover:bg-gray-50'"
                               class="block px-3 py-2 rounded-md text-sm transition">
                                4. Pembayaran (Xendit)
                            </a>
                            <a href="#tabungan"
                               @click.prevent="activeSection = 'tabungan'; document.getElementById('tabungan').scrollIntoView({behavior: 'smooth'})"
                               :class="activeSection === 'tabungan' ? 'bg-indigo-50 text-indigo-700 font-bold' : 'text-gray-600 hover:bg-gray-50'"
                               class="block px-3 py-2 rounded-md text-sm transition">
                                5. Tabungan Siswa
                            </a>
                            <a href="#laporan"
                               @click.prevent="activeSection = 'laporan'; document.getElementById('laporan').scrollIntoView({behavior: 'smooth'})"
                               :class="activeSection === 'laporan' ? 'bg-indigo-50 text-indigo-700 font-bold' : 'text-gray-600 hover:bg-gray-50'"
                               class="block px-3 py-2 rounded-md text-sm transition">
                                6. Laporan & Log Aktivitas
                            </a>
                             <a href="#website"
                               @click.prevent="activeSection = 'website'; document.getElementById('website').scrollIntoView({behavior: 'smooth'})"
                               :class="activeSection === 'website' ? 'bg-indigo-50 text-indigo-700 font-bold' : 'text-gray-600 hover:bg-gray-50'"
                               class="block px-3 py-2 rounded-md text-sm transition">
                                7. Pengaturan Website
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
                                Selamat datang di <strong>Sistem Administrasi LG Learning</strong>. Sistem ini dirancang untuk memudahkan pengelolaan data siswa, tagihan SPP, pembayaran online, dan laporan keuangan secara terintegrasi antar cabang.
                            </p>
                            <p class="mt-2">
                                Dokumen ini berisi panduan lengkap penggunaan fitur-fitur yang tersedia di Admin Panel.
                            </p>
                            <ul class="list-disc pl-5 mt-2 space-y-1">
                                <li><strong>Admin Pusat:</strong> Memiliki akses penuh ke semua cabang dan pengaturan global.</li>
                                <li><strong>Admin Cabang:</strong> Memiliki akses khusus untuk mengelola data siswa dan transaksi di cabangnya sendiri.</li>
                            </ul>
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
                                <h3 class="font-bold text-lg text-gray-900 mb-2">Pendaftaran Siswa Baru</h3>
                                <p class="text-gray-600 mb-2">
                                    Menu <strong>Data Siswa > Tambah Siswa</strong> digunakan untuk mendaftarkan siswa secara manual (offline).
                                </p>
                                <ul class="list-disc pl-5 text-sm text-gray-600 space-y-1">
                                    <li>Isi data diri lengkap (Nama, Email, No HP Orang Tua).</li>
                                    <li>Pilih <strong>Paket Belajar</strong>. Cabang akan otomatis terisi mengikuti cabang dari paket yang dipilih.</li>
                                    <li>Pilih <strong>Siklus Tagihan</strong> (Mingguan, Bulanan, atau Lunas).</li>
                                    <li>Setelah disimpan, sistem akan otomatis membuat <strong>Tagihan Pertama</strong> dan mengirim pesan WhatsApp Welcome Message ke orang tua.</li>
                                </ul>
                            </div>
                             <div>
                                <h3 class="font-bold text-lg text-gray-900 mb-2">Portal Siswa & Magic Link</h3>
                                <p class="text-gray-600 text-sm">
                                    Setiap siswa memiliki <strong>Portal Siswa</strong> pribadi yang bisa diakses tanpa password (menggunakan Magic Link).
                                    Link ini dikirim via WhatsApp saat pendaftaran. Di portal ini, siswa dapat:
                                </p>
                                <ul class="list-disc pl-5 mt-1 text-sm text-gray-600">
                                    <li>Melihat status keaktifan paket.</li>
                                    <li>Melihat riwayat pembayaran dan tagihan pending.</li>
                                    <li>Melakukan pembayaran online (Xendit).</li>
                                </ul>
                            </div>
                            
                            <div>
                                <h3 class="font-bold text-lg text-gray-900 mb-2">Monitoring & Filter Data</h3>
                                <p class="text-gray-600 text-sm mb-4">
                                    Untuk memudahkan pengelolaan kelas yang memiliki banyak siswa, sistem menyediakan fitur filtering dan monitoring yang lebih detail.
                                </p>
                                
                                <div class="space-y-4">
                                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                        <h4 class="font-bold text-gray-800 text-sm mb-2">1. Filter Status Siswa</h4>
                                        <p class="text-xs text-gray-600 mb-2">
                                            Pada halaman daftar siswa, terdapat dropdown status di pojok kanan atas. Secara default sistem menampilkan <strong>Semua Status</strong>. Anda dapat menyaring berdasarkan:
                                        </p>
                                        <ul class="list-disc pl-5 text-xs text-gray-600 space-y-1">
                                            <li><strong>Active (Aktif):</strong> Siswa yang sedang belajar dan tagihannya lancar.</li>
                                            <li><strong>Pending:</strong> Siswa baru yang belum membayar tagihan pertama (Calon Siswa).</li>
                                            <li><strong>Inactive (Non-Aktif):</strong> Siswa yang sedang cuti atau berhenti sementara (tagihan tidak berjalan).</li>
                                            <li><strong>Finished (Selesai):</strong> Siswa yang sudah lulus atau menyelesaikan paket belajarnya.</li>
                                        </ul>
                                    </div>

                                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                        <h4 class="font-bold text-gray-800 text-sm mb-2">2. Monitoring Tabungan per Kelas</h4>
                                        <p class="text-xs text-gray-600 mb-2">
                                            Pada menu <strong>Detail Kelas (Courses)</strong> atau <strong>Detail Paket</strong>, Anda dapat melihat ringkasan keuangan tabungan:
                                        </p>
                                        <ul class="list-disc pl-5 text-xs text-gray-600 space-y-1">
                                            <li><strong>Kolom Saldo:</strong> Tabel siswa kini menampilkan saldo tabungan terkini masing-masing anak.</li>
                                            <li><strong>Total Tabungan Kelas:</strong> Di bagian atas daftar siswa, terdapat angka akumulasi total uang tabungan milik seluruh siswa di kelas tersebut. Angka ini akan berubah sesuai filter status yang Anda pilih (misal: hanya menghitung tabungan siswa Aktif).</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- 3. Keuangan --}}
                    <div id="tagihan" class="bg-white shadow-sm rounded-lg p-8 scroll-mt-24">
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
                                    Setiap malam, sistem akan mengecek siswa yang masa aktifnya habis. Sistem secara otomatis membuat tagihan baru (Invoice Baru) dan mengirim notifikasi WhatsApp ke orang tua agar segera membayar untuk perpanjangan.
                                </p>
                            </div>

                            <div>
                                <h3 class="font-bold text-lg text-gray-900 mb-2">Buat Tagihan Manual</h3>
                                <p class="text-gray-600 text-sm">
                                    Jika Anda perlu membuat tagihan di luar jadwal otomatis, buka profil siswa, lalu klik tab <strong>Tagihan & Pembayaran</strong>.
                                    Klik tombol <span class="bg-gray-200 px-1 rounded text-xs font-mono">Buat Tagihan Berikutnya</span>.
                                </p>
                            </div>

                            <div>
                                <h3 class="font-bold text-lg text-gray-900 mb-2">Pelunasan Manual (Tunai/Transfer Langsung)</h3>
                                <p class="text-gray-600 text-sm mb-2">
                                    Jika orang tua membayar secara tunai (cash) di lokasi atau transfer manual ke rekening pribadi owner (bukan lewat Virtual Account otomatis), Admin wajib mencatat pelunasan ini agar status siswa aktif.
                                </p>
                                <ol class="list-decimal pl-5 text-sm text-gray-600 space-y-1">
                                    <li>Buka <strong>Data Siswa > Detail Siswa</strong>.</li>
                                    <li>Scroll ke bagian <strong>Daftar Tagihan (Invoice)</strong>.</li>
                                    <li>Cari invoice yang statusnya <code>PENDING</code>.</li>
                                    <li>Klik tombol <strong>Bayar Manual / Tunai</strong>.</li>
                                    <li>Sistem akan menandai lunas, memperbarui tanggal pembayaran, dan memperpanjang masa aktif siswa.</li>
                                </ol>
                            </div>

                            <div class="border-t border-gray-100 pt-6 mt-6">
                                <h3 class="font-bold text-lg text-gray-900 mb-4 bg-indigo-50 p-2 inline-block rounded">📚 Skenario & Studi Kasus Keuangan</h3>
                                
                                <div class="space-y-4">
                                    {{-- Skenario 1 --}}
                                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                        <h4 class="font-bold text-indigo-700 text-sm mb-1">Kasus 1: Siswa Baru Mendaftar</h4>
                                        <p class="text-xs text-gray-600">
                                            <strong>Alur:</strong> Admin input data -> Pilih Paket -> Simpan. <br>
                                            <strong>Hasil:</strong> Siswa status <code>Inactive</code>. Invoice status <code>PENDING</code>. WA terkirim. <br>
                                            <strong>Tindakan:</strong> Tunggu orang tua membayar via Link Xendit. Jika berhasil, status otomatis berubah jadi <code>Active</code>.
                                        </p>
                                    </div>

                                    {{-- Skenario 2 --}}
                                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                        <h4 class="font-bold text-indigo-700 text-sm mb-1">Kasus 2: Perpanjangan Paket (Otomatis)</h4>
                                        <p class="text-xs text-gray-600">
                                            <strong>Alur:</strong> Masa aktif siswa habis hari ini. <br>
                                            <strong>Hasil:</strong> Sistem mencetak Invoice baru jam 01:00 pagi. WA Tagihan terkirim. <br>
                                            <strong>Tindakan:</strong> Tidak perlu tindakan manual. Sistem menunggu pembayaran.
                                        </p>
                                    </div>

                                    {{-- Skenario 3 --}}
                                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                        <h4 class="font-bold text-indigo-700 text-sm mb-1">Kasus 3: Orang Tua Salah Bayar / Batal</h4>
                                        <p class="text-xs text-gray-600">
                                            <strong>Masalah:</strong> Invoice sudah terbit tapi anak berhenti les. <br>
                                            <strong>Tindakan:</strong> Admin menonaktifkan siswa di menu Edit Siswa (Status: Inactive/Off). Abaikan invoice pending, invoice akan kadaluarsa sendiri (Expired).
                                        </p>
                                    </div>
                                    
                                    {{-- Skenario 4 --}}
                                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                        <h4 class="font-bold text-indigo-700 text-sm mb-1">Kasus 4: Pindah Paket</h4>
                                        <p class="text-xs text-gray-600">
                                            <strong>Masalah:</strong> Siswa ingin ganti dari Paket Mingguan ke Bulanan. <br>
                                            <strong>Tindakan:</strong>
                                            1. Edit Siswa -> Pilih Paket Baru.<br>
                                            2. Jika tagihan lama masih pending, biarkan expired atau admin bisa membuat tagihan baru manual setelah edit paket.<br>
                                            3. Perubahan harga efektif di tagihan berikutnya.
                                        </p>
                                    </div>

                                    {{-- Skenario 5 --}}
                                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                        <h4 class="font-bold text-indigo-700 text-sm mb-1">Kasus 5: Siswa Mengambil Lebih dari 1 Paket</h4>
                                        <p class="text-xs text-gray-600">
                                            <strong>Masalah:</strong> Siswa ingin les Matematika (Paket A) DAN Bahasa Inggris (Paket B) secara bersamaan. <br>
                                            <strong>Solusi:</strong> Daftarkan siswa tersebut <strong>2 KALI</strong>. <br>
                                            1. Pendaftaran Pertama: Pilih Paket Matematika.<br>
                                            2. Pendaftaran Kedua: Isi data sama persis (Nama, Email, WA), tapi pilih Paket Bahasa Inggris.<br>
                                            <strong>Catatan:</strong> Siswa akan memiliki 2 akun portal berbeda dan menerima 2 link tagihan terpisah via WhatsApp.
                                        </p>
                                    </div>

                                    {{-- Skenario 6 --}}
                                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                        <h4 class="font-bold text-indigo-700 text-sm mb-1">Kasus 6: Siswa Lama (Migrasi Data)</h4>
                                        <p class="text-xs text-gray-600">
                                            <strong>Kondisi:</strong> Siswa dari sistem lama telah dipindahkan ke sistem ini.<br>
                                            <strong>Status:</strong>
                                            <ul class="list-disc pl-4 mt-1 mb-1">
                                                <li><code>Active</code>: Paket belum habis. Tagihan lanjut otomatis.</li>
                                                <li><code>Inactive</code>: Paket selesai/kadaluarsa.</li>
                                                <li><code>Pending</code>: Data butuh verifikasi.</li>
                                            </ul>
                                            <strong>Tindakan:</strong> Edit data siswa tersebut, lalu ubah status menjadi <strong>Active</strong>. Sistem akan melanjutkan perhitungan tagihan secara otomatis pada siklus berikutnya.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- 4. Pembayaran (Xendit) --}}
                    <div id="transaksi" class="bg-white shadow-sm rounded-lg p-8 scroll-mt-24">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="bg-purple-100 p-2 rounded-lg">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-800">4. Pembayaran Online (Xendit)</h2>
                        </div>
                        <div class="prose max-w-none text-gray-600 text-sm">
                            <p>
                                Sistem ini terintegrasi dengan Payment Gateway <strong>Xendit</strong>.
                            </p>
                            <ul>
                                <li><strong>Otomatisasi:</strong> Ketika siswa membayar via QRIS, Virtual Account, atau E-Wallet di halaman pembayaran, Xendit akan mengirim sinyal (Webhook) ke sistem.</li>
                                <li><strong>Real-time Update:</strong> Status tagihan di sistem akan berubah menjadi <code>PAID</code> secara otomatis dalam hitungan detik. Siswa langsung aktif tanpa perlu konfirmasi manual ke admin.</li>
                                <li><strong>Invoice Code:</strong> Setiap transaksi memiliki kode unik (contoh: <code>INV-176660123-REG</code>). Jangan ubah kode ini jika melakukan pencatatan manual.</li>
                            </ul>
                        </div>
                    </div>

                    {{-- 5. Tabungan --}}
                    <div id="tabungan" class="bg-white shadow-sm rounded-lg p-8 scroll-mt-24">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="bg-orange-100 p-2 rounded-lg">
                                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-800">5. Tabungan Siswa</h2>
                        </div>
                        <div class="space-y-4">
                            <p class="text-gray-600 text-sm">
                                Setiap siswa memiliki dompet digital sederhana (Tabungan) yang dikelola oleh Admin.
                                Fitur ini berguna untuk mencatat titipan uang jajan atau tabungan pendidikan.
                            </p>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="border rounded-lg p-4">
                                    <h4 class="font-bold text-green-700 mb-1">Setor Tunai (Deposit)</h4>
                                    <p class="text-xs text-gray-500">
                                        Admin menerima uang cash dari siswa, lalu menginput menu "Setor" di profil siswa. Saldo siswa bertambah.
                                    </p>
                                </div>
                                <div class="border rounded-lg p-4">
                                    <h4 class="font-bold text-red-700 mb-1">Tarik Tunai (Withdraw)</h4>
                                    <p class="text-xs text-gray-500">
                                        Admin memberikan uang cash ke siswa, lalu menginput menu "Tarik" di profil siswa. Saldo siswa berkurang.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- 6. Laporan --}}
                    <div id="laporan" class="bg-white shadow-sm rounded-lg p-8 scroll-mt-24">
                         <div class="flex items-center gap-3 mb-4">
                            <div class="bg-teal-100 p-2 rounded-lg">
                                <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-800">6. Laporan & Log</h2>
                        </div>
                        <div class="space-y-4 text-sm text-gray-600">
                            <div>
                                <h4 class="font-bold text-gray-900">Laporan Keuangan</h4>
                                <p>
                                    Menu <strong>Laporan Keuangan</strong> menampilkan seluruh riwayat transaksi (Pemasukan).
                                    Gunakan filter <strong>Tanggal</strong>, <strong>Cabang</strong>, dan <strong>Kategori</strong> untuk menyaring data.
                                    Anda juga bisa mengekspor data ke Excel.
                                </p>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900">Log Aktivitas Sistem</h4>
                                <p>
                                    Menu <strong>Log Aktivitas</strong> mencatat jejak digital setiap tindakan admin (Siapa melakukan apa, kapan, dan di data mana).
                                    Fitur ini penting untuk audit keamanan dan melacak kesalahan input data.
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    {{-- 7. Website Setting --}}
                     <div id="website" class="bg-white shadow-sm rounded-lg p-8 scroll-mt-24">
                         <div class="flex items-center gap-3 mb-4">
                            <div class="bg-gray-100 p-2 rounded-lg">
                                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-800">7. Pengaturan Website</h2>
                        </div>
                        <div class="space-y-4 text-sm text-gray-600">
                            <div>
                                <h4 class="font-bold text-gray-900">Konten Landing Page</h4>
                                <p>
                                    Anda dapat mengubah teks, gambar banner, dan konten landing page melalui menu <strong>Konten & Galeri</strong>.
                                    Pastikan gambar yang diupload memiliki resolusi yang baik agar tampilan website tetap profesional.
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
