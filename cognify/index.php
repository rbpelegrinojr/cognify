<?php
require_once 'config.php';
$page_title = 'Cognify Home';
$nav_links = array(
    array('url' => 'admin/login.php', 'label' => 'Admin Login'),
    array('url' => 'student/login.php', 'label' => 'Student Login'),
    array('url' => 'student/register.php', 'label' => 'Student Register')
);
include 'inc/header.php';
?>
<div class="hero">
    <div class="grid grid-2">
        <div class="card">
            <h1 class="mt-0">Bloom-Based Cognitive Assessment</h1>
            <p class="muted">Questions are organized in this order: Remember, Understand, Apply, Analyze, Evaluate, and Create. The quiz automatically follows that sequence for students.</p>
            <div class="flex">
                <a class="btn" href="student/register.php">Start as Student</a>
                <a class="btn btn-light" href="admin/login.php">Manage as Admin</a>
            </div>
        </div>
        <div class="card">
            <h3 class="mt-0">Major Updated Rules</h3>
            <ul class="list-clean">
                <li>Dynamic radio choices per question</li>
                <li>Question image upload with required image description label</li>
                <li>No difficulty level</li>
                <li>No problem-solving criteria and rubrics</li>
                <li>Admin controls total questions shown to students</li>
                <li>Results automatically determine the top 3 intelligence strengths</li>
            </ul>
        </div>
    </div>
</div>
<?php include 'inc/footer.php'; ?>