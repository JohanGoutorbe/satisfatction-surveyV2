CREATE TABLE client_satisfaction (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    inter TINYINT NOT NULL,
    tech VARCHAR(50) NOT NULL,
    choice TINYINT UNSIGNED NOT NULL,
    survey_date VARCHAR(10) NOT NULL,
    inter_date VARCHAR(10) NOT NULL
)