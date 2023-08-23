<?php
$servername = "localhost";
$username = "root";
$password = "sunsun55";
$dbname = "mdb";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $quizName = $_POST['quizName'];
    $subject = $_POST['Subject'];
    $questions = $_POST['question'];
    $answers = $_POST['answer'];

    $sql = "INSERT INTO quizzes (quiz_name, subject) VALUES ('$quizName', '$subject')";
    $conn->query($sql);

    $quizId = $conn->insert_id;

    foreach ($questions as $index => $question) {

        $sql = "INSERT INTO quiz_questions (quiz_id, question) VALUES ('$quizId', '$question')";
        $conn->query($sql);

        $questionId = $conn->insert_id;

        foreach ($answers[$index] as $answer) {
            $sql = "INSERT INTO quiz_answers (question_id, answer) VALUES ('$questionId', '$answer')";
            $conn->query($sql);
        }
    }

    $conn->close();

    // Redirect to success page
    header("Location: success.php");
    exit();
}
?>
