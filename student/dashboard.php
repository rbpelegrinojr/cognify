<?php
require_once '../config.php';
require_once 'auth_student.php';

$limit = get_setting($con, 'quiz_question_limit', '30');
$total_available = mysqli_fetch_row(mysqli_query($con, "SELECT COUNT(*) FROM questions"));

$latest = mysqli_query($con, "SELECT * FROM quizzes WHERE student_id = " . intval($_SESSION['student_id']) . " ORDER BY quiz_id DESC LIMIT 1");
$latest_quiz = ($latest && mysqli_num_rows($latest) > 0) ? mysqli_fetch_assoc($latest) : false;

$page_title = 'Student Dashboard';
$asset_prefix = '../';
$nav_links = array(
    array('url' => 'dashboard.php', 'label' => 'Dashboard'),
    array('url' => 'quiz.php', 'label' => 'Take Quiz'),
    array('url' => 'logout.php', 'label' => 'Logout')
);
include '../inc/header.php';
?>
<div class="grid grid-2">
    <div class="card">
        <h2 class="mt-0">Hello, <?php echo esc($_SESSION['student_name']); ?></h2>
        <p>Questions available in bank: <strong><?php echo intval($total_available[0]); ?></strong></p>
        <p>Questions that will appear in your quiz: <strong><?php echo intval($limit); ?></strong></p>
        <a class="btn" href="quiz.php">Start Quiz</a>
    </div>
    <div class="card">
        <h3 class="mt-0">Latest Result</h3>
        <?php if ($latest_quiz) {
            $lq_score = intval($latest_quiz['score']);
            $lq_total = intval($latest_quiz['total_questions']);
            $lq_pct = ($lq_total > 0) ? round(($lq_score / $lq_total) * 100, 2) : 0;
            $lq_passed = is_passed($lq_score, $lq_total, $con);
        ?>
            <p><strong>Score:</strong> <?php echo $lq_score; ?> / <?php echo $lq_total; ?> (<?php echo $lq_pct; ?>%)</p>
            <div class="progress mb-2">
                <span style="width:<?php echo intval($lq_pct); ?>%"></span>
            </div>
            <p>
                <strong>Result:</strong>
                <?php if ($lq_passed) { ?>
                    <span class="result-pass">PASSED</span>
                <?php } else { ?>
                    <span class="result-fail">FAILED</span>
                <?php } ?>
            </p>
            <a class="btn btn-light" href="result.php?quiz_id=<?php echo intval($latest_quiz['quiz_id']); ?>">View Full Result</a>
        <?php } else { ?>
            <p class="muted">No quiz taken yet.</p>
        <?php } ?>
    </div>
</div>
<?php include '../inc/footer.php'; ?>