
CREATE DATABASE IF NOT EXISTS movie_review_platform;

USE movie_review_platform;

CREATE TABLE IF NOT EXISTS reviews (
    review_id INT AUTO_INCREMENT PRIMARY KEY,
    reviewer_name VARCHAR(80) NOT NULL,
    movie_title VARCHAR(120) NOT NULL,
    rating INT NOT NULL,
    comments TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
