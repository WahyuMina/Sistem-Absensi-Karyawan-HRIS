<?php
session_start();
if ($_SESSION['role'] !== 'karyawan') { header("Location: ../login.php"); exit; }
?>
<!DOCTYPE html>
<html>

<head>
    <title>Absen Klinik</title>
</head>

<body>
    <h2>Form Absensi Klinik</h2>

    <form id="formAbsen" enctype="multipart/form-data" method="post" action="proses_absen.php">
        <label>Jenis Absen:</label><br>
        <select name="type" required>
            <option value="masuk">Masuk</option>
            <option value="izin">Izin</option>
            <option value="keluar">Keluar</option>
        </select><br><br>

        <label>Upload Foto Selfie:</label><br>
        <input type="file" name="photo" accept="image/*" capture="camera" required><br><br>

        <label>Upload Dokumen Izin (opsional):</label><br>
        <input type="file" name="doc" accept=".jpg,.png,.pdf"><br><br>

        <input type="hidden" name="gps_lat" id="gps_lat">
        <input type="hidden" name="gps_lon" id="gps_lon">

        <button type="submit">Kirim Absen</button>
    </form>

    <script>
    // Ambil GPS otomatis
    navigator.geolocation.getCurrentPosition(pos => {
        document.getElementById('gps_lat').value = pos.coords.latitude;
        document.getElementById('gps_lon').value = pos.coords.longitude;
    }, err => {
        alert('Aktifkan lokasi GPS Anda.');
    });
    </script>
</body>

</html>