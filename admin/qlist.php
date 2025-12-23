<?php
include '../includes/session.php';
include '../includes/db.php';

// Fetch quizzes with course names
$result = $conn->query("
    SELECT q.id, q.title, q.description, c.name AS course_name
    FROM quizzes q
    JOIN courses c ON q.course_id = c.id
");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin - Quiz List</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        .quiz-list { margin:20px; }
        .quiz-item { border:1px solid #ccc; padding:10px; margin-bottom:10px; display:flex; justify-content:space-between; }
        .btn { padding:6px 12px; background:#007bff; color:white; border:none; cursor:pointer; }
        .btn:hover { background:#0056b3; }
        /* Popup modal */
        .modal { display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.6); justify-content:center; align-items:center; }
        .modal-content { background:white; padding:20px; border-radius:8px; width:400px; }
        .close { float:right; cursor:pointer; font-size:20px; }
    </style>
</head>
<body>
    <h1>Quiz Management</h1>

    <button class="btn" onclick="openModal()">Create Quiz</button>

    <div class="quiz-list">
        <?php while($row = $result->fetch_assoc()): ?>
            <div class="quiz-item">
                <div>
                    <strong><?php echo $row['title']; ?></strong><br>
                    <em><?php echo $row['course_name']; ?></em><br>
                    <?php if (!empty($row['description'])) echo $row['description']; ?>
                </div>
                <div>
                    <a href="quizEdit.php?quiz_id=<?php echo $row['id']; ?>" class="btn">Edit</a>
                </div>
            </div>
        <?php endwhile; ?>
    </div>

<!-- Modal for Create Quiz -->
<div id="quizModal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeModal()">&times;</span>
    <h2>Create Quiz</h2>
    <form id="createQuizForm" method="get" action="quizEdit.php">
        <label>Quiz Title:</label>
        <input type="text" name="title" required><br><br>

        <label>Description:</label>
        <textarea name="description"></textarea><br><br>

        <button type="submit" class="btn">Continue</button>
    </form>
  </div>
</div>


    <script>
        function openModal() {
            document.getElementById("quizModal").style.display = "flex";
        }
        function closeModal() {
            document.getElementById("quizModal").style.display = "none";
        }
    </script>
</body>
</html>
