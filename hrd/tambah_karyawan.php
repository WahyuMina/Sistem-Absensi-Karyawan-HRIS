<?php
session_start();
require '../config/koneksi.php';
if ($_SESSION['role'] !== 'hrd') { header("Location: ../login.php"); exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nip = $_POST['nip'];
    $name = $_POST['name'];
    $jabatan = $_POST['jabatan'];
    $password = hash('sha256', $_POST['password']);
    $role = $_POST['role'];

    $stmt = $pdo->prepare("INSERT INTO users (nip, name, jabatan, password_hash, role) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$nip, $name, $jabatan, $password, $role]);

    echo "<script>alert('Karyawan berhasil ditambahkan!');window.location='dashboard.php';</script>";
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Tambah Karyawan</title>
</head>

<body>
    <h2>Tambah Karyawan Baru</h2>
    <form method="post">
        <label>NIP:</label><br>
        <input type="text" name="nip" required><br><br>

        <label>Nama:</label><br>
        <input type="text" name="name" required><br><br>

        <label>Jabatan:</label><br>
        <input type="text" name="jabatan" required><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>

        <label>Role:</label><br>
        <select name="role">
            <option value="karyawan">Karyawan</option>
            <option value="hrd">HRD</option>
            <option value="atasan">Atasan</option>
        </select><br><br>

        <button type="submit">Simpan</button>
    </form>

    <br><a href="dashboard.php">Kembali</a>
</body>

</html>