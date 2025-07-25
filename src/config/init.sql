CREATE DATABASE IF NOT EXISTS shop;

use shop;

CREATE TABLE IF NOT EXISTS `Category`(
    uuid VARCHAR(36) PRIMARY KEY,
    title VARCHAR(36) NOT NULL DEFAULT 'New Category' UNIQUE
);

CREATE TABLE IF NOT EXISTS Product(
    uuid VARCHAR(36) PRIMARY KEY,
    title VARCHAR(255) NOT NULL DEFAULT 'New Product',
    price DECIMAL(6,2) NOT NULL DEFAULT '1.99',
    `description` VARCHAR(512) DEFAULT "Item description",
    category VARCHAR(36),
    stock INT(4) NOT NULL DEFAULT 0,
    FOREIGN KEY (category) REFERENCES Category(title) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS User(
    uuid VARCHAR(36) PRIMARY KEY,
    email VARCHAR(64),
    username VARCHAR(32) DEFAULT 'Guest',
    `password` VARCHAR(128),
    `type` VARCHAR(32) DEFAULT 'guest' NOT NULL
);

CREATE TABLE IF NOT EXISTS Cart(
    uuid VARCHAR(36) PRIMARY KEY,
    userUuid VARCHAR(36) DEFAULT NULL,
    `status` int DEFAULT 0,
    createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updatedAt DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (userUuid) REFERENCES User(uuid) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS CartItem(
    uuid VARCHAR(36) PRIMARY KEY,
    CartUuid VARCHAR(36) NOT NULL,
    ProductUuid VARCHAR(36) NOT NULL,
    createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (ProductUuid) REFERENCES Product(uuid) ON DELETE CASCADE,
    FOREIGN KEY (CartUuid) REFERENCES Cart(uuid) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS `Order`(
    uuid VARCHAR(36) PRIMARY KEY,
    CartUuid VARCHAR(36),
    UserUuid VARCHAR(36),
    createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `status` INT DEFAULT 0, -- 0 = processing, -1 = cancelled.
    `address` VARCHAR(80) NOT NULL,
    `zipcode` VARCHAR(7) NOT NULL,
    `location` VARCHAR(32) NOT NULL,
    `price` DECIMAL(8,2) NOT NULL DEFAULT 0.00,
    FOREIGN KEY (CartUuid) REFERENCES Cart(uuid),
    FOREIGN KEY (UserUuid) REFERENCES User(uuid)
);

CREATE TABLE IF NOT EXISTS `ContactRequest`(
    uuid VARCHAR(36) PRIMARY KEY,
    email VARCHAR(64) NOT NULL,
    body VARCHAR(512) NOT NULL
);

INSERT INTO Category(uuid, title) VALUES (UUID(), 'Wearable');
INSERT INTO Category(uuid, title) VALUES (UUID(), 'Phone');

INSERT INTO Product(uuid, title, price, `description`, category) VALUES (
    UUID(),
    'Pear Watch 10',
    429.99,
    "This is a beautiful description",
    'Wearable'
);

INSERT INTO Product(uuid, title, price, `description`, category) VALUES (
    UUID(),
    'Pear Watch SE',
    217.99,
    "This is a beautiful description",
    'Wearable'
);

INSERT INTO Product(uuid, title, price, `description`, category) VALUES (
    UUID(),
    'Pear Watch Ultra 3',
    1379.99,
    "This is a beautiful description",
    'Wearable'
);

INSERT INTO Product(uuid, title, price, `description`, category) VALUES (
    UUID(),
    'youPhone 12',
    429.99,
    "This is a beautiful description",
    'Phone'
);

INSERT INTO Product(uuid, title, price, `description`, category) VALUES (
    UUID(),
    'youPhone SE',
    217.99,
    "This is a beautiful description",
    'Phone'
);

INSERT INTO Product(uuid, title, price, `description`, category) VALUES (
    UUID(),
    'youPhone 16 Plus Expert',
    1379.99,
    "This is a beautiful description",
    'Phone'
);

INSERT INTO User(uuid, email, username, `password`, `type`) VALUES (
    UUID(),
    'nikkie@schaad.zip',
    'NikkieDev',
    '$2y$10$hh98T2wegkKo40EgUw64E.3wpeMw8Urve4JV2sP0bjUTVwTW1Dfwq', -- cappuccino123
    'user'
);

INSERT INTO User(uuid, email, username, `password`, `type`) VALUES (
    UUID(),
    'nikkie@kubyx.nl',
    'NikkieMin',
    '$2y$10$MueOBYl6V2DOHFBD2kCcmOKT1/.IB9EytTmrJbS.9.PD7LYASq1/.', -- coffee987
    'admin'
)