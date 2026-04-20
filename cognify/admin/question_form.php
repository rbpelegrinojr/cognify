<?php
require_once '../config.php';
require_once 'auth_admin.php';

$question_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$editing = false;
$question = array(
    'category_id' => '',
    'question_text' => '',
    'question_image' => '',
    'image_label' => ''
);
$choices = array();

if ($question_id > 0) {
    $editing = true;
    $res = mysqli_query($con, "SELECT * FROM questions WHERE question_id = $question_id LIMIT 1");
    if ($res && mysqli_num_rows($res) > 0) {
        $question = mysqli_fetch_assoc($res);
        $c_res = mysqli_query($con, "SELECT * FROM question_choices WHERE question_id = $question_id ORDER BY sort_order ASC, choice_id ASC");
        while ($c_row = mysqli_fetch_assoc($c_res)) {
            $choices[] = $c_row;
        }
    } else {
        set_flash('danger', 'Question not found.');
        redirect_to('questions.php');
    }
}

if (empty($choices)) {
    $choices[] = array('choice_text' => '', 'is_correct' => 1, 'sort_order' => 1);
    $choices[] = array('choice_text' => '', 'is_correct' => 0, 'sort_order' => 2);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category_id = intval($_POST['category_id']);
    $question_text = mysqli_real_escape_string($con, trim($_POST['question_text']));
    $image_label = mysqli_real_escape_string($con, trim($_POST['image_label']));
    $existing_image = trim($_POST['existing_image']);

    $choice_texts = isset($_POST['choice_text']) ? $_POST['choice_text'] : array();
    $correct_choice = isset($_POST['correct_choice']) ? intval($_POST['correct_choice']) : -1;

    if ($category_id <= 0 || $question_text === '') {
        set_flash('danger', 'Category and question text are required.');
        redirect_to($editing ? 'question_form.php?id=' . $question_id : 'question_form.php');
    }

    $saved_image = upload_question_image('question_image');
    if ($saved_image === '') {
        $saved_image = $existing_image;
    }

    if ($saved_image !== '' && $image_label === '') {
        set_flash('danger', 'Image description label is required when an image is uploaded.');
        redirect_to($editing ? 'question_form.php?id=' . $question_id : 'question_form.php');
    }

    if ($editing) {
        $sql = "UPDATE questions SET
                category_id = $category_id,
                question_text = '$question_text',
                question_image = '" . mysqli_real_escape_string($con, $saved_image) . "',
                image_label = '$image_label'
                WHERE question_id = $question_id";
        mysqli_query($con, $sql);
        mysqli_query($con, "DELETE FROM question_choices WHERE question_id = $question_id");
    } else {
        $sql = "INSERT INTO questions (category_id, question_text, question_image, image_label, created_at)
                VALUES ($category_id, '$question_text', '" . mysqli_real_escape_string($con, $saved_image) . "', '$image_label', NOW())";
        mysqli_query($con, $sql);
        $question_id = mysqli_insert_id($con);
    }

    $inserted = 0;
    for ($i = 0; $i < count($choice_texts); $i++) {
        $choice = trim($choice_texts[$i]);
        if ($choice === '') {
            continue;
        }
        $choice_sql = mysqli_real_escape_string($con, $choice);
        $is_correct = ($i === $correct_choice) ? 1 : 0;
        $sort_order = $i + 1;
        mysqli_query($con, "INSERT INTO question_choices (question_id, choice_text, is_correct, sort_order)
                            VALUES ($question_id, '$choice_sql', $is_correct, $sort_order)");
        $inserted++;
    }

    if ($inserted < 2) {
        set_flash('warning', 'Question saved, but it should have at least 2 choices.');
    } else {
        set_flash('success', 'Question saved successfully.');
    }
    redirect_to('questions.php');
}

$cat_res = mysqli_query($con, "SELECT * FROM categories ORDER BY " . category_order_case() . " ASC");

$page_title = $editing ? 'Edit Question' : 'Add Question';
$asset_prefix = '../';
$nav_links = array(
    array('url' => 'dashboard.php', 'label' => 'Dashboard'),
    array('url' => 'questions.php', 'label' => 'Questions'),
    array('url' => 'logout.php', 'label' => 'Logout')
);
include '../inc/header.php';
?>
<div class="card">
    <h2 class="mt-0"><?php echo $editing ? 'Edit Question' : 'Create Question'; ?></h2>
    <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="existing_image" value="<?php echo esc($question['question_image']); ?>">
        <div class="grid grid-2">
            <div>
                <div class="form-group">
                    <label>Category</label>
                    <select name="category_id" required>
                        <option value="">Select category</option>
                        <?php while ($cat = mysqli_fetch_assoc($cat_res)) { ?>
                            <option value="<?php echo intval($cat['category_id']); ?>" <?php echo intval($question['category_id']) === intval($cat['category_id']) ? 'selected' : ''; ?>>
                                <?php echo esc($cat['name']); ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Question Text</label>
                    <textarea name="question_text" required><?php echo esc($question['question_text']); ?></textarea>
                </div>
            </div>

            <div>
                <div class="form-group">
                    <label>Question Image (optional)</label>
                    <input type="file" name="question_image" accept="image/*">
                    <?php if ($question['question_image'] != '') { ?>
                        <img class="question-image" src="../<?php echo esc($question['question_image']); ?>" alt="">
                    <?php } ?>
                </div>

                <div class="form-group">
                    <label>Image Description Label <span class="muted">(Important)</span></label>
                    <input type="text" name="image_label" value="<?php echo esc($question['image_label']); ?>" placeholder="Example: Figure 1 - Sequence diagram of the task">
                </div>
            </div>
        </div>

        <div class="card" style="background:#fbfffd">
            <div class="flex-between">
                <h3 class="mt-0 mb-0">Dynamic Choices</h3>
                <button class="btn btn-light" type="button" id="addChoiceBtn">Add Choice</button>
            </div>
            <p class="muted">Choices remain radio selection for students. Mark exactly one correct answer.</p>
            <div id="choiceWrap">
                <?php foreach ($choices as $index => $choice) { ?>
                    <div class="choice-row">
                        <input type="radio" name="correct_choice" value="<?php echo $index; ?>" <?php echo intval($choice['is_correct']) === 1 ? 'checked' : ''; ?>>
                        <input type="text" name="choice_text[]" value="<?php echo esc($choice['choice_text']); ?>" placeholder="Choice text">
                        <button class="btn btn-danger remove-choice" type="button">Remove</button>
                    </div>
                <?php } ?>
            </div>
        </div>

        <div class="mt-2">
            <button class="btn" type="submit">Save Question</button>
            <a class="btn btn-light" href="questions.php">Cancel</a>
        </div>
    </form>
</div>

<script src="../assets/js/admin-question-form.js"></script>
<?php include '../inc/footer.php'; ?>