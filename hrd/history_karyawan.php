<?php
session_start();
require '../config/koneksi.php';
if ($_SESSION['role'] !== 'hrd') { header("Location: ../login.php"); exit; }

$stmt = $pdo->query("SELECT a.*, u.name, u.jabatan 
                     FROM attendance a 
                     JOIN users u ON a.user_id = u.id 
                     ORDER BY a.check_time DESC");
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>

<head>
    <title>History Karyawan - HRD</title>
</head>

<body>
    <h2>History Absensi Karyawan</h2>
    <table border="1" cellpadding="5">
        <tr>
            <th>Nama</th>
            <th>Jabatan</th>
            <th>Jenis Absen</th>
            <th>Tanggal</th>
            <th>GPS Valid</th>
            <th>Status HRD</th>
            <th>Status Atasan</th>
        </tr>

        <?php foreach($data as $a): ?>
        <tr>
            <td><?= htmlspecialchars($a['name']) ?></td>
            <td><?= htmlspecialchars($a['jabatan']) ?></td>
            <td><?= ucfirst($a['type']) ?></td>
            <td><?= $a['check_time'] ?></td>
            <td><?= $a['gps_valid'] ? '✅' : '❌' ?></td>
            <td><?= $a['verified_by_hrd'] ? '✔️ Diverifikasi' : 'Belum' ?></td>
            <td><?= $a['approved_by_atasan'] ? '✔️ Disetujui' : 'Belum' ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

    <br><a href="dashboard.php">Kembali ke Dashboard</a>
</body>

</html>