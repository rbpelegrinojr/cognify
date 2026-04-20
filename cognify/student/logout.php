<?php
require_once '../config.php';
session_destroy();
session_start();
set_flash('success', 'Student logged out.');
redirect_to('login.php');
?>