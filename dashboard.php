<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Paperless Office</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #333;
            color: white;
            padding: 10px 20px;
            text-align: center;
        }
        nav {
            display: flex;
            justify-content: center;
            background-color: #555;
            padding: 10px 0;
        }
        nav a {
            color: white;
            text-decoration: none;
            margin: 0 15px;
            padding: 8px 16px;
            border-radius: 5px;
        }
        nav a:hover {
            background-color: #333;
        }
        .container {
            padding: 20px;
            text-align: center;
        }
        .menu {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
        }
        .menu-item {
            background: #fff;
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 20px;
            width: 200px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }
        .menu-item a {
            text-decoration: none;
            color: #333;
            font-weight: bold;
        }
        .menu-item a:hover {
            color: #555;
        }
        .contact-section {
            margin-top: 40px;
            padding: 20px;
            background: #333;
            color: white;
            border-radius: 10px;
            text-align: center;
        }
        .contact-section h2 {
            margin-bottom: 10px;
        }
        .contact-section p {
            margin: 5px 0;
        }
        .contact-section a {
            color: #ffd700;
            text-decoration: none;
            font-weight: bold;
        }
        .contact-section a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <header>
        <h1>Dashboard - Paperless Office</h1>
        <p>Selamat datang, Nissa!</p>
    </header>
    <nav>
        <a href="dashboard.php">Home</a>
        <a href="patients.php">Data Pasien</a>
        <a href="doctors.php">Data Dokter</a>
        <a href="appointments.php">Jadwal Janji Temu</a>
        <a href="reports.php">Laporan</a>
        <a href="logout.php">Logout</a>
        
    </nav>
    <div class="container">
        <h2>Menu Utama</h2>
        <div class="menu">
            <div class="menu-item">
                <a href="patients.php">📋 Data Pasien</a>
                <p>Kelola informasi pasien.</p>
            </div>
            <div class="menu-item">
                <a href="doctors.php">👨‍⚕️ Data Dokter</a>
                <p>Kelola informasi dokter.</p>
            </div>
            <div class="menu-item">
                <a href="appointments.php">📅 Jadwal Janji Temu</a>
                <p>Atur jadwal janji temu.</p>
            </div>
            <div class="menu-item">
                <a href="reports.php">📊 Laporan</a>
                <p>Lihat laporan harian/bulanan.</p>
            </div>

            <div class="menu-item">
                <a href="document.php">📊 dokumen</a>
                <p>Lihat .</p>
            </div>
        </div>

        <div class="contact-section">
            <h2>Kontak Kami</h2>
            <p>Hubungi kami untuk bantuan atau informasi lebih lanjut:</p>
            <p>Email: <a href="mailto:support@paperless.com">support@paperless.com</a></p>
            <p>Telepon: <a href="tel:+62123456789">+62 123 456 789</a></p>
            <p>Alamat: Jl. Teknologi No. 123, Jakarta</p>
        </div>
    </div>
</body>
</html>
