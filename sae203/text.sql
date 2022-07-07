create database if not exists sae203_bdd;
use sae203_bdd;

drop table if exists _users;
create table _users (
    user_id serial,
    name varchar(40) not null,
    first_name varchar(40) not null,
    username varchar(40) not null,
    mail varchar(80) not null,
    password varchar(100) not null,
    status boolean default false not null,
    link_confirmation varchar(255),
    date_registration datetime not null,
    constraint pk_users primary key (user_id),
    unique key (mail),
    unique key (username)
);

drop table if exists _annonce;
create table _annonce (
    news_id serial,
    title_new varchar(80) not null,
    city varchar(60) not null,
    date_creation date not null,
    file_name varchar(15) not null,
    img_user_name varchar(90) not null,
    description text not null,
    libelle varchar(50) not null,
    user_id integer not null,
    constraint pk_users primary key (news_id)
);

drop table if exists _categorie;
create table _categorie (
    libelle varchar(50),
    constraint pk_categorie primary key (libelle)
);