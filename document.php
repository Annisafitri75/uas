<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

include 'db.php';

$upload_dir = "uploads/"; // Direktori penyimpanan file

// Pastikan direktori upload ada
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0755, true);
}

// Upload Dokumen
if (isset($_POST['upload_document'])) {
    $file_name = $_FILES['document']['name'];
    $file_tmp = $_FILES['document']['tmp_name'];
    $file_size = $_FILES['document']['size'];
    $file_error = $_FILES['document']['error'];

    // Validasi file
    $allowed_extensions = ['pdf', 'doc', 'docx', 'xlsx', 'ppt', 'txt'];
    $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    if (!in_array($file_extension, $allowed_extensions)) {
        $error = "Hanya file dengan format " . implode(', ', $allowed_extensions) . " yang diperbolehkan.";
    } elseif ($file_size > 5 * 1024 * 1024) { // Maksimal 5MB
        $error = "Ukuran file tidak boleh lebih dari 5MB.";
    } elseif ($file_error !== 0) {
        $error = "Terjadi kesalahan saat mengunggah file.";
    } else {
        $file_new_name = uniqid('', true) . "." . $file_extension;
        $file_destination = $upload_dir . $file_new_name;

        if (move_uploaded_file($file_tmp, $file_destination)) {
            // Simpan data ke database
            $sql = "INSERT INTO documents (file_name, file_path) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $file_name, $file_destination);

            if ($stmt->execute()) {
                $message = "Dokumen berhasil diunggah!";
            } else {
                $error = "Gagal menyimpan data dokumen.";
            }
        } else {
            $error = "Gagal memindahkan file ke server.";
        }
    }
}

// Hapus Dokumen
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    // Ambil data dokumen
    $sql = "SELECT file_path FROM documents WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $document = $result->fetch_assoc();

    if ($document) {
        // Hapus file dari server
        if (unlink($document['file_path'])) {
            // Hapus data dari database
            $sql = "DELETE FROM documents WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id);

            if ($stmt->execute()) {
                $message = "Dokumen berhasil dihapus!";
            } else {
                $error = "Gagal menghapus data dokumen.";
            }
        } else {
            $error = "Gagal menghapus file dari server.";
        }
    } else {
        $error = "Dokumen tidak ditemukan.";
    }
}

// Ambil Data Dokumen
$sql = "SELECT * FROM documents";
$result = $conn->query($sql);
$documents = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Dokumen</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
        }
        header {
            background-color:rgb(45, 66, 87);
            color: white;
            padding: 20px;
            text-align: center;
        }
        .container {
            width: 80%;
            margin: 20px auto;
        }
        h2, h3 {
            color: #4CAF50;
        }
        .form-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }
        label {
            font-weight: bold;
        }
        input[type="file"], button {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border-radius: 4px;
            border: 1px solid #ddd;
        }
        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .message, .error {
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
            text-align: center;
        }
        .message {
            background-color: #d4edda;
            color: #155724;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        a {
            text-decoration: none;
            color:rgb(232, 235, 233);
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<header>
    <div class="header-content">
        <h1>Dashboard</h1>
        <a href="index.php" class="dashbord">Dashbord</a>
        
        <a href="logout.php" class="logout">Logout</a>
    </div>
</header>   
<header>
    <h2>Manajemen Dokumen</h2>
</header>

<div class="container">
    <?php if (isset($message)) { echo "<div class='message'>$message</div>"; } ?>
    <?php if (isset($error)) { echo "<div class='error'>$error</div>"; } ?>

    <!-- Form Upload Dokumen -->
    <div class="form-container">
        <h3>Unggah Dokumen Baru</h3>
        <form method="post" enctype="multipart/form-data">
            <label for="document">Pilih File:</label>
            <input type="file" id="document" name="document" required>
            <button type="submit" name="upload_document">Unggah</button>
        </form>
    </div>

    <!-- Daftar Dokumen -->
    <h3>Daftar Dokumen</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama File</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($documents as $doc) { ?>
            <tr>
                <td><?php echo $doc['id']; ?></td>
                <td><?php echo $doc['file_name']; ?></td>
                <td>
                    <a href="<?php echo $doc['file_path']; ?>" download>Unduh</a> | 
                    <a href="document_management.php?delete=<?php echo $doc['id']; ?>" 
                       onclick="return confirm('Yakin ingin menghapus dokumen ini?');">Hapus</a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

    <a href="dashboard.php">Kembali ke Dashboard</a>
</div>

</body>
</html>
