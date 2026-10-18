<!DOCTYPE html>
<html lang="id"></html>
<head><meta charset="UTF-8"><title>Satuan</title></head>
<body>
<h1>Data Satuan</h1>
<table border="1" cellpadding="6">
<tr><th>ID</th><th>Nama Satuan</th><th>Status</th></tr>
@foreach ($satuan as $row)
<tr></tr>
    <td>{{ $row->idsatuan }}</td>
    <td>{{ $row->nama_satuan }}</td>
    <td>{{ $row->status }}</td>
</tr>
@endforeach
</table>
</body>
</html>