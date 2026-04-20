<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function esc($value) {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function redirect_to($url) {
    header("Location: " . $url);
    exit;
}

function set_flash($type, $message) {
    $_SESSION['flash'] = array(
        'type' => $type,
        'message' => $message
    );
}

function show_flash() {
    if (!empty($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        $class = 'alert-success';
        if ($flash['type'] === 'danger') {
            $class = 'alert-danger';
        } elseif ($flash['type'] === 'warning') {
            $class = 'alert-warning';
        }
        echo '<div class="alert ' . $class . '">' . esc($flash['message']) . '</div>';
        unset($_SESSION['flash']);
    }
}

function get_setting($con, $key, $default_value) {
    $key = mysqli_real_escape_string($con, $key);
    $sql = "SELECT setting_value FROM settings WHERE setting_key = '$key' LIMIT 1";
    $res = mysqli_query($con, $sql);
    if ($res && mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);
        return $row['setting_value'];
    }
    return $default_value;
}

function category_order_case() {
    return "CASE name
        WHEN 'Remember' THEN 1
        WHEN 'Understand' THEN 2
        WHEN 'Apply' THEN 3
        WHEN 'Analyze' THEN 4
        WHEN 'Evaluate' THEN 5
        WHEN 'Create' THEN 6
        ELSE 99 END";
}

function question_category_order_case() {
    return "CASE cat.name
        WHEN 'Remember' THEN 1
        WHEN 'Understand' THEN 2
        WHEN 'Apply' THEN 3
        WHEN 'Analyze' THEN 4
        WHEN 'Evaluate' THEN 5
        WHEN 'Create' THEN 6
        ELSE 99 END";
}

function analyze_top_intelligences($category_scores) {
    $map = array(
        'Remember' => array('Verbal–Linguistic Intelligence', 'Logical–Mathematical Intelligence'),
        'Understand' => array('Interpersonal Intelligence', 'Verbal–Linguistic Intelligence'),
        'Apply' => array('Bodily–Kinesthetic Intelligence', 'Spatial Intelligence'),
        'Analyze' => array('Logical–Mathematical Intelligence', 'Spatial Intelligence', 'Intrapersonal Intelligence'),
        'Evaluate' => array('Logical–Mathematical Intelligence', 'Verbal–Linguistic Intelligence', 'Intrapersonal Intelligence', 'Interpersonal Intelligence'),
        'Create' => array('Bodily–Kinesthetic Intelligence', 'Logical–Mathematical Intelligence', 'Spatial Intelligence')
    );

    $totals = array();
    foreach ($category_scores as $category_name => $data) {
        $total = intval($data['total']);
        $correct = intval($data['correct']);
        if ($total <= 0) {
            continue;
        }
        $percent = ($correct / $total) * 100;
        if (!empty($map[$category_name])) {
            foreach ($map[$category_name] as $intelligence) {
                if (!isset($totals[$intelligence])) {
                    $totals[$intelligence] = 0;
                }
                $totals[$intelligence] += $percent;
            }
        }
    }
    arsort($totals);
    return $totals;
}

function upload_question_image($file_input_name) {
    if (empty($_FILES[$file_input_name]['name'])) {
        return '';
    }
    $allowed = array('jpg', 'jpeg', 'png', 'gif', 'webp');
    $name = $_FILES[$file_input_name]['name'];
    $tmp = $_FILES[$file_input_name]['tmp_name'];
    $error = $_FILES[$file_input_name]['error'];

    if ($error !== 0) {
        return '';
    }

    $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
    if (!in_array($ext, $allowed)) {
        return '';
    }

    $new_name = 'q_' . time() . '_' . mt_rand(1000, 9999) . '.' . $ext;
    $target = dirname(__FILE__) . '/uploads/questions/' . $new_name;

    if (move_uploaded_file($tmp, $target)) {
        return 'uploads/questions/' . $new_name;
    }
    return '';
}

function require_post() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        redirect_to('../index.php');
    }
}
?>