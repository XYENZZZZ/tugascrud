<?php include 'koneksi.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Barang</title>
    <link href="style.css" rel="stylesheet">

</head>
<body class="p-4">

<div class="container">
    <h2 class="mb-4">Daftar Barang</h2>

    <form method="GET" class="mb-3">
        <input type="text" name="cari" class="form-control" placeholder="Cari nama atau kategori..." value="<?= $_GET['cari'] ?? '' ?>">
    </form>

    <a href="tambah.php" class="btn btn-primary mb-3">+ Tambah Barang</a>

    <table class="table table-bordered">
        <tr>
            <th>Nama Barang</th><th>Kategori</th><th>Harga</th><th>Stok</th><th>Aksi</th>
        </tr>
        <?php
        $cari = $_GET['cari'] ?? '';
        $query = "SELECT * FROM barang WHERE nama_barang LIKE '%$cari%' OR kategori LIKE '%$cari%'";
        $result = $conn->query($query);

        while ($barang = $result->fetch_assoc()):
        ?>
        <tr>
            <td><?= $barang['nama_barang'] ?></td>
            <td><?= $barang['kategori'] ?></td>
            <td>Rp <?= number_format($barang['harga'], 0, ',', '.') ?></td>
            <td><?= $barang['stok'] ?></td>
            <td>
                <a href="edit.php?id=<?= $barang['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                <a href="hapus.php?id=<?= $barang['id'] ?>" onclick="return confirm('Hapus barang ini?')" class="btn btn-danger btn-sm">Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>
</body>
</html>
