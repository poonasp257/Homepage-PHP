use mysql;
drop user 'test1'@'localhost';
create user 'test1'@'localhost' identified by 'bitnami';
select User,Host from user where User='test1';
flush privileges;