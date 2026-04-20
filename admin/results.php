<?php
require_once '../config.php';
require_once 'auth_admin.php';

$sql = "SELECT qz.*, s.student_no, s.full_name
        FROM quizzes qz
        INNER JOIN students s ON s.student_id = qz.student_id
        ORDER BY qz.quiz_id DESC";
$res = mysqli_query($con, $sql);

$page_title = 'Student Results';
$asset_prefix = '../';
$nav_links = array(
    array('url' => 'dashboard.php', 'label' => 'Dashboard'),
    array('url' => 'questions.php', 'label' => 'Questions'),
    array('url' => 'settings.php', 'label' => 'Settings'),
    array('url' => 'logout.php', 'label' => 'Logout')
);
include '../inc/header.php';
?>
<div class="card">
    <h2 class="mt-0">Student Quiz Results</h2>
    <div class="table-wrap">
        <table>
            <tr>
                <th>Student</th>
                <th>Score</th>
                <th>Top 3 Intelligence</th>
                <th>Taken On</th>
                <th>Details</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($res)) { ?>
                <tr>
                    <td>
                        <strong><?php echo esc($row['full_name']); ?></strong><br>
                        <span class="muted"><?php echo esc($row['student_no']); ?></span>
                    </td>
                    <td><?php echo intval($row['score']); ?> / <?php echo intval($row['total_questions']); ?></td>
                    <td>
                        <?php echo esc($row['top1_intelligence']); ?><br>
                        <?php echo esc($row['top2_intelligence']); ?><br>
                        <?php echo esc($row['top3_intelligence']); ?>
                    </td>
                    <td><?php echo esc($row['taken_at']); ?></td>
                    <td><a class="btn btn-light" href="../student/result.php?quiz_id=<?php echo intval($row['quiz_id']); ?>&admin_view=1">Open</a></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>
<?php include '../inc/footer.php'; ?>