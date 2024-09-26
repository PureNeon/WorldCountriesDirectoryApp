DROP DATABASE IF EXISTS countries_lab_work;
CREATE DATABASE countries_lab_work;
USE countries_lab_work;
CREATE TABLE countries_t (
	id INT NOT NULL AUTO_INCREMENT,
    short_name NVARCHAR(50) NOT NULL UNIQUE,
    full_name NVARCHAR(200) NOT NULL UNIQUE,
    iso_alpha_2 CHAR(2) NOT NULL UNIQUE,
    iso_alpha_3 CHAR(3) NOT NULL UNIQUE,
    iso_numeric char(3) NOT NULL UNIQUE,
    human_population INT NOT NULL,
    country_square INT NOT NULL,
    --
    PRIMARY KEY(id)
);