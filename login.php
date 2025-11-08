<?php
session_start();
require 'config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nip = $_POST['nip'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE nip = ?");
    $stmt->execute([$nip]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && hash('sha256', $password) === $user['password_hash']) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['role'] = $user['role'];

        if ($user['role'] == 'karyawan') {
            header('Location: karyawan/dashboard.php');
        } elseif ($user['role'] == 'hrd') {
            header('Location: hrd/dashboard.php');
        } elseif ($user['role'] == 'atasan') {
            header('Location: atasan/dashboard.php');
        }
        exit;
    } else {
        echo "<script>alert('NIP atau password salah!');history.back();</script>";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Login - HRIS Klinik</title>
</head>

<body>
    <h2>Login Sistem Absensi Klinik</h2>
    <form method="post">
        <label>NIP:</label><br>
        <input type="text" name="nip" required><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>

        <button type="submit">Masuk</button>
    </form>
</body>

</html>