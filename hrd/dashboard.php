<?php
session_start();
require '../config/koneksi.php';
if ($_SESSION['role'] !== 'hrd') { header("Location: ../login.php"); exit; }

$stmt = $pdo->query("SELECT a.*, u.name, u.jabatan 
                     FROM attendance a 
                     JOIN users u ON a.user_id = u.id 
                     ORDER BY a.check_time DESC");
$absensi = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>

<head>
    <title>Dashboard HRD - Klinik</title>
</head>

<body>
    <h2>Dashboard HRD - Verifikasi Absensi</h2>
    <table border="1" cellpadding="5">
        <tr>
            <th>Nama</th>
            <th>Jabatan</th>
            <th>Jenis Absen</th>
            <th>Tanggal</th>
            <th>Foto</th>
            <th>Lokasi</th>
            <th>Valid GPS</th>
            <th>Aksi</th>
        </tr>

        <?php foreach($absensi as $a): ?>
        <tr>
            <td><?= htmlspecialchars($a['name']) ?></td>
            <td><?= htmlspecialchars($a['jabatan']) ?></td>
            <td><?= ucfirst($a['type']) ?></td>
            <td><?= $a['check_time'] ?></td>
            <td><img src="../<?= $a['photo_path'] ?>" width="80"></td>
            <td><?= $a['gps_lat'] ?>, <?= $a['gps_lon'] ?></td>
            <td><?= $a['gps_valid'] ? '✅ Dalam Klinik' : '❌ Luar Area' ?></td>
            <td>
                <?php if (!$a['verified_by_hrd']): ?>
                <form method="post" action="verifikasi.php" style="display:inline;">
                    <input type="hidden" name="id" value="<?= $a['id'] ?>">
                    <input type="hidden" name="decision" value="accept">
                    <button type="submit">Terima</button>
                </form>
                <form method="post" action="verifikasi.php" style="display:inline;">
                    <input type="hidden" name="id" value="<?= $a['id'] ?>">
                    <input type="hidden" name="decision" value="reject">
                    <button type="submit">Tolak</button>
                </form>
                <?php else: ?>
                ✅ Diverifikasi
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <br><a href="../logout.php">Logout</a>
</body>

</html>