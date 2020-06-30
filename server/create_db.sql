use mysql;

drop user 'test1'@'localhost';
create user 'test1'@'localhost' identified by 'bitnami';
select User,Host from user where User='test1';
flush privileges; -- please don't forget to add the following command

drop database if exists exam_db;
create database exam_db;
grant all on exam_db.* to 'test1'@'localhost';
flush privileges;
 
select '현재 존재하는 모든 데이터베이스들 ' as '';
show databases;
select '등록된 사용자 리스트' as '';
select User, Host from user where User='test1';
select 'classicmodels 데이터베이스에 등록된 테이블들' as '';
use exam_db;
show tables;

select User, Host from user where User='test1';
select 'classicmodels 데이터베이스에 등록된 테이블들' as '';
use exam_db;
show tables;