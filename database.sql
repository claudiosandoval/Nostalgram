CREATE DATABASE IF NOT EXISTS nostalgram;

USE nostalgram;

CREATE TABLE IF NOT EXISTS users(
    id              INT(255) AUTO_INCREMENT NOT NULL,
    role            VARCHAR(20) NOT NULL,
    name            VARCHAR(100) NOT NULL,
    surname         VARCHAR(200) NOT NULL,
    nick            VARCHAR(100) NOT NULL,
    email           VARCHAR(255) NOT NULL,
    password        VARCHAR(255) NOT NULL,
    image           VARCHAR(255) NOT NULL,
    create_at       DATETIME,
    updated_at      DATETIME,
    remember_token  VARCHAR(255),
    CONSTRAINT pk_users PRIMARY KEY(id)
)ENGINE=InnoDb; 


INSERT INTO users VALUES(NULL, 'user', 'Claudio', 'Sandoval', 'claudiosanher', 'claudiosandovalherrera@gmail.com', 'system123', NULL, CURTIME(), CURTIME(), NULL);
INSERT INTO users VALUES(NULL, 'user', 'Sebastian', 'Sandoval', 'sebastiansanher', 'sebastiansandovalherrera@gmail.com', 'system123', NULL, CURTIME(), CURTIME(), NULL);
INSERT INTO users VALUES(NULL, 'user', 'Fernando', 'Sandoval', 'fernandosanher', 'fernandosandovalvidal@gmail.com', 'system123', NULL, CURTIME(), CURTIME(), NULL);

CREATE TABLE IF NOT EXISTS IMAGES(
    id              INT(255) AUTO_INCREMENT NOT NULL,
    user_id         INT(255) NOT NULL,
    image_path      VARCHAR(255) NOT NULL,
    description     TEXT NOT NULL,
    created_at      DATETIME,
    updated_at      DATETIME,
    CONSTRAINT pk_images PRIMARY KEY(id),
    CONSTRAINT fk_images_users FOREIGN KEY(user_id) REFERENCES users(id) 
)ENGINE=InnoDb;  

INSERT INTO images VALUES(NULL, 1, 'test.jpg', 'Descripcion de prueba 1', CURTIME(), CURTIME());
INSERT INTO images VALUES(NULL, 1, 'playa.jpg', 'Descripcion de prueba 2', CURTIME(), CURTIME());
INSERT INTO images VALUES(NULL, 1, 'campo.jpg', 'Descripcion de prueba 3', CURTIME(), CURTIME());
INSERT INTO images VALUES(NULL, 3, 'familia.jpg', 'Descripcion de prueba 4', CURTIME(), CURTIME());

CREATE TABLE IF NOT EXISTS COMMENTS(
     id             INT(255) AUTO_INCREMENT NOT NULL,
     user_id        INT(255),
     image_id       INT(255),
     content        TEXT,
     created_at     DATETIME,
     updated_at     DATETIME,
     CONSTRAINT pk_comments PRIMARY KEY(id),
     CONSTRAINT fk_comments_users FOREIGN KEY(user_id) REFERENCES users(id),
     CONSTRAINT fk_comments_images FOREIGN KEY(image_id) REFERENCES images(id)
)ENGINE=InnoDb; 

INSERT INTO comments VALUE(NULL, 3, 3, 'Que lindo el campo', CURTIME(), CURTIME());
INSERT INTO comments VALUE(NULL, 2, 2, 'Que linda playa', CURTIME(), CURTIME());
INSERT INTO comments VALUE(NULL, 3, 2, 'Que linda playa totoralillo', CURTIME(), CURTIME());
INSERT INTO comments VALUE(NULL, 3, 8, 'Que linda foto en familia', CURTIME(), CURTIME());


CREATE TABLE IF NOT EXISTS LIKES(
    id              INT(255) AUTO_INCREMENT NOT NULL,
    user_id         INT(255) NOT NULL,
    image_id        INT(255) NOT NULL,
    created_at      DATETIME,
    updated_at      DATETIME,
    CONSTRAINT pk_likes PRIMARY KEY(id),
    CONSTRAINT fk_likes_users FOREIGN KEY(user_id) REFERENCES users(id), 
    CONSTRAINT fk_likes_images FOREIGN KEY(image_id) REFERENCES images(id) 
)ENGINE=InnoDb;     

INSERT INTO likes VALUES(NULL, 1, 3, CURTIME(), CURTIME());
INSERT INTO likes VALUES(NULL, 2, 3, CURTIME(), CURTIME());
INSERT INTO likes VALUES(NULL, 3, 2, CURTIME(), CURTIME());
INSERT INTO likes VALUES(NULL, 3, 3, CURTIME(), CURTIME());

