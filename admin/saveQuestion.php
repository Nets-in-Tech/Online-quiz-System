<?php
include '../includes/session.php';
include '../includes/db.php';

$mode = $_POST['mode'];
$action = $_POST['action']; // "add" or "finish"
$title = $_POST['title'];
$description = $_POST['description'];

$questionTexts = $_POST['question_texts'];
$optionAs = $_POST['option_as'];
$optionBs = $_POST['option_bs'];
$optionCs = $_POST['option_cs'];
$correctAnswers = $_POST['correct_answers'];

if ($mode === 'edit') {
    $quizId = $_POST['quiz_id'];
    $conn->query("UPDATE quizzes SET title='$title', description='$description' WHERE id=$quizId");

    // Simplified: delete old questions and reinsert
    $conn->query("DELETE FROM questions WHERE quiz_id=$quizId");

    foreach ($questionTexts as $i => $qt) {
        if (!empty($qt)) {
            $a = $optionAs[$i];
            $b = $optionBs[$i];
            $c = $optionCs[$i];
            $ans = strtoupper($correctAnswers[$i]);
            $conn->query("INSERT INTO questions (quiz_id, question_text, option_a, option_b, option_c, correct_answer)
                          VALUES ($quizId, '$qt', '$a', '$b', '$c', '$ans')");
        }
    }
} else {
    $conn->query("INSERT INTO quizzes (course_id, title, description) VALUES (1, '$title', '$description')"); 
    // NOTE: course_id hardcoded for now, since course is fixed
    $quizId = $conn->insert_id;

    foreach ($questionTexts as $i => $qt) {
        if (!empty($qt)) {
            $a = $optionAs[$i];
            $b = $optionBs[$i];
            $c = $optionCs[$i];
            $ans = strtoupper($correctAnswers[$i]);
            $conn->query("INSERT INTO questions (quiz_id, question_text, option_a, option_b, option_c, correct_answer)
                          VALUES ($quizId, '$qt', '$a', '$b', '$c', '$ans')");
        }
    }
}

// Redirect logic
if ($action === 'add') {
    // Reload quizEdit with same quiz_id to add more
    header("Location: quizEdit.php?quiz_id=$quizId");
} else {
    // Finish → back to list
    header("Location: qlist.php");
}
exit;
?>
