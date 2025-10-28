CREATE USER 'thiagonestor'@'localhost'
identified by '1292007';

grant all privileges on *.* to 'thiagonestor'@'localhost' with grant option;
flush privileges;

drop database if exists projetophp;
create database projetophp;
use projetophp;

create table usuario(
cpf int primary key unique,
nome varchar(100),
idade int,
numero_cell int(15),
endereco varchar(200),
email varchar(300)
);

create table login(
senha varchar(100),
email varchar(300) primary key,
foreign key (nome) references(nome)
);

select* from usuario 
