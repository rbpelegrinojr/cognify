<?php
require_once '../config.php';
require_once 'auth_admin.php';

$order_case = question_category_order_case();
$sql = "SELECT q.*, cat.name AS category_name,
        (SELECT COUNT(*) FROM question_choices qc WHERE qc.question_id = q.question_id) AS choice_count
        FROM questions q
        INNER JOIN categories cat ON cat.category_id = q.category_id
        ORDER BY $order_case ASC, q.question_id ASC";
$res = mysqli_query($con, $sql);

$page_title = 'Manage Questions';
$asset_prefix = '../';
$nav_links = array(
    array('url' => 'dashboard.php', 'label' => 'Dashboard'),
    array('url' => 'question_form.php', 'label' => 'Add Question'),
    array('url' => 'settings.php', 'label' => 'Settings'),
    array('url' => 'logout.php', 'label' => 'Logout')
);
include '../inc/header.php';
?>
<div class="card">
    <div class="flex-between">
        <div>
            <h2 class="mt-0 mb-1">Question Bank</h2>
            <div class="muted">All questions are displayed in the exact quiz order.</div>
        </div>
        <a class="btn" href="question_form.php">Add New Question</a>
    </div>

    <div class="table-wrap mt-2">
        <table>
            <tr>
                <th>#</th>
                <th>Category</th>
                <th>Question</th>
                <th>Image</th>
                <th>Choices</th>
                <th>Action</th>
            </tr>
            <?php $i = 1; while ($row = mysqli_fetch_assoc($res)) { ?>
            <tr>
                <td><?php echo $i++; ?></td>
                <td><span class="badge"><?php echo esc($row['category_name']); ?></span></td>
                <td>
                    <strong><?php echo esc(substr($row['question_text'], 0, 160)); ?></strong>
                    <?php if (strlen($row['question_text']) > 160) { ?>...<?php } ?>
                    <?php if ($row['image_label'] != '') { ?>
                        <div class="small muted mt-2">Image Label: <?php echo esc($row['image_label']); ?></div>
                    <?php } ?>
                </td>
                <td>
                    <?php if ($row['question_image'] != '') { ?>
                        <img src="../<?php echo esc($row['question_image']); ?>" alt="" style="width:90px;border-radius:10px;border:1px solid #d9efe8;">
                    <?php } else { ?>
                        <span class="muted">None</span>
                    <?php } ?>
                </td>
                <td><?php echo intval($row['choice_count']); ?></td>
                <td>
                    <a class="btn btn-light" href="question_form.php?id=<?php echo intval($row['question_id']); ?>">Edit</a>
                    <a class="btn btn-danger" onclick="return confirm('Delete this question?');" href="delete_question.php?id=<?php echo intval($row['question_id']); ?>">Delete</a>
                </td>
            </tr>
            <?php } ?>
        </table>
    </div>
</div>
<?php include '../inc/footer.php'; ?>