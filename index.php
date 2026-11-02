

<?php
require_once 'db.php';

// Retrieve movie review statistics
$stats = $pdo->query(
    "SELECT
        COUNT(*) AS total_reviews,
        ROUND(AVG(rating), 1) AS average_rating
     FROM reviews"
)->fetch(PDO::FETCH_ASSOC);

include 'header.php';
?>



<div class="stats-container">

    <div class="stat-card">
        <h3>Total Reviews</h3>
        <p>
            <?php echo (int)$stats['total_reviews']; ?>
        </p>
    </div>

    <div class="stat-card">
        <h3>Average Rating</h3>
        <p>
            <?php
            echo $stats['average_rating'] !== null
                ? number_format((float)$stats['average_rating'], 1) . '/5'
                : 'N/A';
            ?>
        </p>
    </div>

</div>







<h2>Submit a Movie Review</h2>

<?php if (isset($_GET['success'])): ?>
    <p style="color: green;">
        Your review was saved successfully!
    </p>
<?php endif; ?>

<form action="save_review.php" method="POST">

    <label>Your Name:</label><br>
    <input type="text" name="reviewer_name"
           maxlength="80" required><br><br>

    <label>Movie Title:</label><br>
    <input type="text" name="movie_title"
           maxlength="120" required><br><br>

    <label>Movie Rating:</label><br>
    <select name="rating" required>
        <option value="">Select Rating</option>
        <option value="1">1 Star</option>
        <option value="2">2 Stars</option>
        <option value="3">3 Stars</option>
        <option value="4">4 Stars</option>
        <option value="5">5 Stars</option>
    </select><br><br>

    <label>Write Your Review:</label><br>
    <textarea name="comments"
              maxlength="1000" required></textarea><br><br>

    <button type="submit">Submit Review</button>

</form>

<hr>

<h2>Recent Movie Reviews</h2>

<?php
$stmt = $pdo->query(
    "SELECT * FROM reviews ORDER BY review_id DESC"
);

$reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (count($reviews) === 0) {
    echo "<p>No reviews yet. Be the first to submit one!</p>";
}

foreach ($reviews as $row) {

    echo '<div class="review-card">';

    echo "<h3>" .
        htmlspecialchars($row['movie_title'], ENT_QUOTES, 'UTF-8') .
        "</h3>";

    echo "<p><strong>Reviewed by:</strong> " .
        htmlspecialchars($row['reviewer_name'], ENT_QUOTES, 'UTF-8') .
        "</p>";

    echo "<p><strong>Rating:</strong> " .
        (int)$row['rating'] . "/5</p>";

    echo "<p>" .
        nl2br(htmlspecialchars($row['comments'], ENT_QUOTES, 'UTF-8')) .
        "</p>";

    echo '</div>';
}
?>

<?php include 'footer.php'; ?>
