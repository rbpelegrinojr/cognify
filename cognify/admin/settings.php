<?php
require_once '../config.php';
require_once 'auth_admin.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $limit = intval($_POST['quiz_question_limit']);
    if ($limit <= 0) {
        $limit = 30;
    }

    $exists = mysqli_query($con, "SELECT setting_id FROM settings WHERE setting_key = 'quiz_question_limit' LIMIT 1");
    if ($exists && mysqli_num_rows($exists) > 0) {
        mysqli_query($con, "UPDATE settings SET setting_value = '$limit' WHERE setting_key = 'quiz_question_limit'");
    } else {
        mysqli_query($con, "INSERT INTO settings (setting_key, setting_value) VALUES ('quiz_question_limit', '$limit')");
    }

    set_flash('success', 'Quiz settings updated.');
    redirect_to('settings.php');
}

$limit = get_setting($con, 'quiz_question_limit', '30');
$total_questions = mysqli_fetch_row(mysqli_query($con, "SELECT COUNT(*) FROM questions"));

$page_title = 'Quiz Settings';
$asset_prefix = '../';
$nav_links = array(
    array('url' => 'dashboard.php', 'label' => 'Dashboard'),
    array('url' => 'questions.php', 'label' => 'Questions'),
    array('url' => 'logout.php', 'label' => 'Logout')
);
include '../inc/header.php';
?>
<div class="grid grid-2">
    <div class="card">
        <h2 class="mt-0">Quiz Display Settings</h2>
        <form method="post">
            <div class="form-group">
                <label>Total Questions to Show Per Quiz</label>
                <input type="number" name="quiz_question_limit" min="1" value="<?php echo intval($limit); ?>" required>
            </div>
            <button class="btn" type="submit">Save Settings</button>
        </form>
    </div>

    <div class="card">
        <h3 class="mt-0">Current Bank Status</h3>
        <p>Total questions stored: <strong><?php echo intval($total_questions[0]); ?></strong></p>
        <p class="muted">Even if the bank has more questions, only the configured total appears to students. The quiz still starts as long as there is at least one question available.</p>
    </div>
</div>
<?php include '../inc/footer.php'; ?>