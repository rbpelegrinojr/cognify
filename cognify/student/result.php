<?php
require_once '../config.php';

$is_admin_view = isset($_GET['admin_view']) ? 1 : 0;
if (!$is_admin_view) {
    require_once 'auth_student.php';
} else {
    require_once '../admin/auth_admin.php';
}

$quiz_id = isset($_GET['quiz_id']) ? intval($_GET['quiz_id']) : 0;
if ($quiz_id <= 0) {
    set_flash('danger', 'Result not found.');
    redirect_to($is_admin_view ? '../admin/results.php' : 'dashboard.php');
}

$filter = $is_admin_view ? "" : " AND qz.student_id = " . intval($_SESSION['student_id']);
$sql = "SELECT qz.*, s.full_name, s.student_no
        FROM quizzes qz
        INNER JOIN students s ON s.student_id = qz.student_id
        WHERE qz.quiz_id = $quiz_id $filter
        LIMIT 1";
$res = mysqli_query($con, $sql);

if (!$res || mysqli_num_rows($res) <= 0) {
    set_flash('danger', 'Result not accessible.');
    redirect_to($is_admin_view ? '../admin/results.php' : 'dashboard.php');
}
$quiz = mysqli_fetch_assoc($res);

$details_sql = "SELECT qa.*, q.question_text, q.question_image, q.image_label,
                cat.name AS category_name, sc.choice_text AS selected_text, cc.choice_text AS correct_text
                FROM quiz_answers qa
                INNER JOIN questions q ON q.question_id = qa.question_id
                INNER JOIN categories cat ON cat.category_id = q.category_id
                LEFT JOIN question_choices sc ON sc.choice_id = qa.selected_choice_id
                LEFT JOIN question_choices cc ON cc.choice_id = qa.correct_choice_id
                WHERE qa.quiz_id = $quiz_id
                ORDER BY " . question_category_order_case() . " ASC, q.question_id ASC";
$details = mysqli_query($con, $details_sql);

$category_scores = array();
$detail_rows = array();
while ($row = mysqli_fetch_assoc($details)) {
    $detail_rows[] = $row;
    if (!isset($category_scores[$row['category_name']])) {
        $category_scores[$row['category_name']] = array('correct' => 0, 'total' => 0);
    }
    $category_scores[$row['category_name']]['total']++;
    if (intval($row['is_correct']) === 1) {
        $category_scores[$row['category_name']]['correct']++;
    }
}

$page_title = 'Quiz Result';
$asset_prefix = '../';
$nav_links = $is_admin_view ? array(
    array('url' => '../admin/dashboard.php', 'label' => 'Admin Dashboard'),
    array('url' => '../admin/results.php', 'label' => 'All Results')
) : array(
    array('url' => 'dashboard.php', 'label' => 'Dashboard'),
    array('url' => 'quiz.php', 'label' => 'Retake Quiz'),
    array('url' => 'logout.php', 'label' => 'Logout')
);
include '../inc/header.php';
?>
<div class="grid grid-2">
    <div class="card">
        <h2 class="mt-0">Quiz Summary</h2>
        <p><strong>Student:</strong> <?php echo esc($quiz['full_name']); ?> (<?php echo esc($quiz['student_no']); ?>)</p>
        <p><strong>Score:</strong> <?php echo intval($quiz['score']); ?> / <?php echo intval($quiz['total_questions']); ?></p>
        <div class="progress mb-2">
            <span style="width:<?php echo intval(($quiz['score'] / max(1, $quiz['total_questions'])) * 100); ?>%"></span>
        </div>
        <p class="mb-1"><strong>Top 1 Intelligence:</strong> <?php echo esc($quiz['top1_intelligence']); ?></p>
        <p class="mb-1"><strong>Top 2 Intelligence:</strong> <?php echo esc($quiz['top2_intelligence']); ?></p>
        <p class="mb-1"><strong>Top 3 Intelligence:</strong> <?php echo esc($quiz['top3_intelligence']); ?></p>
        <p class="small muted">Generated automatically based on category strengths from Remember to Create.</p>
    </div>
    <div class="card">
        <h3 class="mt-0">Category Performance</h3>
        <?php foreach ($category_scores as $category_name => $data) {
            $percent = ($data['total'] > 0) ? round(($data['correct'] / $data['total']) * 100, 2) : 0;
        ?>
            <div class="mb-2">
                <div class="flex-between">
                    <strong><?php echo esc($category_name); ?></strong>
                    <span><?php echo intval($data['correct']); ?> / <?php echo intval($data['total']); ?> (<?php echo $percent; ?>%)</span>
                </div>
                <div class="progress"><span style="width:<?php echo $percent; ?>%"></span></div>
            </div>
        <?php } ?>
    </div>
</div>

<div class="card mt-2">
    <h3 class="mt-0">Answer Review</h3>
    <?php foreach ($detail_rows as $index => $row) { ?>
        <div class="card question-card">
            <div class="question-meta">
                <span class="badge">#<?php echo $index + 1; ?></span>
                <span class="badge"><?php echo esc($row['category_name']); ?></span>
                <span class="badge"><?php echo intval($row['is_correct']) === 1 ? 'Correct' : 'Incorrect'; ?></span>
            </div>
            <h4 class="mt-0"><?php echo esc($row['question_text']); ?></h4>
            <?php if ($row['question_image'] != '') { ?>
                <div class="small muted"><?php echo esc($row['image_label']); ?></div>
                <img class="question-image" src="../<?php echo esc($row['question_image']); ?>" alt="">
            <?php } ?>
            <p class="mb-1"><strong>Your Answer:</strong> <?php echo esc($row['selected_text']); ?></p>
            <p class="mb-0"><strong>Correct Answer:</strong> <?php echo esc($row['correct_text']); ?></p>
        </div>
    <?php } ?>
</div>
<?php include '../inc/footer.php'; ?>