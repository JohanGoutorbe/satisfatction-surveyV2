CREATE TABLE client_satisfaction (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    inter INT(10) UNSIGNED NOT NULL,
    tech VARCHAR(50) NOT NULL,
    choice TINYINT UNSIGNED NOT NULL,
    survey_date VARCHAR(10) NOT NULL,
    inter_date VARCHAR(10) NOT NULL,
    email VARCHAR(100) NOT NULL
)

INSERT INTO client_satisfaction (inter, tech, choice, survey_date, inter_date) VALUES (123456, "goutorbe", 5, "23/01/2023", "20/01/2023", "johan@officecenter.fr")