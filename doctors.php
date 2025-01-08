<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: doctors.php");
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
        <h1>Data Dokter</h1>
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

// Tambah Dokter
if (isset($_POST['add_doctor'])) {
    $name = $_POST['name'];
    $specialization = $_POST['specialization'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $address = $_POST['address'];

    $sql = "INSERT INTO doctors (name, specialization, contact, email, address) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $name, $specialization, $contact, $email, $address);
    $stmt->execute();
    header("Location: doctors.php");
    exit();
}

// Hapus Dokter
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM doctors WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: doctors.php");
    exit();
}

// Ambil Data Dokter
$sql = "SELECT * FROM doctors";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Dokter</title>
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
            <h2>Tambah Dokter</h2>
            <form action="" method="POST">
                <label for="name">Nama:</label><br>
                <input type="text" id="name" name="name" required><br><br>

                <label for="specialization">Spesialisasi:</label><br>
                <input type="text" id="specialization" name="specialization" required><br><br>

                <label for="contact">Kontak:</label><br>
                <input type="text" id="contact" name="contact" required><br><br>

                <label for="email">Email:</label><br>
                <input type="email" id="email" name="email" required><br><br>

                <label for="address">Alamat:</label><br>
                <textarea id="address" name="address" rows="4" required></textarea><br><br>

                <button type="submit" name="add_doctor" class="btn">Tambah</button>
            </form>
        </div>

        <h2>Daftar Dokter</h2>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Spesialisasi</th>
                    <th>Kontak</th>
                    <th>Email</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php $no = 1; ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['specialization']; ?></td>
                            <td><?php echo $row['contact']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['address']; ?></td>
                            <td>
                                <a href="doctors.php?delete=<?php echo $row['id']; ?>" class="btn" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">Belum ada data dokter.</td>
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