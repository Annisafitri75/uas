<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: appointments.php");
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
        <h1>Jadwal Janji Temu</h1>
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

// Tambah Janji Temu
if (isset($_POST['add_appointment'])) {
    $patient_name = $_POST['patient_name'];
    $doctor_name = $_POST['doctor_name'];
    $appointment_date = $_POST['appointment_date'];
    $appointment_time = $_POST['appointment_time'];

    $sql = "INSERT INTO appointments (patient_name, doctor_name, appointment_date, appointment_time) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $patient_name, $doctor_name, $appointment_date, $appointment_time);
    $stmt->execute();
    header("Location: appointments.php");
    exit();
}

// Hapus Janji Temu
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM appointments WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: appointments.php");
    exit();
}

// Ambil Data Janji Temu
$sql = "SELECT * FROM appointments ORDER BY appointment_date, appointment_time";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Janji Temu</title>
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
        .container {
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #333;
            color: white;
        }
        .btn {
            padding: 8px 16px;
            background: #333;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }
        .btn:hover {
            background: #555;
        }
        .form-container {
            margin-top: 20px;
            padding: 10px;
            background: white;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
    </style>
</head>
<body>
   
    <div class="container">
        
        <div class="form-container">
            <h2>Tambah Janji Temu</h2>
            <form action="" method="POST">
                <label for="patient_name">Nama Pasien:</label><br>
                <input type="text" id="patient_name" name="patient_name" required><br><br>

                <label for="doctor_name">Nama Dokter:</label><br>
                <input type="text" id="doctor_name" name="doctor_name" required><br><br>

                <label for="appointment_date">Tanggal Janji Temu:</label><br>
                <input type="date" id="appointment_date" name="appointment_date" required><br><br>

                <label for="appointment_time">Waktu Janji Temu:</label><br>
                <input type="time" id="appointment_time" name="appointment_time" required><br><br>

                <button type="submit" name="add_appointment" class="btn">Tambah</button>
            </form>
        </div>

        <h2>Daftar Janji Temu</h2>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Pasien</th>
                    <th>Nama Dokter</th>
                    <th>Tanggal</th>
                    <th>Waktu</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php $no = 1; ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo $row['patient_name']; ?></td>
                            <td><?php echo $row['doctor_name']; ?></td>
                            <td><?php echo $row['appointment_date']; ?></td>
                            <td><?php echo $row['appointment_time']; ?></td>
                            <td><?php echo $row['status']; ?></td>
                            <td>
                                <a href="appointments.php?delete=<?php echo $row['id']; ?>" class="btn" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">Belum ada data janji temu.</td>
                    </tr>
                <?php endif; ?>
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
