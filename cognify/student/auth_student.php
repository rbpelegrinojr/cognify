<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (empty($_SESSION['student_id'])) {
    set_flash('warning', 'Please log in as student.');
    redirect_to('login.php');
}
?>