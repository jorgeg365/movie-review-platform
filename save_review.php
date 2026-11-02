<?php
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.php");
    exit();
}

$name = trim($_POST['reviewer_name'] ?? '');
$movie = trim($_POST['movie_title'] ?? '');
$rating = filter_var(
    $_POST['rating'] ?? null,
    FILTER_VALIDATE_INT
);
$comments = trim($_POST['comments'] ?? '');

if (
    $name === '' ||
    $movie === '' ||
    $comments === '' ||
    strlen($name) > 80 ||
    strlen($movie) > 120 ||
    strlen($comments) > 1000 ||
    $rating === false ||
    $rating < 1 ||
    $rating > 5
) {
    exit("Invalid form data. Please go back and try again.");
}

try {
    $sql = "INSERT INTO reviews
            (reviewer_name, movie_title, rating, comments)
            VALUES (?, ?, ?, ?)";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        $name,
        $movie,
        $rating,
        $comments
    ]);

    header("Location: index.php?success=1");
    exit();

} catch (PDOException $e) {
    error_log($e->getMessage());
    exit("Unable to save your review.");
}
?>
