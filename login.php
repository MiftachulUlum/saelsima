<?php
include('db.php');
include('config.php');

// Proses login
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Query untuk memeriksa pengguna
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        // Verifikasi password
        if (password_verify($password, $user['password'])) {
            // Set sesi untuk pengguna
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_type'] = 'admin'; // Ubah sesuai logika Anda jika ada tipe user lain

            // Tetapkan pesan sukses dalam sesi
            $_SESSION['success_message'] = 'Login berhasil! Anda akan diarahkan ke dashboard.';
            header('Location: login.php'); // Redirect untuk mencegah pengulangan POST
            exit();
        } else {
            $_SESSION['error_message'] = 'Password salah.';
            header('Location: login.php'); // Redirect untuk mencegah pengulangan POST
            exit();
        }
    } else {
        $_SESSION['error_message'] = 'Username tidak ditemukan.';
        header('Location: login.php'); // Redirect untuk mencegah pengulangan POST
        exit();
    }
}

// Ambil pesan dari sesi jika ada
$success_message = isset($_SESSION['success_message']) ? $_SESSION['success_message'] : '';
$error_message = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : '';

// Hapus pesan dari sesi setelah ditampilkan
unset($_SESSION['success_message']);
unset($_SESSION['error_message']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - SAE'Lsima</title>
    <link rel="logo" sizes="180x180" href="./css/logo-pemasyarakatan.png">
   <link rel="icon" type="image/png" sizes="32x32" href="./css/logo-pemasyarakatan.png">
   <link rel="icon" type="image/png" sizes="16x16" href="./css/logo-pemasyarakatan.png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <style>
    body {
        background: url('images/kolam-1.jpeg') no-repeat center center fixed;
        background-size: cover;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .container {
        max-width: 400px;
        padding: 30px;
        background-color: rgba(255, 255, 255, 0.75);
        /* Transparansi 80% */
        border-radius: 10px;
        box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
        font-family: "Montserrat", sans-serif;
    }

    .container h2 {
        text-align: center;
        margin-bottom: 30px;
    }

    .form-group label {
        font-weight: bold;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        margin-top: 37px;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }

    .alert {
        margin-top: 20px;
    }
    </style>
</head>

<body>
    <div class="container">
        <h2><i class="fas fa-sign-in-alt"></i> Login</h2>
        
        <!-- Tampilkan pesan -->
        <?php if ($success_message): ?>
            <div class="alert alert-success"><?= $success_message ?></div>
            <script>
                setTimeout(function() {
                    window.location.href = "admin/dashboard.php";
                }, 2500); // 2.5 detik
            </script>
        <?php endif; ?>

        <?php if ($error_message): ?>
            <div class="alert alert-danger"><?= $error_message ?></div>
        <?php endif; ?>
        
        <form method="post">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" class="form-control" required placeholder="Masukkan username">
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" class="form-control" required placeholder="Masukkan password">
            </div>
            <button type="submit" class="btn btn-primary btn-block"><strong>Login</strong></button>
            <!-- <a href="register.php" class="btn btn-block"><i class="fas fa-user-plus"></i> <strong>Register</strong></a> -->
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>