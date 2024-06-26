CREATE DATABASE dbstorage21360859034;
USE dbstorage21360859034;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE serra (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    plants TEXT NOT NULL,
    conditions TEXT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id)
);