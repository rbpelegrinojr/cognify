<?php
require_once '../config.php';
require_once 'auth_admin.php';

$total_questions = mysqli_fetch_row(mysqli_query($con, "SELECT COUNT(*) FROM questions"));
$total_students = mysqli_fetch_row(mysqli_query($con, "SELECT COUNT(*) FROM students"));
$total_quizzes = mysqli_fetch_row(mysqli_query($con, "SELECT COUNT(*) FROM quizzes"));
$quiz_limit = get_setting($con, 'quiz_question_limit', '30');
$passing_score = get_passing_score($con);

$pass_count = 0;
$fail_count = 0;
$all_quiz_res = mysqli_query($con, "SELECT score, total_questions FROM quizzes");
while ($qrow = mysqli_fetch_assoc($all_quiz_res)) {
    if (is_passed(intval($qrow['score']), intval($qrow['total_questions']), $con)) {
        $pass_count++;
    } else {
        $fail_count++;
    }
}

$cat_labels = array();
$cat_data = array();
$cat_sql = "SELECT cat.name,
            COUNT(qa.answer_id) AS total_answers,
            SUM(qa.is_correct) AS correct_answers
            FROM categories cat
            LEFT JOIN questions q ON q.category_id = cat.category_id
            LEFT JOIN quiz_answers qa ON qa.question_id = q.question_id
            GROUP BY cat.category_id, cat.name
            ORDER BY " . category_order_case() . " ASC";
$cat_res = mysqli_query($con, $cat_sql);
while ($crow = mysqli_fetch_assoc($cat_res)) {
    $cat_labels[] = $crow['name'];
    $total_ans = intval($crow['total_answers']);
    $correct_ans = intval($crow['correct_answers']);
    $cat_data[] = ($total_ans > 0) ? round(($correct_ans / $total_ans) * 100, 1) : 0;
}

$intel_counts = array();
$intel_sql = "SELECT top1_intelligence FROM quizzes WHERE top1_intelligence != ''";
$intel_res = mysqli_query($con, $intel_sql);
while ($irow = mysqli_fetch_assoc($intel_res)) {
    $name = $irow['top1_intelligence'];
    if (!isset($intel_counts[$name])) {
        $intel_counts[$name] = 0;
    }
    $intel_counts[$name]++;
}
arsort($intel_counts);
$intel_labels = array_keys($intel_counts);
$intel_data = array_values($intel_counts);

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
        <h3 class="mt-0">Pass / Fail Overview</h3>
        <div style="max-width:300px;margin:0 auto;">
            <canvas id="passFailChart"></canvas>
        </div>
    </div>
    <div class="card">
        <h3 class="mt-0">Category Performance (Avg %)</h3>
        <canvas id="categoryChart"></canvas>
    </div>
</div>

<div class="grid grid-2 mt-2">
    <div class="card">
        <h3 class="mt-0">Top Intelligence Distribution</h3>
        <canvas id="intelligenceChart"></canvas>
    </div>
    <div class="card">
        <h3 class="mt-0">Quick Links</h3>
        <div class="nav">
            <a href="question_form.php">Create Question</a>
            <a href="questions.php">Manage Questions</a>
            <a href="results.php">Review Results</a>
            <a href="settings.php">Quiz Settings</a>
        </div>
        <div class="mt-2">
            <h3 class="mt-0">Current Quiz Configuration</h3>
            <p>Questions shown to student: <strong><?php echo intval($quiz_limit); ?></strong></p>
            <p>Passing score: <strong><?php echo intval($passing_score); ?>%</strong></p>
            <a class="btn" href="settings.php">Update Settings</a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
<script>
var passFailCtx = document.getElementById('passFailChart').getContext('2d');
new Chart(passFailCtx, {
    type: 'doughnut',
    data: {
        labels: ['Passed', 'Failed'],
        datasets: [{
            data: [<?php echo intval($pass_count); ?>, <?php echo intval($fail_count); ?>],
            backgroundColor: ['#4fb89a', '#d85c6a'],
            borderWidth: 2,
            borderColor: '#fff'
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'bottom' }
        }
    }
});

var catCtx = document.getElementById('categoryChart').getContext('2d');
new Chart(catCtx, {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($cat_labels); ?>,
        datasets: [{
            label: 'Correct %',
            data: <?php echo json_encode($cat_data); ?>,
            backgroundColor: 'rgba(79,184,154,0.6)',
            borderColor: '#4fb89a',
            borderWidth: 1,
            borderRadius: 6
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true,
                max: 100,
                ticks: { callback: function(v) { return v + '%'; } }
            }
        },
        plugins: {
            legend: { display: false }
        }
    }
});

var intelCtx = document.getElementById('intelligenceChart').getContext('2d');
new Chart(intelCtx, {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($intel_labels); ?>,
        datasets: [{
            label: 'Students',
            data: <?php echo json_encode($intel_data); ?>,
            backgroundColor: [
                'rgba(79,184,154,0.7)',
                'rgba(136,216,192,0.7)',
                'rgba(241,178,74,0.7)',
                'rgba(216,92,106,0.7)',
                'rgba(107,139,132,0.7)',
                'rgba(178,242,221,0.7)',
                'rgba(88,166,145,0.7)',
                'rgba(200,200,200,0.7)'
            ],
            borderWidth: 1,
            borderRadius: 6
        }]
    },
    options: {
        indexAxis: 'y',
        responsive: true,
        scales: {
            x: {
                beginAtZero: true,
                ticks: { stepSize: 1 }
            }
        },
        plugins: {
            legend: { display: false }
        }
    }
});
</script>
<?php include '../inc/footer.php'; ?>