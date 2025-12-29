<?php
include '../includes/session.php';
include '../includes/db.php';

$quizId = $_GET['quiz_id'] ?? null;
$title = $_GET['title'] ?? null;
$description = $_GET['description'] ?? null;

$quiz = null;
$questions = [];

if ($quizId) {
    // EDIT MODE
    $quizRes = $conn->query("SELECT q.*, c.name AS course_name FROM quizzes q JOIN courses c ON q.course_id=c.id WHERE q.id=$quizId");
    $quiz = $quizRes->fetch_assoc();

    $questionsRes = $conn->query("SELECT * FROM questions WHERE quiz_id=$quizId");
    while ($row = $questionsRes->fetch_assoc()) {
        $questions[] = $row;
    }
} else {
    // CREATE MODE
    $quiz = [
        'title' => $title ?? '',
        'description' => $description ?? '',
        'course_name' => '' // not editable here
    ];
}
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo $quizId ? "Edit Quiz" : "Create Quiz"; ?></title>
    <link rel="stylesheet" href="../style.css">
    <style>
        .form-container { margin:20px; }
        .question-block { border:1px solid #ccc; padding:10px; margin-bottom:10px; }
        .btn { padding:6px 12px; background:#007bff; color:white; border:none; cursor:pointer; margin-right:10px; }
        .btn:hover { background:#0056b3; }
    </style>
</head>
<body>
    
      <h1><?php echo $quizId ? "Edit Quiz" : "Create Quiz"; ?></h1>

    <div>
            <!-- Course shown but not editable -->
            <label>Course:</label>
            <strong><?php echo htmlspecialchars($quiz['course_name']); ?></strong><br><br>

            <label>Quiz Title:</label>
            <input type="text" name="title" value="<?php echo htmlspecialchars($quiz['title']); ?>" required><br><br>

            <label>Description:</label>
            <textarea name="description"><?php echo htmlspecialchars($quiz['description']); ?></textarea><br><br>

            <h3>Questions</h3>
            <?php foreach ($questions as $q): ?>
                <div class="question-block">
                    <input type="hidden" name="question_ids[]" value="<?php echo $q['id']; ?>">
                    <label>Question:</label>
                    <input type="text" name="question_texts[]" value="<?php echo htmlspecialchars($q['question_text']); ?>" required><br>
                    <label>Option A:</label>
                    <input type="text" name="option_as[]" value="<?php echo htmlspecialchars($q['option_a']); ?>"><br>
                    <label>Option B:</label>
                    <input type="text" name="option_bs[]" value="<?php echo htmlspecialchars($q['option_b']); ?>"><br>
                    <label>Option C:</label>
                    <input type="text" name="option_cs[]" value="<?php echo htmlspecialchars($q['option_c']); ?>"><br>
                    <label>Correct Answer (A/B/C):</label>
                    <input type="text" name="correct_answers[]" value="<?php echo htmlspecialchars($q['correct_answer']); ?>" maxlength="1"><br>
                </div>
            <?php endforeach; ?>
    </div>
</body>
</html>
