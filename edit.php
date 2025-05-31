<?php
include 'koneksi.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: index.php");
    exit;
}

$data = $conn->query("SELECT * FROM barang WHERE id = $id")->fetch_assoc();
if (!$data) {
    header("Location: index.php");
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama_barang'];
    $kategori = $_POST['kategori'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];

    if ($nama && $kategori && $harga !== '' && $stok !== '') {
        $stmt = $conn->prepare("UPDATE barang SET nama_barang=?, kategori=?, harga=?, stok=? WHERE id=?");
        $stmt->bind_param("ssiii", $nama, $kategori, $harga, $stok, $id);
        $stmt->execute();
        header("Location: index.php");
        exit;
    } else {
        $error = "Semua kolom wajib diisi!";
    }
}

$kategori_list = [
    "Elektronik",
    "Pakaian",
    "Makanan & Minuman",
    "Peralatan Rumah Tangga",
    "Buku",
    "Aksesoris"
];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Barang</title>
    <link href="style.css" rel="stylesheet">
</head>
<body class="p-4">
<div class="container">
    <h2>Edit Barang</h2>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="post">
        <input type="text" name="nama_barang" class="form-control mb-2" placeholder="Nama Barang" value="<?= htmlspecialchars($_POST['nama_barang'] ?? $data['nama_barang']) ?>">

        <select name="kategori" class="form-control mb-2" required>
            <option value="">-- Pilih Kategori --</option>
            <?php
            $selectedKategori = $_POST['kategori'] ?? $data['kategori'];
            foreach ($kategori_list as $kat): ?>
                <option value="<?= $kat ?>" <?= ($selectedKategori === $kat) ? 'selected' : '' ?>>
                    <?= $kat ?>
                </option>
            <?php endforeach; ?>
        </select>

        <input type="number" name="harga" class="form-control mb-2" placeholder="Harga" value="<?= htmlspecialchars($_POST['harga'] ?? $data['harga']) ?>" min="0" step="1000">
        <input type="number" name="stok" class="form-control mb-2" placeholder="Stok" value="<?= htmlspecialchars($_POST['stok'] ?? $data['stok']) ?>" min="0" step="1">

        <button type="submit" class="btn btn-warning">Update</button>
        <a href="index.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>
</body>
</html>
