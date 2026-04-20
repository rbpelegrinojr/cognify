CREATE DATABASE IF NOT EXISTS cognify_db;
USE cognify_db;

DROP TABLE IF EXISTS quiz_answers;
DROP TABLE IF EXISTS quizzes;
DROP TABLE IF EXISTS question_choices;
DROP TABLE IF EXISTS questions;
DROP TABLE IF EXISTS categories;
DROP TABLE IF EXISTS settings;
DROP TABLE IF EXISTS students;
DROP TABLE IF EXISTS admins;

CREATE TABLE admins (
    admin_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(150) NOT NULL,
    username VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE students (
    student_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    student_no VARCHAR(100) NOT NULL UNIQUE,
    full_name VARCHAR(150) NOT NULL,
    email VARCHAR(150) DEFAULT '',
    password_hash VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE settings (
    setting_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(100) NOT NULL UNIQUE,
    setting_value VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE categories (
    category_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE questions (
    question_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    question_text TEXT NOT NULL,
    question_image VARCHAR(255) DEFAULT '',
    image_label VARCHAR(255) DEFAULT '',
    created_at DATETIME DEFAULT NULL,
    CONSTRAINT fk_questions_category FOREIGN KEY (category_id) REFERENCES categories(category_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE question_choices (
    choice_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    question_id INT NOT NULL,
    choice_text TEXT NOT NULL,
    is_correct TINYINT(1) NOT NULL DEFAULT 0,
    sort_order INT NOT NULL DEFAULT 1,
    CONSTRAINT fk_choices_question FOREIGN KEY (question_id) REFERENCES questions(question_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE quizzes (
    quiz_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    total_questions INT NOT NULL DEFAULT 0,
    score INT NOT NULL DEFAULT 0,
    top1_intelligence VARCHAR(255) NOT NULL,
    top2_intelligence VARCHAR(255) NOT NULL,
    top3_intelligence VARCHAR(255) NOT NULL,
    taken_at DATETIME DEFAULT NULL,
    CONSTRAINT fk_quiz_student FOREIGN KEY (student_id) REFERENCES students(student_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE quiz_answers (
    answer_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    quiz_id INT NOT NULL,
    question_id INT NOT NULL,
    selected_choice_id INT NOT NULL DEFAULT 0,
    correct_choice_id INT NOT NULL DEFAULT 0,
    is_correct TINYINT(1) NOT NULL DEFAULT 0,
    CONSTRAINT fk_qa_quiz FOREIGN KEY (quiz_id) REFERENCES quizzes(quiz_id) ON DELETE CASCADE,
    CONSTRAINT fk_qa_question FOREIGN KEY (question_id) REFERENCES questions(question_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO admins (full_name, username, password_hash) VALUES
('System Administrator', 'admin', '$2y$12$VtAcd/FYpAJUvYoS5ZP9VeY.NM1s2vTUifBOmK/CFK9jiwALNm4pu');

INSERT INTO settings (setting_key, setting_value) VALUES
('quiz_question_limit', '30');

INSERT INTO categories (name) VALUES
('Remember'),
('Understand'),
('Apply'),
('Analyze'),
('Evaluate'),
('Create');

/*
Default admin password:
username: admin
password: admin123
*/
