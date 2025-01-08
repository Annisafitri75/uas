<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(45deg,rgb(0, 0, 0),rgb(70, 90, 112));
            color: white;
            text-align: center;
        }

        .container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
        }

        .btn {
            padding: 0.7rem 2rem;
            background-color: #ffffff;
            color:rgb(3, 3, 3);
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-size: 1rem;
            text-decoration: none;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .btn:hover {
            background-color:rgb(5, 5, 5);
            color: #ffffff;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Selamat Datang di Sistem Manajemen Hospital</h1>
        <p>Pilih menu untuk memulai</p>
        <a href="login.php" class="btn">Masuk ke Login</a>
    </div>
</body>
</html>
