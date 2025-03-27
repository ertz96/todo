
CREATE DATABASE todo_list;
USE todo_list;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    task_name VARCHAR(255) NOT NULL,
    user_id INT NOT NULL,
    status TINYINT(1) DEFAULT 0, -- 0 für "falsch" (offen), 1 für "wahr" (erledigt)
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
