<?php
require_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_no = mysqli_real_escape_string($con, trim($_POST['student_no']));
    $full_name = mysqli_real_escape_string($con, trim($_POST['full_name']));
    $email = mysqli_real_escape_string($con, trim($_POST['email']));
    $password = trim($_POST['password']);

    if ($student_no === '' || $full_name === '' || $password === '') {
        set_flash('danger', 'Student number, full name, and password are required.');
        redirect_to('register.php');
    }

    $check = mysqli_query($con, "SELECT student_id FROM students WHERE student_no = '$student_no' LIMIT 1");
    if ($check && mysqli_num_rows($check) > 0) {
        set_flash('warning', 'Student number already exists.');
        redirect_to('register.php');
    }

    $hash = mysqli_real_escape_string($con, password_hash($password, PASSWORD_DEFAULT));
    mysqli_query($con, "INSERT INTO students (student_no, full_name, email, password_hash, created_at)
                        VALUES ('$student_no', '$full_name', '$email', '$hash', NOW())");

    set_flash('success', 'Registration successful. Please log in.');
    redirect_to('login.php');
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Student Registration</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        body{
            margin:0;
            font-family: Arial, Helvetica, sans-serif;
            min-height:100vh;
            background:url('../assets/images/logo.png') no-repeat center center/cover;
        }

        .overlay{
            width:100%;
            min-height:100vh;
            background:rgba(0,0,0,0.65);
            display:flex;
            justify-content:center;
            align-items:center;
            padding:30px 15px;
            box-sizing:border-box;
        }

        .register-card{
            width:100%;
            max-width:430px;
            background:rgba(255,255,255,0.93);
            padding:35px;
            border-radius:14px;
            box-shadow:0 10px 30px rgba(0,0,0,0.35);
            box-sizing:border-box;
        }

        .register-card h2{
            margin:0 0 10px 0;
            text-align:center;
            color:#1f2937;
        }

        .register-card p{
            text-align:center;
            color:#666;
            margin:0 0 25px 0;
            line-height:1.5;
        }

        .form-group{
            margin-bottom:18px;
        }

        .form-group label{
            font-weight:bold;
            display:block;
            margin-bottom:6px;
            color:#374151;
        }

        .form-group input{
            width:100%;
            padding:12px 12px;
            border-radius:8px;
            border:1px solid #d1d5db;
            box-sizing:border-box;
            font-size:14px;
            outline:none;
        }

        .form-group input:focus{
            border-color:#3cc7a1;
            box-shadow:0 0 0 3px rgba(60,199,161,0.15);
        }

        .btn{
            width:100%;
            padding:12px;
            border:none;
            border-radius:8px;
            background:#3cc7a1;
            color:#fff;
            font-size:16px;
            cursor:pointer;
            transition:0.2s ease;
        }

        .btn:hover{
            background:#2fb58e;
        }

        .links{
            text-align:center;
            margin-top:18px;
            font-size:14px;
        }

        .links a{
            color:#2fb58e;
            text-decoration:none;
            margin:0 5px;
        }

        .links a:hover{
            text-decoration:underline;
        }

        @media (max-width: 480px){
            .register-card{
                padding:25px 18px;
            }
        }
    </style>
</head>
<body>

<div class="overlay">
    <div class="register-card">
        <h2>Student Registration</h2>
        <p>Create your account to access the Cognify assessment and view your intelligence strengths.</p>

        <form method="post">

            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="full_name" required>
            </div>

            <div class="form-group">
                <label>Email (optional)</label>
                <input type="email" name="email">
            </div>
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="student_no" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>

            <button class="btn" type="submit">Register</button>
        </form>

        <div class="links">
            <a href="login.php">Student Login</a>
        </div>
    </div>
</div>

</body>
</html>