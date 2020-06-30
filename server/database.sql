drop database if exists project_db;
create database project_db;
use project_db;

create table UserAccounts (
    account_id bigint not null AUTO_INCREMENT,
    userid    varchar(40) not null,  
    passwd    char(64) not null,
    `name`    varchar(40),
    primary key (account_id),
  	CONSTRAINT user_accounts_unique UNIQUE (userid)
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
	CONSTRAINT c_m_account_id FOREIGN KEY(account_id) REFERENCES UserAccounts(account_id)
);

-- Populate
INSERT INTO UserAccounts(userid, passwd, `name`) VALUES('bseo', sha2('test',224), 'Beomjoo Seo');
INSERT INTO UserAccounts(userid, passwd, `name`) VALUES('jun', sha2('test',224), 'JunYoung Lee');
INSERT INTO UserAccounts(userid, passwd, `name`) VALUES('kim', sha2('test',224), 'JunYoung Kim');
INSERT INTO UserAccounts(userid, passwd, `name`) VALUES('nana', sha2('test',224), 'Nana Kim');

select * from UserAccounts;