<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (empty($_SESSION['admin_id'])) {
    set_flash('warning', 'Please log in as administrator.');
    redirect_to('login.php');
}
?>