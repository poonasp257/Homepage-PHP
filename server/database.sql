drop database if exists project_db;
create database project_db;
grant all on project_db.* to 'test1'@'localhost';
flush privileges;

use project_db;

create table Accounts (
    account_id bigint not null AUTO_INCREMENT,
    nickname    varchar(40) not null UNIQUE,  
    userid    varchar(40) not null UNIQUE,  
    passwd    char(64) not null,
    primary key (account_id)
);

create table Comments (
	comment_id bigint AUTO_INCREMENT,
	account_id bigint,
	parent_comment_id bigint DEFAULT NULL, 
	author varchar(40) not null,
	`text` nvarchar(100) NOT NULL,
	is_displayed boolean DEFAULT TRUE,
	primary key (comment_id),
	CONSTRAINT c_parent_comment_id FOREIGN KEY(parent_comment_id) REFERENCES Comments(comment_id),
	CONSTRAINT c_m_account_id FOREIGN KEY(account_id) REFERENCES Accounts(account_id)
);