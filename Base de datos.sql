CREATE DATABASE PSW;

USE PSW;

CREATE TABLE users (
  id BIGINT PRIMARY KEY AUTO_INCREMENT,
  username VARCHAR(255) NOT NULL UNIQUE,
  email VARCHAR(255) NOT NULL UNIQUE,
  nombre VARCHAR(255) NOT NULL UNIQUE,
  password_hash TEXT NOT NULL,
  creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  ultima_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  habilitado smallint default 1,
  role_id BIGINT
);




DELIMITER //


DROP PROCEDURE IF EXISTS CRUD_PSW;
CREATE PROCEDURE CRUD_PSW(
    IN TIPO INT,
    IN p_username VARCHAR(255) ,
    IN p_email VARCHAR(255),
    IN p_nombre VARCHAR(255),
    IN p_password_hash TEXT,
    IN p_role_id BIGINT 
)
BEGIN

    IF (TIPO = 1) THEN

        INSERT INTO users (username, email, nombre, password_hash, role_id)
        VALUES (p_username, p_email, p_nombre, p_password_hash, p_role_id);

    END IF;

    IF(TIPO = 2) THEN
        SELECT * FROM users WHERE habilitado = 1;
    END IF;   

    IF(TIPO = 3) THEN
        UPDATE users SET habilitado = 0 where id = p_role_id;
    END IF;


    IF(TIPO = 4) THEN
        UPDATE users SET
            username = p_username,
            email = p_email,
            nombre = p_nombre,
            password_hash = p_password_hash,
            ultima_actualizacion = CURRENT_DATE()
        WHERE id = p_role_id;
    END IF;


END 


CREATE TRIGGER user_AI
BEFORE INSERT ON users
FOR EACH ROW
BEGIN
    -- Verifcar si ya existe un registro con el mismo usuario
    IF EXISTS (SELECT 1 FROM users WHERE username = NEW.username) THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Error: el usuario ya existe';
    END IF;

    -- Verifcar si ya existe un registro con el mismo corroe
    IF EXISTS (SELECT 1 FROM users WHERE email = NEW.email) THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Error: el email ya existe.';
    END IF;
END
//

DELIMITER ;


SELECT * FROM USERS;
UPDATE users SET habilitado = 1;


