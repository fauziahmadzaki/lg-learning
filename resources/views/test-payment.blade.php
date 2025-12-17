<form action="{{ route('transactions.store') }}" method="POST">
    @csrf
    <h1>Test Transaksi Xendit</h1>
    @if(session('error'))
    <div style="background: red; color: white; padding: 10px; margin-bottom: 10px;">
        <strong>Error:</strong> {{ session('error') }}
    </div>
    @endif

    @if($errors->any())
    <div style="background: orange; padding: 10px; margin-bottom: 10px;">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <p>Siswa: {{ $student->name }}</p>
    <p>Paket: {{ $package->name }} (Rp {{ number_format($package->price) }})</p>

    <input type="hidden" name="student_id" value="{{ $student->id }}">
    <input type="hidden" name="package_id" value="{{ $package->id }}">

    <button type="submit" style="background: blue; color: white; padding: 10px;">
        BAYAR SEKARANG (Checkout)
    </button>
</form>