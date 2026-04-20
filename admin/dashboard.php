<?php
require_once '../config.php';
require_once 'auth_admin.php';

$total_questions = mysqli_fetch_row(mysqli_query($con, "SELECT COUNT(*) FROM questions"));
$total_students = mysqli_fetch_row(mysqli_query($con, "SELECT COUNT(*) FROM students"));
$total_quizzes = mysqli_fetch_row(mysqli_query($con, "SELECT COUNT(*) FROM quizzes"));
$quiz_limit = get_setting($con, 'quiz_question_limit', '30');

$page_title = 'Admin Dashboard';
$asset_prefix = '../';
$nav_links = array(
    array('url' => 'dashboard.php', 'label' => 'Dashboard'),
    array('url' => 'questions.php', 'label' => 'Questions'),
    array('url' => 'question_form.php', 'label' => 'Add Question'),
    array('url' => 'settings.php', 'label' => 'Quiz Settings'),
    array('url' => 'results.php', 'label' => 'Results'),
    array('url' => 'logout.php', 'label' => 'Logout')
);
include '../inc/header.php';
?>
<div class="grid grid-3">
    <div class="stat">
        <div class="muted">Total Questions</div>
        <div class="kpi"><?php echo intval($total_questions[0]); ?></div>
    </div>
    <div class="stat">
        <div class="muted">Registered Students</div>
        <div class="kpi"><?php echo intval($total_students[0]); ?></div>
    </div>
    <div class="stat">
        <div class="muted">Quiz Attempts</div>
        <div class="kpi"><?php echo intval($total_quizzes[0]); ?></div>
    </div>
</div>

<div class="grid grid-2 mt-2">
    <div class="card">
        <h3 class="mt-0">Current Quiz Configuration</h3>
        <p>Total questions shown to student: <strong><?php echo intval($quiz_limit); ?></strong></p>
        <p class="muted">The student quiz will always sort questions by category order: Remember → Understand → Apply → Analyze → Evaluate → Create.</p>
        <a class="btn" href="settings.php">Update Settings</a>
    </div>
    <div class="card">
        <h3 class="mt-0">Quick Links</h3>
        <div class="nav">
            <a href="question_form.php">Create Question</a>
            <a href="questions.php">Manage Questions</a>
            <a href="results.php">Review Results</a>
        </div>
    </div>
</div>
<?php include '../inc/footer.php'; ?>