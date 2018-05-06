create database agenda

default character set utf8

default collate utf8_general_ci;

use agenda;

create table tbl_contato (
id_contato int (11) not null auto_increment,
fnome varchar (45) not null,
lnome varchar (45) not null,
email varchar (45),
bday date,
primary key (id_contato)
) default charset utf8;

INSERT INTO `tbl_contato` (`id_contato`, `fnome`, `lnome`, `email`, `bday`) VALUES
(1, 'John ', 'Doe', 'johndoe@gmail.com', '1988-07-10'),
(2, 'Jane', 'Doe', 'janedoe@gmail.com', '1992-02-13');

create table tbl_endereco (
id_endereco int (11) not null auto_increment,
cep varchar (9),
rua varchar (45),
numero_endereco int,
bairro varchar (45),
cidade varchar (45),
estado varchar(2),
id_contato int (11) not null,
primary key (id_endereco)
) default charset utf8;

INSERT INTO `tbl_endereco` (`id_endereco`, `cep`, `rua`, `numero_endereco`, `bairro`, `cidade`, `estado`, `id_contato`) VALUES
(1, '81200-200', 'Barbara Cvital', 200, 'Mossungue', 'Curitiba', 'PR', 0),
(2, '82210-000', 'Avenida Anita Garibaldi ', 2355, 'São Lourenço', 'Curitiba', 'PR', 0);

create table tbl_telefone (
id_telefone int (11) not null auto_increment,
numero_telefone varchar(20),
id_contato int not null,
primary key (id_telefone)
) default charset utf8;

INSERT INTO `tbl_telefone` (`id_telefone`, `numero_telefone`, `id_contato`) VALUES
(1, '4198989898', 0),
(2, '4199991111', 0);