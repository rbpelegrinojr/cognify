<?php
require_once '../config.php';
require_once 'auth_admin.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id > 0) {
    mysqli_query($con, "DELETE FROM question_choices WHERE question_id = $id");
    mysqli_query($con, "DELETE FROM questions WHERE question_id = $id");
    set_flash('success', 'Question deleted.');
}
redirect_to('questions.php');
?>