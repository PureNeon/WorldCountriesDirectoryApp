USE countries_lab_work;
TRUNCATE TABLE countries_t;
INSERT INTO countries_t (
	short_name, 
    full_name, 
    iso_alpha_2, 
    iso_alpha_3, 
    iso_numeric,
    human_population,
    country_square
) VALUES 
	('Россия', 'Российская федерация', 'RU', 'RUS', 643, 146150179, 17125191),
    ('США', 'Соединённые штаты Америки', 'US', 'USA', 840, 333287557, 9833517),
    ('Британия', 'Соединённое Королевство Великобритании и Северной Ирландии', 'GB', 'GBR', 336, 66971411, 242495),
    ('Китай', 'Китайская народная республика', 'CN', 'CHN', 156, 1411750000, 9598962),
    ('Германия', 'Федеративная Республика Германия', 'DE', 'DEU', 276, 84358845, 357596);
SELECT * FROM countries_t;