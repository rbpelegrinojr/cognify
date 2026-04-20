<?php
require_once '../config.php';
require_once 'auth_admin.php';

$sql = "SELECT qz.*, s.student_no, s.full_name
        FROM quizzes qz
        INNER JOIN students s ON s.student_id = qz.student_id
        ORDER BY qz.quiz_id DESC";
$res = mysqli_query($con, $sql);
$passing_score = get_passing_score($con);

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
                <th>Result</th>
                <th>Taken On</th>
                <th>Details</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($res)) {
                $total = intval($row['total_questions']);
                $score = intval($row['score']);
                $pct = ($total > 0) ? round(($score / $total) * 100, 2) : 0;
                $row_passed = is_passed($score, $total, $con);
            ?>
                <tr>
                    <td>
                        <strong><?php echo esc($row['full_name']); ?></strong><br>
                        <span class="muted"><?php echo esc($row['student_no']); ?></span>
                    </td>
                    <td><?php echo $score; ?> / <?php echo $total; ?> (<?php echo $pct; ?>%)</td>
                    <td>
                        <?php if ($row_passed) { ?>
                            <span class="result-pass">PASSED</span>
                        <?php } else { ?>
                            <span class="result-fail">FAILED</span>
                        <?php } ?>
                    </td>
                    <td><?php echo esc($row['taken_at']); ?></td>
                    <td><a class="btn btn-light" href="../student/result.php?quiz_id=<?php echo intval($row['quiz_id']); ?>&admin_view=1">Open</a></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>
<?php include '../inc/footer.php'; ?>