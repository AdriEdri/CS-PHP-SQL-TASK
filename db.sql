CREATE DATABASE reviews_db;

USE reviews_db;

CREATE TABLE reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,        -- Unique identifier for each review
    name VARCHAR(255) NOT NULL,               -- User's name
    email VARCHAR(255) NOT NULL,              -- User's email
    review TEXT NOT NULL,                     -- The review content
    rating INT NOT NULL CHECK (rating BETWEEN 1 AND 5), -- Rating between 1 and 5
    submission_date DATETIME DEFAULT CURRENT_TIMESTAMP -- Automatic timestamp
);
