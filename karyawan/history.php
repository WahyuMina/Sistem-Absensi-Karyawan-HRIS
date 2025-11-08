<?php
session_start();
require '../config/koneksi.php';
if ($_SESSION['role'] !== 'karyawan') { header("Location: ../login.php"); exit; }

$stmt = $pdo->prepare("SELECT * FROM attendance WHERE user_id = ? ORDER BY check_time DESC");
$stmt->execute([$_SESSION['user_id']]);
$absensi = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>

<head>
    <title>History Absensi</title>
</head>

<body>
    <h2>Riwayat Absensi <?php echo $_SESSION['name']; ?></h2>
    <table border="1" cellpadding="5">
        <tr>
            <th>Tanggal</th>
            <th>Jenis</th>
            <th>GPS Valid</th>
            <th>Foto</th>
        </tr>
        <?php foreach($absensi as $a): ?>
        <tr>
            <td><?= $a['check_time'] ?></td>
            <td><?= ucfirst($a['type']) ?></td>
            <td><?= $a['gps_valid'] ? '✅ Dalam Klinik' : '❌ Luar Area' ?></td>
            <td><img src="../<?= $a['photo_path'] ?>" width="80"></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <br><a href="dashboard.php">Kembali</a>
</body>

</html>