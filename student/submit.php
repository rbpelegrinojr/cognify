<?php
require_once '../config.php';
require_once 'auth_student.php';
require_post();

$question_ids = isset($_POST['question_ids']) ? $_POST['question_ids'] : array();
$answers = isset($_POST['answer']) ? $_POST['answer'] : array();

if (count($question_ids) <= 0) {
    set_flash('danger', 'No quiz items found.');
    redirect_to('dashboard.php');
}

$student_id = intval($_SESSION['student_id']);
$total_questions = count($question_ids);
$score = 0;

mysqli_query($con, "INSERT INTO quizzes (student_id, total_questions, score, top1_intelligence, top2_intelligence, top3_intelligence, taken_at)
                    VALUES ($student_id, $total_questions, 0, '', '', '', NOW())");
$quiz_id = mysqli_insert_id($con);

$category_scores = array();

for ($i = 0; $i < count($question_ids); $i++) {
    $question_id = intval($question_ids[$i]);
    $selected_choice_id = isset($answers[$question_id]) ? intval($answers[$question_id]) : 0;

    $q_res = mysqli_query($con, "SELECT q.question_id, cat.name AS category_name
                                 FROM questions q
                                 INNER JOIN categories cat ON cat.category_id = q.category_id
                                 WHERE q.question_id = $question_id LIMIT 1");
    $q_row = mysqli_fetch_assoc($q_res);
    $category_name = $q_row['category_name'];

    if (!isset($category_scores[$category_name])) {
        $category_scores[$category_name] = array('correct' => 0, 'total' => 0);
    }
    $category_scores[$category_name]['total']++;

    $correct_res = mysqli_query($con, "SELECT choice_id FROM question_choices WHERE question_id = $question_id AND is_correct = 1 LIMIT 1");
    $correct_row = mysqli_fetch_assoc($correct_res);
    $correct_choice_id = intval($correct_row['choice_id']);
    $is_correct = ($selected_choice_id === $correct_choice_id) ? 1 : 0;

    if ($is_correct === 1) {
        $score++;
        $category_scores[$category_name]['correct']++;
    }

    mysqli_query($con, "INSERT INTO quiz_answers (quiz_id, question_id, selected_choice_id, correct_choice_id, is_correct)
                        VALUES ($quiz_id, $question_id, $selected_choice_id, $correct_choice_id, $is_correct)");
}

$intelligence_totals = analyze_top_intelligences($category_scores);
$keys = array_keys($intelligence_totals);

$top1 = isset($keys[0]) ? $keys[0] : 'No dominant intelligence found';
$top2 = isset($keys[1]) ? $keys[1] : 'No second intelligence found';
$top3 = isset($keys[2]) ? $keys[2] : 'No third intelligence found';

mysqli_query($con, "UPDATE quizzes SET
                    score = $score,
                    top1_intelligence = '" . mysqli_real_escape_string($con, $top1) . "',
                    top2_intelligence = '" . mysqli_real_escape_string($con, $top2) . "',
                    top3_intelligence = '" . mysqli_real_escape_string($con, $top3) . "'
                    WHERE quiz_id = $quiz_id");

set_flash('success', 'Quiz submitted successfully.');
redirect_to('result.php?quiz_id=' . $quiz_id);
?>