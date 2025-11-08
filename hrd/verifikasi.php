<?php
session_start();
require '../config/koneksi.php';
if ($_SESSION['role'] !== 'hrd') { header("Location: ../login.php"); exit; }

$id = intval($_POST['id']);
$decision = $_POST['decision'] === 'accept' ? 1 : 0;

$stmt = $pdo->prepare("UPDATE attendance 
                       SET verified_by_hrd = :status, 
                           verified_hrd_by = :by_id, 
                           verified_hrd_at = NOW() 
                       WHERE id = :id");
$stmt->execute([
  ':status' => $decision,
  ':by_id' => $_SESSION['user_id'],
  ':id' => $id
]);

echo "<script>alert('Verifikasi berhasil!');window.location='dashboard.php';</script>";
?>