<?php
require_once '../config.php';
require_once 'auth_student.php';

$limit = intval(get_setting($con, 'quiz_question_limit', '30'));
if ($limit <= 0) {
    $limit = 30;
}

$order_case = question_category_order_case();
$sql = "SELECT q.*, cat.name AS category_name
        FROM questions q
        INNER JOIN categories cat ON cat.category_id = q.category_id
        ORDER BY $order_case ASC, q.question_id ASC
        LIMIT $limit";
$res = mysqli_query($con, $sql);

$questions = array();
while ($row = mysqli_fetch_assoc($res)) {
    $row['choices'] = array();
    $c_res = mysqli_query($con, "SELECT choice_id, choice_text FROM question_choices WHERE question_id = " . intval($row['question_id']) . " ORDER BY sort_order ASC, choice_id ASC");
    while ($c = mysqli_fetch_assoc($c_res)) {
        $row['choices'][] = $c;
    }
    $questions[] = $row;
}

$page_title = 'Take Quiz';
$asset_prefix = '../';
$nav_links = array(
    array('url' => 'dashboard.php', 'label' => 'Dashboard'),
    array('url' => 'logout.php', 'label' => 'Logout')
);
include '../inc/header.php';
?>

<div class="card">
    <div class="flex-between">
        <div>
            <h2 class="mt-0 mb-1">Cognify Quiz</h2>
            <div class="muted">Sorted order: Remember → Understand → Apply → Analyze → Evaluate → Create</div>
        </div>
        <span class="badge"><?php echo count($questions); ?> Questions</span>
    </div>

    <?php if (count($questions) <= 0) { ?>
        <div class="alert alert-warning mt-2">No questions available yet. Please contact the administrator.</div>
    <?php } else { ?>
        <form method="post" action="submit.php">
            <?php foreach ($questions as $index => $q) { ?>
                <div class="card question-card">
                    <div class="question-meta">
                        <span class="badge">#<?php echo $index + 1; ?></span>
                        <span class="badge"><?php echo esc($q['category_name']); ?></span>
                    </div>
                    <h3 class="mt-0"><?php echo esc($q['question_text']); ?></h3>

                    <?php if ($q['question_image'] != '') { ?>
                        <div class="muted small"><?php echo esc($q['image_label']); ?></div>
                        <img class="question-image" src="../<?php echo esc($q['question_image']); ?>" alt="">
                    <?php } ?>

                    <input type="hidden" name="question_ids[]" value="<?php echo intval($q['question_id']); ?>">

                    <?php foreach ($q['choices'] as $choice) { ?>
                        <div class="radio-line mb-2">
                            <input type="radio" name="answer[<?php echo intval($q['question_id']); ?>]" value="<?php echo intval($choice['choice_id']); ?>" required>
                            <div><?php echo esc($choice['choice_text']); ?></div>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>

            <button class="btn btn-block" type="submit" onclick="return confirm('Submit your quiz now?');">Submit Quiz</button>
        </form>
    <?php } ?>
</div>

<?php include '../inc/footer.php'; ?>