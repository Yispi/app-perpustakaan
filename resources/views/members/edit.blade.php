<!DOCTYPE html>
<html>
<head>
    <title>Edit Anggota</title>
</head>
<body>

<h1>Edit Anggota</h1>

@if ($errors->any())
    <div>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('members.update', $member->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div>
        <label>Nama</label>
        <input
            type="text"
            name="nama"
            value="{{ old('nama', $member->nama) }}"
        >
    </div>

    <div>
        <label>NIM</label>
        <input
            type="text"
            name="nim"
            value="{{ old('nim', $member->nim) }}"
        >
    </div>

    <div>
        <label>Email</label>
        <input
            type="email"
            name="email"
            value="{{ old('email', $member->email) }}"
        >
    </div>

    <div>
        <label>Nomor Telepon</label>
        <input
            type="text"
            name="nomor_telepon"
            value="{{ old('nomor_telepon', $member->nomor_telepon) }}"
        >
    </div>

    <div>
        <label>Alamat</label>
        <textarea name="alamat">{{ old('alamat', $member->alamat) }}</textarea>
    </div>

    <div>
        <label>Status</label>
        <select name="status">
            <option value="aktif"
                {{ old('status', $member->status) == 'aktif' ? 'selected' : '' }}>
                Aktif
            </option>

            <option value="nonaktif"
                {{ old('status', $member->status) == 'nonaktif' ? 'selected' : '' }}>
                Nonaktif
            </option>
        </select>
    </div>

    <button type="submit">Update</button>

    <a href="{{ route('members.index') }}">Kembali</a>
</form>

</body>
</html>