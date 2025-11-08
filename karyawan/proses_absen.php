<?php
session_start();
require '../config/koneksi.php';

$user_id = $_SESSION['user_id'];
$type = $_POST['type'];
$gps_lat = $_POST['gps_lat'];
$gps_lon = $_POST['gps_lon'];

$photoDir = "../uploads/attendance/";
if (!is_dir($photoDir)) mkdir($photoDir, 0777, true);
$photoName = time() . "_" . $user_id . ".jpg";
move_uploaded_file($_FILES['photo']['tmp_name'], $photoDir . $photoName);

$doc_path = null;
if (!empty($_FILES['doc']['name'])) {
    $docDir = "../uploads/documents/";
    if (!is_dir($docDir)) mkdir($docDir, 0777, true);
    $docName = time() . "_" . $_FILES['doc']['name'];
    move_uploaded_file($_FILES['doc']['tmp_name'], $docDir . $docName);
    $doc_path = "uploads/documents/" . $docName;
}

// Cek apakah user sudah absen dengan tipe yang sama hari ini
$cek = $pdo->prepare("SELECT COUNT(*) FROM attendance 
                      WHERE user_id=? AND type=? 
                      AND DATE(check_time)=CURDATE()");
$cek->execute([$user_id, $type]);
if ($cek->fetchColumn() > 0) {
    echo "<script>alert('Anda sudah melakukan absen $type hari ini!');window.location='dashboard.php';</script>";
    exit;
}


// Ambil lokasi klinik
$stmt = $pdo->query("SELECT latitude, longitude, radius_m FROM clinic_office LIMIT 1");
$office = $stmt->fetch(PDO::FETCH_ASSOC);

function haversine($lat1,$lon1,$lat2,$lon2){
  $earth=6371000;
  $dLat=deg2rad($lat2-$lat1);
  $dLon=deg2rad($lon2-$lon1);
  $a=sin($dLat/2)*sin($dLat/2)+cos(deg2rad($lat1))*cos(deg2rad($lat2))*sin($dLon/2)*sin($dLon/2);
  $c=2*atan2(sqrt($a), sqrt(1-$a));
  return $earth*$c;
}
$distance = haversine($gps_lat, $gps_lon, $office['latitude'], $office['longitude']);
$gps_valid = ($distance <= $office['radius_m']) ? 1 : 0;

$stmt = $pdo->prepare("INSERT INTO attendance (user_id, type, gps_lat, gps_lon, photo_path, doc_path, gps_valid) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->execute([$user_id, $type, $gps_lat, $gps_lon, "uploads/attendance/".$photoName, $doc_path, $gps_valid]);

echo "<script>alert('Absensi berhasil dikirim!');window.location='dashboard.php';</script>";
?>