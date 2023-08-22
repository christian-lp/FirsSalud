-- Codigo de las Vistas

    CREATE VIEW list_medics AS 
SELECT 
    medics.id_medic AS "medic_id",
    medics.matricul_medic AS "matricul", 
    medics.name_medic AS "name",
    medics.surname_medic AS "surname", 
    genders.gender_name AS "gender", 
    medics.day_of_birth_medic AS "day_of_birth", 
    medics.email_medic AS "email", 
    medics.phone_medic AS "phone", 
    specialties.specialty_name AS "specialty"
    status.state_name` AS "state"
FROM 
    medics 
JOIN 
    genders ON medics.gender_medic = genders.gender_id;
JOIN
    specialties ON medics.specialty_medic = specialties.specialty_id;
JOIN
    status ON medics.is_active = status.state_id`;



    CREATE VIEW list_patients AS 
SELECT 
    patients.id_patient AS "patient_id",
    patients.dni AS "dni", 
    patients.name AS "name",
    patients.surname AS "surname", 
    genders.gender_name AS "gender", 
    patients.day_of_birth AS "day_of_birth", 
    patients.email AS "email", 
    patients.phone AS "phone",
    patients.state_name` AS "state"
FROM 
    patients 
JOIN 
    genders ON patients.gender = genders.gender_id;
JOIN
    status ON patients.is_active = status.state_id`;


    CREATE VIEW list_users AS 
SELECT 
    users.id_user AS "user _id",
    users.dni AS "dni", 
    users.name AS "name",
    users.surname AS "surname", 
    genders.gender_name AS "gender", 
    users.day_of_birth AS "day_of_birth", 
    users.email AS "email", 
    users.phone AS "phone",
    users.state_name` AS "state"
FROM 
    users 
JOIN 
    genders ON users.gender = genders.gender_id;
JOIN
    status ON users.is_active = status.state_id`;