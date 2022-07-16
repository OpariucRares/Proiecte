--Table
DROP TABLE sgbd_user
/
CREATE TABLE sgbd_user(
    id NUMBER(38) PRIMARY KEY,
    username VARCHAR2(200),
    email VARCHAR2(200),
    password VARCHAR2(200)
);
/
DROP TABLE sgbd_friendship
/
CREATE TABLE sgbd_friendship(
    user_id NUMBER(38) NOT NULL,
    friend_id NUMBER(38) NOT NULL
);
/
DROP TABLE sgbd_questions;
/
CREATE TABLE sgbd_questions(
    id NUMBER(38) PRIMARY KEY,
    domain VARCHAR2(200),
    questions VARCHAR2(200),
    var1 VARCHAR2(200),
    var2 VARCHAR2(200),
    var3 VARCHAR2(200),
    var4 VARCHAR2(200),
    var_good VARCHAR2(200),
    points number(38)
);
drop table sgbd_dummy;
/
CREATE TABLE sgbd_dummy(
    id NUMBER(38)
);
/
drop table sgbd_user_point
/
create table sgbd_user_point(
    username varchar2(200),
    points number(38)
);
/
