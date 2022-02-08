
-- ============== COVID VACCINE DATABASE GENERATION: A3 ==============

-- Drop the database then create it, useful if re-running script
drop database covidDB;
create database covidDB;


-- Regular entities
CREATE TABLE Pharmaceutical_company(
  Name CHAR(40) NOT NULL,
  Street_number INTEGER NOT NULL,
  Street_name CHAR(40) NOT NULL,
  Postal_code VARCHAR(7),
  City CHAR(40) NOT NULL,
  PRIMARY KEY(Name)
);

CREATE TABLE Vaccine_site(
  Name CHAR(40) NOT NULL,
  Street_number INTEGER NOT NULL,
  Street_name CHAR(40) NOT NULL,
  Postal_code VARCHAR(7),
  City CHAR(40) NOT NULL,
  PRIMARY KEY(Name)
);

CREATE TABLE Vaccine_lot(
  Lot_number VARCHAR(40) NOT NULL,
  Number_doses INTEGER NOT NULL,
  Production_date DATE NOT NULL,
  Expiry_date DATE NOT NULL,
  Producer_name CHAR(40) NOT NULL, -- added due to 1:N 'produce' relationship
  Site_name CHAR(40) NOT NULL, -- added due to 1:N 'ships to' relationship
  PRIMARY KEY(Lot_number),
  FOREIGN KEY(Site_name) REFERENCES Vaccine_site(Name),
  FOREIGN KEY(Producer_name) REFERENCES Pharmaceutical_company(Name)
);

CREATE TABLE Patient(
  First_name CHAR(40) NOT NULL,
  Last_name CHAR(40) NOT NULL,
  OHIP_Number VARCHAR(40) NOT NULL,
  Birthdate DATE NOT NULL,
  PRIMARY KEY(OHIP_Number)
);


-- Specialized entities
CREATE TABLE Doctor(
  Unique_ID VARCHAR(40) NOT NULL,
  -- credential listed below
  First_name CHAR(40) NOT NULL,
  Last_name CHAR(40) NOT NULL,
  PRIMARY KEY(Unique_ID)
);

CREATE TABLE Nurse(
  Unique_ID VARCHAR(40) NOT NULL,
  -- credential listed below
  First_name CHAR(40) NOT NULL,
  Last_name CHAR(40) NOT NULL,
  PRIMARY KEY(Unique_ID)
);


-- Weak entities, must come after parent entities
CREATE TABLE Spouse(
  Phone_number VARCHAR(40) NOT NULL,
  OHIP_Number VARCHAR(40) NOT NULL,
  First_name CHAR(40) NOT NULL,
  Last_name CHAR(40) NOT NULL,
  Partner_OHIP VARCHAR(40) NOT NULL,
  PRIMARY KEY(OHIP_Number, Partner_OHIP),
  FOREIGN KEY(Partner_OHIP) REFERENCES Patient(OHIP_Number)
  ON DELETE CASCADE -- if the patient is deleted, so should the spouse
);

CREATE TABLE Medical_practice(
  Phone_number VARCHAR(40) NOT NULL,
  Name CHAR(40) NOT NULL,
  Doctor_ID VARCHAR(40) NOT NULL,
  PRIMARY KEY(Phone_number, Doctor_ID),
  FOREIGN KEY(Doctor_ID) REFERENCES Doctor(Unique_ID)
  ON DELETE CASCADE -- delete where a doctor works if doctor entry is removed
);


-- 1:N Relationships: "produce", "ships to"


-- Many-to-many relationships
CREATE TABLE Nurse_staffs(
  Nurse_ID VARCHAR(40) NOT NULL,
  Vaccine_site_name CHAR(40) NOT NULL,
  PRIMARY KEY(Nurse_ID, Vaccine_site_name),
  FOREIGN KEY(Nurse_ID) REFERENCES Nurse(Unique_ID)
  ON DELETE CASCADE, -- if the nurse is removed, so should the staffing info
  FOREIGN KEY(Vaccine_site_name) REFERENCES Vaccine_site(Name)
);

CREATE TABLE Doctor_staffs(
  Doctor_ID VARCHAR(40) NOT NULL,
  Vaccine_site_name CHAR(40) NOT NULL,
  PRIMARY KEY(Doctor_ID, Vaccine_site_name),
  FOREIGN KEY(Doctor_ID) REFERENCES Doctor(Unique_ID)
  ON DELETE CASCADE, -- if the doctor is removed, so should the staffing info
  FOREIGN KEY(Vaccine_site_name) REFERENCES Vaccine_site(Name)
);


-- Multi-valued attributes
CREATE TABLE Site_operating_dates(
  Operating_date DATE NOT NULL,
  Site_name CHAR(40) NOT NULL,
  PRIMARY KEY(Operating_date, Site_name),
  FOREIGN KEY(Site_name) REFERENCES Vaccine_site(Name)
  ON DELETE CASCADE -- if a site is no longer operating, delete its info
);

CREATE TABLE Doctor_credentials(
  Credential VARCHAR(40) NOT NULL,
  Doctor_ID VARCHAR(40) NOT NULL,
  PRIMARY KEY(Credential, Doctor_ID),
  FOREIGN KEY(Doctor_ID) REFERENCES Doctor(Unique_ID)
  ON DELETE CASCADE -- if a doctor no longer exists, nor do their credentials
);

CREATE TABLE Nurse_credentials(
  Credential VARCHAR(40) NOT NULL,
  Nurse_ID VARCHAR(40) NOT NULL,
  PRIMARY KEY(Credential, Nurse_ID),
  FOREIGN KEY(Nurse_ID) REFERENCES Nurse(Unique_ID)
  ON DELETE CASCADE -- if a nurse no longer exists, nor do their credentials
);


-- Ternary relationships (recieves vaccine)
CREATE TABLE Recieves_vaccine(
  Lot_number VARCHAR(40) NOT NULL,
  Vaccine_site_name CHAR(40) NOT NULL,
  Patient_OHIP VARCHAR(40) NOT NULL,
  Vaccination_date DATE NOT NULL,
  Vaccination_time TIME NOT NULL,
  PRIMARY KEY(Lot_number, Vaccine_site_name, Patient_OHIP),
  FOREIGN KEY(Lot_number) REFERENCES Vaccine_lot(Lot_number),
  FOREIGN KEY(Vaccine_site_name) REFERENCES Vaccine_site(Name),
  FOREIGN KEY(Patient_OHIP) REFERENCES Patient(OHIP_Number)
  ON DELETE CASCADE -- if a patient is removed, so should the vaccine records
);


-- Example insertions
insert into Pharmaceutical_company values
  ('Janssen', 19, 'Green Belt Dr', 'M3C1L9', 'North York'),
  ('Pfizer', 17300, 'Trans-Canada Highway', 'H9J2M5', 'Kirkland'),
  ('Astra-Zeneca', 1004, 'Middlegate Rd', 'L4Y1M4', 'Mississauga'),
  ('Moderna', 200, 'Tech Square', '02139', 'Cambridge');

insert into Vaccine_site values
  ('Yorkdale Mall', 3169, 'Jarvis St', 'A2W 3P7', 'Ottawa'),
  ('RevPharma', 3700, 'Grand boulevard', 'L7D 4L2', 'Perth'),
  ('Etobicoke Site', 4142, 'Dundas St', 'X6R 8P4', 'Ajax'),
  ('Shoppers Drugmart', 7028, 'Dundas St', 'L0G 2U0', 'Mississauga'),
  ('Gerrard Square Mall', 2181, 'Bath road', 'Z3I 3M4', 'Etobicoke'),
  ('Mississauga Site', 7442, 'Sherbourne St', 'M5V 9I3', 'Toronto'),
  ('North York', 3105, 'Bath road', 'K8Y 0G1', 'PEI'),
  ('Rexall', 5352, 'Gerrard St', 'K8Y 3A3', 'Mississauga');

insert into Vaccine_lot values
  ('CWYSP6ZDAK', 1, '2021-03-08', '2023-02-22', 'Moderna', 'Yorkdale Mall'),
  ('QB6C2GMF1G', 2, '2021-06-11', '2023-02-22', 'Janssen', 'Mississauga Site'),
  ('PS9F6Y0KYL', 0, '2022-03-10', '2022-12-17', 'Pfizer', 'Yorkdale Mall'),
  ('K07FCPKAN0', 0, '2020-05-28', '2024-03-01', 'Moderna', 'Gerrard Square Mall'),
  ('8A62WLWGOR', 2, '2021-10-28', '2023-08-01', 'Astra-Zeneca', 'Gerrard Square Mall'),
  ('FNPISMJBH6', 2, '2020-01-22', '2023-03-27', 'Janssen', 'Mississauga Site'),
  ('MNQMHWKLCP', 2, '2021-05-25', '2024-06-22', 'Astra-Zeneca', 'Mississauga Site'),
  ('6ZOGKPGR8X', 0, '2020-07-11', '2023-01-10', 'Moderna', 'Etobicoke Site');

insert into Patient values
  ('Douglas', 'Hopkins', 'LG7J3Q0BOE', '1910-06-24'),
  ('James', 'Copeland', 'JOH8UA793E', '2007-04-15'),
  ('Teresa', 'Taylor', 'DOUPAVQT60', '1990-08-25'),
  ('Johnnie', 'Reynolds', 'TKJDHWSOU1', '1958-12-21'),
  ('Monica', 'Bumgarner', 'ET7WFLVS2T', '1941-12-09'),
  ('Kenneth', 'Reams', 'V78BG60XNJ', '1969-12-31'),
  ('Lucy', 'Rodriguez', '9QSY8Q852F', '1945-03-13'),
  ('Terry', 'Roberts', 'GUKS7UCG70', '2000-04-20');

insert into Doctor values
  ('ODAEEGA5IC', 'Jon', 'Brevell'),
  ('4LLWJ1BOEU', 'Anne', 'Marks'),
  ('SBKDJQZOTE', 'Johnny', 'Graham'),
  ('76J85OBC25', 'James', 'Neilan'),
  ('H6YMTOYGLX', 'John', 'Nowak'),
  ('LC8LEEKAB6', 'Joe', 'Bradshaw'),
  ('OANAK08QFD', 'Candelaria', 'Buckley'),
  ('4K3XJDXXCY', 'Lisa', 'Washington');

insert into Nurse values
  ('UI340N0BK0', 'Robert', 'Hill'),
  ('SDML7NCTYY', 'Randall', 'Carr'),
  ('J6FUYVDIJA', 'Mary', 'Ares'),
  ('PPXDINET6K', 'Charles', 'Otoole'),
  ('ZSJ7WW1ZJH', 'Maria', 'Hazlett'),
  ('MGSQO1A52L', 'Michael', 'Chin'),
  ('YKLSIF9GOG', 'James', 'Acosta'),
  ('91MZHF69N9', 'Lana', 'Frasher');

insert into Spouse values
  ('416-340-8828', 'CWYSP6ZDAK', 'Justin', 'Haylett', 'GUKS7UCG70'),
  ('416-855-8711', '8A62WLWGOR', 'Rachel', 'Clark', 'ET7WFLVS2T'),
  ('416-966-4280', 'CWYSP6ZDAK', 'Zachary', 'Chappell', 'ET7WFLVS2T'),
  ('613-921-6406', '6ZOGKPGR8X', 'Nancy', 'Howes', 'ET7WFLVS2T'),
  ('416-312-1601', 'PS9F6Y0KYL', 'Chester', 'Ruddy', 'DOUPAVQT60'),
  ('613-543-4345', '8A62WLWGOR', 'Randy', 'Walters', 'V78BG60XNJ'),
  ('416-261-0358', 'MNQMHWKLCP', 'Brian', 'Matthews', 'TKJDHWSOU1'),
  ('416-008-3650', '6ZOGKPGR8X', 'Christopher', 'Hayes', 'GUKS7UCG70');

insert into Medical_practice values
  ('416-102-8969', 'Universal Health', '4K3XJDXXCY'),
  ('613-203-8986', 'Revolution Health', 'H6YMTOYGLX'),
  ('416-915-7496', 'Rejuvenate', 'OANAK08QFD'),
  ('613-731-6270', 'Encounter', '76J85OBC25'),
  ('613-515-5370', 'Big Smiles', '76J85OBC25'),
  ('416-396-2316', 'Health4All', '76J85OBC25'),
  ('613-184-8666', 'Joyful Health', '4K3XJDXXCY'),
  ('416-517-5424', 'Queen\'s Health', 'LC8LEEKAB6');

insert into Nurse_staffs values
  ('SDML7NCTYY', 'Yorkdale Mall'),
  ('MGSQO1A52L', 'North York'),
  ('PPXDINET6K', 'Shoppers Drugmart'),
  ('SDML7NCTYY', 'North York'),
  ('UI340N0BK0', 'Yorkdale Mall'),
  ('YKLSIF9GOG', 'Etobicoke Site'),
  ('YKLSIF9GOG', 'RevPharma'),
  ('MGSQO1A52L', 'Rexall');

insert into Doctor_staffs values
  ('LC8LEEKAB6', 'Rexall'),
  ('LC8LEEKAB6', 'Shoppers Drugmart'),
  ('4K3XJDXXCY', 'Gerrard Square Mall'),
  ('ODAEEGA5IC', 'Yorkdale Mall'),
  ('OANAK08QFD', 'RevPharma'),
  ('ODAEEGA5IC', 'RevPharma'),
  ('4LLWJ1BOEU', 'Shoppers Drugmart'),
  ('ODAEEGA5IC', 'Mississauga Site');

insert into Site_operating_dates values
  -- Operating_date, site name
  ('2020-06-29', 'Rexall'),
  ('2022-06-20', 'Yorkdale Mall'),
  ('2021-08-21', 'Yorkdale Mall'),
  ('2021-02-25', 'North York'),
  ('2021-10-24', 'Gerrard Square Mall'),
  ('2021-01-11', 'Etobicoke Site'),
  ('2020-07-13', 'North York'),
  ('2022-03-17', 'Mississauga Site');

insert into Doctor_credentials values
  -- Credential, doctor ID
  ('MBBS', 'OANAK08QFD'),
  ('PA', 'OANAK08QFD'),
  ('PA', '4LLWJ1BOEU'),
  ('PhD', 'ODAEEGA5IC'),
  ('MBBS', '76J85OBC25'),
  ('DO', 'ODAEEGA5IC'),
  ('MD', 'LC8LEEKAB6'),
  ('MD', '4LLWJ1BOEU');

insert into Nurse_credentials values
  -- Credential, Nurse ID
  ('DO', 'UI340N0BK0'),
  ('MBBS', 'ZSJ7WW1ZJH'),
  ('MD', 'MGSQO1A52L'),
  ('CNP', 'MGSQO1A52L'),
  ('PA', 'PPXDINET6K'),
  ('PA', 'J6FUYVDIJA'),
  ('PhD', 'MGSQO1A52L'),
  ('DNP', 'J6FUYVDIJA');

insert into Recieves_vaccine values
  -- Lot_number, Vaccine site name, patient OHIP, vax date, vax time
  ('QB6C2GMF1G', 'North York', 'JOH8UA793E', '2022-06-04', '15:00:01'),
  ('PS9F6Y0KYL', 'Rexall', '9QSY8Q852F', '2020-11-18', '15:19:21'),
  ('CWYSP6ZDAK', 'North York', 'TKJDHWSOU1', '2022-12-15', '09:34:23'),
  ('8A62WLWGOR', 'Rexall', 'JOH8UA793E', '2022-06-28', '21:25:34'),
  ('MNQMHWKLCP', 'Mississauga Site', 'JOH8UA793E', '2021-06-16', '12:56:39'),
  ('K07FCPKAN0', 'RevPharma', 'TKJDHWSOU1', '2022-08-10', '22:48:57'),
  ('PS9F6Y0KYL', 'Mississauga Site', 'TKJDHWSOU1', '2021-11-12', '22:42:57'),
  ('MNQMHWKLCP', 'RevPharma', 'ET7WFLVS2T', '2021-06-10', '05:16:51');
