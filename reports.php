<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: reports.php");
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
            padding: 1px;
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
        <h1>Manajemen Laporan</h1>
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
</body>
</html>



<?php
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

include 'db.php';

// Fungsi untuk ekspor data ke CSV
if (isset($_GET['export'])) {
    $type = $_GET['export'];
    $filename = $type . "_report_" . date('Y-m-d') . ".csv";

    header("Content-Type: text/csv");
    header("Content-Disposition: attachment; filename=\"$filename\"");

    $output = fopen("php://output", "w");

    if ($type == 'patients') {
        $sql = "SELECT * FROM patients";
        $result = $conn->query($sql);
        fputcsv($output, ['ID', 'Nama', 'Email', 'Telepon', 'Alamat']);
        while ($row = $result->fetch_assoc()) {
            fputcsv($output, [$row['id'], $row['name'], $row['email'], $row['phone'], $row['address']]);
        }
    } elseif ($type == 'doctors') {
        $sql = "SELECT * FROM doctors";
        $result = $conn->query($sql);
        fputcsv($output, ['ID', 'Nama', 'Spesialisasi', 'Email', 'Telepon', 'Alamat']);
        while ($row = $result->fetch_assoc()) {
            fputcsv($output, [$row['id'], $row['name'], $row['specialization'], $row['email'], $row['contact'], $row['address']]);
        }
    } elseif ($type == 'appointments') {
        $sql = "SELECT * FROM appointments";
        $result = $conn->query($sql);
        fputcsv($output, ['ID', 'Nama Pasien', 'Nama Dokter', 'Tanggal', 'Waktu', 'Status']);
        while ($row = $result->fetch_assoc()) {
            fputcsv($output, [$row['id'], $row['patient_name'], $row['doctor_name'], $row['appointment_date'], $row['appointment_time'], $row['status']]);
        }
    }

    fclose($output);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }
        header {
            background-color: #333;
            color: white;
            padding: 10px;
            text-align: center;
        }
        .container {
            padding: 20px;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background: #333;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 10px 0;
        }
        .btn:hover {
            background: #555;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #333;
            color: white;
        }
    </style>
</head>
<body>
  
    <div class="container">
        
        <h2>Data Pasien</h2>
        <a href="?export=patients" class="btn">Ekspor CSV</a>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Telepon</th>
                    <th>Alamat</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM patients";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['name']}</td>
                                <td>{$row['email']}</td>
                                <td>{$row['phone']}</td>
                                <td>{$row['address']}</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>Tidak ada data pasien.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <h2>Data Dokter</h2>
        <a href="?export=doctors" class="btn">Ekspor CSV</a>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Spesialisasi</th>
                    <th>Email</th>
                    <th>Telepon</th>
                    <th>Alamat</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM doctors";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['name']}</td>
                                <td>{$row['specialization']}</td>
                                <td>{$row['email']}</td>
                                <td>{$row['contact']}</td>
                                <td>{$row['address']}</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>Tidak ada data dokter.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <h2>Data Janji Temu</h2>
        <a href="?export=appointments" class="btn">Ekspor CSV</a>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Pasien</th>
                    <th>Nama Dokter</th>
                    <th>Tanggal</th>
                    <th>Waktu</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM appointments";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['patient_name']}</td>
                                <td>{$row['doctor_name']}</td>
                                <td>{$row['appointment_date']}</td>
                                <td>{$row['appointment_time']}</td>
                                <td>{$row['status']}</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>Tidak ada data janji temu.</td></tr>";
                }
                ?>
            </tbody>
        </table>
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
