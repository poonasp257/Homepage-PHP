drop database if exists project_db;
create database project_db;
grant all on project_db.* to 'test1'@'localhost';
flush privileges;

use project_db;

CREATE TABLE Account (
    account_id 	BIGINT NOT NULL AUTO_INCREMENT,
	account_type INT DEFAULT 1, 
    nickname    VARCHAR(40) NOT NULL UNIQUE,  
    userid    	VARCHAR(40) NOT NULL UNIQUE,  
    passwd    	CHAR(64) NOT NULL,
    PRIMARY KEY (account_id)
);

CREATE TABLE Post (
	post_id 			BIGINT NOT NULL AUTO_INCREMENT,
	forum_type 			INT NOT NULL,
	author_account_id 	BIGINT NOT NULL,
	author 				VARCHAR(40) NOT NULL,
	title 				VARCHAR(40) NOT NULL,
	`text`				TEXT NOT NULL, 
	created_date 		TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	is_displayed 		BOOLEAN DEFAULT TRUE,
    PRIMARY KEY (post_id),
	CONSTRAINT c_art_account_id FOREIGN KEY(author_account_id) REFERENCES Account(account_id)
);

CREATE TABLE Comment (
	comment_id 			BIGINT NOT NULL AUTO_INCREMENT,
	post_id		 		BIGINT NOT NULL,
	parent_comment_id 	BIGINT DEFAULT NULL, 
	author_account_id 	BIGINT NOT NULL,
	author 				VARCHAR(40) NOT NULL,
	`text` 				TEXT NOT NULL,
	created_date 		TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	is_displayed 		BOOLEAN DEFAULT TRUE,
    PRIMARY KEY (comment_id),
	CONSTRAINT c_post_id FOREIGN KEY(post_id) REFERENCES Post(post_id),
	CONSTRAINT c_com_account_id FOREIGN KEY(author_account_id) REFERENCES Account(account_id),
	CONSTRAINT c_parent_comment_id FOREIGN KEY(parent_comment_id) REFERENCES Comment(comment_id)
);

insert into Account(account_type, nickname, userid, passwd) 
	values(0, '관리자', 'admin', sha2('test', 224));