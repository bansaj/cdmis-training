CREATE TABLE district (
  id int NOT NULL AUTO_INCREMENT,
  title varchar(255) NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE municipality (
    id int NOT NULL AUTO_INCREMENT,
    title varchar(255) NOT NULL,
    district_id int not NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (district_id) REFERENCES district(id)
);

CREATE TABLE ward (
  id int NOT NULL AUTO_INCREMENT,
  title varchar(255) NOT NULL,
  municipality_id int not NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (municipality_id) REFERENCES municipality(id)
);

CREATE TABLE statistics (
  id int NOT NULL AUTO_INCREMENT,
  population bigint,
  male_population bigint,
  female_population bigint,
  ward_id int not null,
  PRIMARY KEY (id),
  FOREIGN KEY (ward_id) REFERENCES ward(id)
);
