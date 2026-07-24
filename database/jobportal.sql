create database jobportal;
use jobportal;
create table users(
    id INT AUTO_INCREMENT PRIMARY KEY,
    username varchar(100) NOT NULL,
    email varchar(100) NOT NULL,
    password varchar(100) NOT NULL
    );
