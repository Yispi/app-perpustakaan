<!DOCTYPE html>
<html>
<head>
    <title>Tambah Anggota</title>
</head>
<body>

<h1>Tambah Anggota</h1>

@if ($errors->any())
    <div>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('members.store') }}" method="POST">
    @csrf

    <div>
        <label>Nama</label>
        <input
            type="text"
            name="nama"
            value="{{ old('nama') }}"
        >
    </div>

    <div>
        <label>NIM</label>
        <input
            type="text"
            name="nim"
            value="{{ old('nim') }}"
        >
    </div>

    <div>
        <label>Email</label>
        <input
            type="email"
            name="email"
            value="{{ old('email') }}"
        >
    </div>

    <div>
        <label>Nomor Telepon</label>
        <input
            type="text"
            name="nomor_telepon"
            value="{{ old('nomor_telepon') }}"
        >
    </div>

    <div>
        <label>Alamat</label>
        <textarea name="alamat">{{ old('alamat') }}</textarea>
    </div>

    <div>
        <label>Status</label>
        <select name="status">
            <option value="">-- Pilih Status --</option>
            <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>
                Aktif
            </option>
            <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>
                Nonaktif
            </option>
        </select>
    </div>

    <button type="submit">Simpan</button>

    <a href="{{ route('members.index') }}">Kembali</a>
</form>

</body>
</html>