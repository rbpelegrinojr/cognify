<?php
require_once '../config.php';

if (!empty($_SESSION['student_id'])) {
    redirect_to('dashboard.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_no = mysqli_real_escape_string($con, trim($_POST['student_no']));
    $password = trim($_POST['password']);

    $res = mysqli_query($con, "SELECT * FROM students WHERE student_no = '$student_no' LIMIT 1");
    if ($res && mysqli_num_rows($res) > 0) {
        $student = mysqli_fetch_assoc($res);
        if (password_verify($password, $student['password_hash'])) {
            $_SESSION['student_id'] = $student['student_id'];
            $_SESSION['student_name'] = $student['full_name'];
            set_flash('success', 'Welcome, ' . $student['full_name'] . '!');
            redirect_to('dashboard.php');
        }
    }

    set_flash('danger', 'Invalid student login.');
    redirect_to('login.php');
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Student Login</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<style>

/* ===== FULL PAGE BACKGROUND ===== */
body{
    margin:0;
    font-family: Arial, Helvetica, sans-serif;
    min-height:100vh;
    background:url('../assets/images/logo.png') no-repeat center center/cover;
}

/* ===== DARK OVERLAY ===== */
.overlay{
    width:100%;
    min-height:100vh;
    background:rgba(0,0,0,0.65);
    display:flex;
    justify-content:center;
    align-items:center;
    padding:20px;
    box-sizing:border-box;
}

/* ===== LOGIN CARD ===== */
.login-card{
    width:360px;
    background:rgba(255,255,255,0.93);
    padding:35px;
    border-radius:10px;
    box-shadow:0 10px 25px rgba(0,0,0,0.4);
    box-sizing:border-box;
}

/* ===== TITLE ===== */
.login-card h2{
    margin-top:0;
    text-align:center;
    margin-bottom:10px;
}

.login-card p{
    text-align:center;
    color:#666;
    margin-bottom:20px;
}

/* ===== FLASH MESSAGE ===== */
.alert{
    padding:12px 14px;
    border-radius:6px;
    margin-bottom:15px;
    font-size:14px;
}

.alert-danger{
    background:#fde2e2;
    color:#a61b1b;
    border:1px solid #f5b5b5;
}

.alert-success{
    background:#def7ec;
    color:#0f766e;
    border:1px solid #a7f3d0;
}

.alert-warning{
    background:#fff4d6;
    color:#9a6700;
    border:1px solid #f5d48a;
}

/* ===== FORM ===== */
.form-group{
    margin-bottom:18px;
}

.form-group label{
    font-weight:bold;
    display:block;
    margin-bottom:6px;
}

.form-group input{
    width:100%;
    padding:10px;
    border-radius:6px;
    border:1px solid #ccc;
    box-sizing:border-box;
}

/* ===== BUTTON ===== */
.btn{
    width:100%;
    padding:12px;
    border:none;
    border-radius:6px;
    background:#3cc7a1;
    color:white;
    font-size:16px;
    cursor:pointer;
}

.btn:hover{
    background:#2fb58e;
}

/* ===== LINKS ===== */
.links{
    text-align:center;
    margin-top:15px;
}

.links a{
    color:#3cc7a1;
    text-decoration:none;
    margin:0 5px;
}

.links a:hover{
    text-decoration:underline;
}

/* ===== RESPONSIVE ===== */
@media (max-width:480px){
    .login-card{
        width:90%;
        padding:25px 18px;
    }
}

</style>

</head>

<body>

<div class="overlay">

    <div class="login-card">

        <h2>Student Login</h2>
        <p>Access your Cognify assessment account.</p>

        <?php show_flash(); ?>

        <form method="post">

            <div class="form-group">
                <label>Username</label>
                <input type="text" name="student_no" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>

            <button class="btn" type="submit">Login</button>

        </form>

        <div class="links">
            <a href="register.php">Register</a>
        </div>

    </div>

</div>

</body>
</html>