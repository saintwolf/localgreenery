CREATE TABLE `members`
{
id int NOT NULL,
username VARCHAR(30) NOT NULL,
password CHAR(32) NOT NULL,
role VARCHAR(20),
banned BOOLEAN NOT NULL,
PRIMARY KEY (id),
UNIQUE (username)
};

CREATE TABLE `news`
{
id int NOT NULL,
user_id int NOT NULL,
text TEXT,
created_at TIMESTAMP,
PRIMARY KEY (id)
};

CREATE TABLE `products`
{
id int NOT NULL,
name VARCHAR(30) NOT NULL,
type VARCHAR(30) NOT NULL,
weight FLOAT NOT NULL,
price FLOAT NOT NULL,
image_url VARCHAR(100),
active BOOLEAN NOT NULL,
PRIMARY KEY (id)
};

CREATE TABLE `options`
{
id int NOT NULL,
option VARCHAR(30) NOT NULL,
value VARCHAR(30),
PRIMARY KEY (id)
};

INSERT INTO `options` VALUES ('', 'status', 'Unavailable');
