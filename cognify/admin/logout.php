<?php
require_once '../config.php';
session_destroy();
session_start();
set_flash('success', 'Admin logged out successfully.');
redirect_to('login.php');
?>