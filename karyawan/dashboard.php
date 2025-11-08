<?php
session_start();
if ($_SESSION['role'] !== 'karyawan') { header("Location: ../login.php"); exit; }
?>
<?php include '../includes/header.php';?>

<!DOCTYPE html>
<html>

<head>
    <title>Dashboard Karyawan</title>
</head>

<body>
    <h2>Selamat datang, <?php echo $_SESSION['name']; ?>!</h2>

    <ul>
        <li><a href="absen.php">Absen Masuk / Keluar</a></li>
        <li><a href="history.php">Lihat History Absensi</a></li>
        <li><a href="../logout.php">Log Out</a></li>
    </ul>

    <?php include '../includes/footer.php'; ?>
</body>

</html>