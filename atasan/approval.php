<?php
session_start();
require '../config/koneksi.php';
if ($_SESSION['role'] !== 'atasan') { header("Location: ../login.php"); exit; }

$id = intval($_POST['id']);

$stmt = $pdo->prepare("UPDATE attendance 
                       SET approved_by_atasan = 1, 
                           atasan_id = :uid, 
                           atasan_approved_at = NOW() 
                       WHERE id = :id");
$stmt->execute([
  ':uid' => $_SESSION['user_id'],
  ':id' => $id
]);

echo "<script>alert('Absensi telah disetujui!');window.location='dashboard.php';</script>";
?>