<!DOCTYPE html>
<html>
<head>
    <title>Detail Anggota</title>
</head>
<body>

<h1>Detail Anggota</h1>

<table border="1">
    <tr>
        <th>Nama</th>
        <td>{{ $member->nama }}</td>
    </tr>

    <tr>
        <th>NIM</th>
        <td>{{ $member->nim }}</td>
    </tr>

    <tr>
        <th>Email</th>
        <td>{{ $member->email }}</td>
    </tr>

    <tr>
        <th>Nomor Telepon</th>
        <td>{{ $member->nomor_telepon }}</td>
    </tr>

    <tr>
        <th>Alamat</th>
        <td>{{ $member->alamat }}</td>
    </tr>

    <tr>
        <th>Status</th>
        <td>{{ $member->status }}</td>
    </tr>
</table>

<br>

<a href="{{ route('members.index') }}">Kembali</a>

<a href="{{ route('members.edit', $member->id) }}">Edit</a>

<form
    action="{{ route('members.destroy', $member->id) }}"
    method="POST"
    style="display:inline"
>
    @csrf
    @method('DELETE')

    <button type="submit"
        onclick="return confirm('Yakin ingin menghapus anggota ini?')">
        Hapus
    </button>
</form>

</body>
</html>