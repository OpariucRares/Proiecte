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
drop sequence sgbd_user_id_seq;
/
CREATE SEQUENCE sgbd_user_id_seq 
  start with 1 
  increment by 1;
/
drop sequence sgbd_q_seq;
/
CREATE SEQUENCE sgbd_q_seq
  start with 1 
  increment by 1;
/
drop function encrypt_data;
/
CREATE OR REPLACE FUNCTION encrypt_data(input_data varchar2)
RETURN VARCHAR2 AS
    --YOU NEED TO GRANT ACCES TO DBMS_CRYPTO TO THE STUDENT
    --GRANT EXECUTE ON DBMS_CRYPTO  TO STUDENT;
   v_key VARCHAR2 (2000) := '1234567890999999';
BEGIN
    RETURN UTL_RAW.CAST_TO_VARCHAR2 ( DBMS_CRYPTO.encrypt( UTL_RAW.CAST_TO_RAW (input_data), dbms_crypto.DES_CBC_PKCS5, UTL_RAW.CAST_TO_RAW (v_key) ) );
END;
/
drop function decrypt_data
/
CREATE OR REPLACE FUNCTION decrypt_data(input_data varchar2)
RETURN VARCHAR2 AS
    --YOU NEED TO GRANT ACCES TO DBMS_CRYPTO TO THE STUDENT
    --GRANT EXECUTE ON DBMS_CRYPTO  TO STUDENT;
   v_key VARCHAR2 (2000) := '1234567890999999';
BEGIN
   RETURN UTL_RAW.CAST_TO_VARCHAR2 ( DBMS_CRYPTO.decrypt( UTL_RAW.CAST_TO_RAW (input_data), dbms_crypto.DES_CBC_PKCS5, UTL_RAW.CAST_TO_RAW (v_key) ) );
END;
/
drop trigger trigger_user_id;
/
CREATE OR REPLACE TRIGGER trigger_user_id
BEFORE INSERT ON sgbd_user
FOR EACH ROW
WHEN (new.ID IS NULL)
DECLARE
    v_username_exist NUMBER(1);
    v_email_exist NUMBER(1);
    username_exist EXCEPTION;
    PRAGMA EXCEPTION_INIT(username_exist, -20001);
    email_exist EXCEPTION;
    PRAGMA EXCEPTION_INIT(email_exist, -20002);
    email_invalid EXCEPTION;
    PRAGMA EXCEPTION_INIT(email_invalid, -20003);
    v_decrypted_string VARCHAR2(200);
BEGIN
    select count(*) into v_username_exist from sgbd_user where upper(username) = upper(:new.username);
    for v_index in (select email from sgbd_user) loop
        v_decrypted_string := decrypt_data(v_index.email);
        if (v_decrypted_string = :new.email) then
            raise email_exist;
        end if;
    end loop;
    if (v_username_exist > 0) then
        raise username_exist;
    end if;
    if (v_email_exist > 0) then
        raise email_exist;
    end if;
    if (REGEXP_LIKE(:new.email,'[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]+') = FALSE) then
        raise email_invalid;
    end if;
    :new.ID := sgbd_user_id_seq .NEXTVAL;
    :new.email := encrypt_data(:new.email);
    :new.password := encrypt_data(:new.password);
    --DBMS_OUTPUT.PUT_LINE('String criptat: ' || :new.email || ' String decriptat: ' || decrypt_data(:new.email));
    EXCEPTION
    WHEN username_exist THEN
        RAISE_APPLICATION_ERROR( -20001, 'User ' || :new.username || ' already exists!');
    WHEN email_exist THEN
        RAISE_APPLICATION_ERROR( -20002, 'This email ' || :new.email || ' is already taken!');
    WHEN email_invalid THEN
        RAISE_APPLICATION_ERROR( -20003, 'This email format is not correct!');
END;
/
drop trigger trigger_question_id;
/
create or replace TRIGGER trigger_question_id
BEFORE INSERT ON sgbd_questions
FOR EACH ROW
WHEN (new.ID IS NULL)
DECLARE
BEGIN
    :new.ID := sgbd_q_seq.NEXTVAL;
END;
/
drop procedure change_password;
/
CREATE OR REPLACE PROCEDURE change_password(input_email varchar2, old_password varchar2, new_password varchar2, repeted_new_password varchar2)
AS
    v_mail_encrypted VARCHAR2(200);
    v_new_pass_encrypted VARCHAR2(200);
    v_info_decrypted VARCHAR2(200);
    v_exist_info NUMBER(1);
    v_old_pass_decrypted VARCHAR2(200);
    email_absent EXCEPTION;
    PRAGMA EXCEPTION_INIT(email_absent, -20004);
    old_pass_not_match EXCEPTION;
    PRAGMA EXCEPTION_INIT(old_pass_not_match, -20005);
    different_password EXCEPTION;
    PRAGMA EXCEPTION_INIT(different_password, -20006);
BEGIN
    v_exist_info  := 0;
    FOR v_index IN (SELECT email FROM sgbd_user) LOOP     
        v_info_decrypted := decrypt_data(v_index.email);
        if (input_email = v_info_decrypted) then
            v_mail_encrypted := v_index.email;
            v_exist_info := 1;
            exit;
        end if;
    END LOOP;
    if (v_exist_info = 0) then
        raise email_absent;
    end if;
    v_exist_info  := 0;
    FOR v_index IN (SELECT password FROM sgbd_user) LOOP     
        v_info_decrypted := decrypt_data(v_index.password);
        if (old_password = v_info_decrypted) then
             v_exist_info := 1;
            exit;
        end if;
    END LOOP;
    if (v_exist_info = 0) then
        raise old_pass_not_match;
    end if;
    if (new_password != repeted_new_password) then
        raise different_password;
    end if;
    --a trecut de toti pasii -> modificam parola criptata
    v_new_pass_encrypted := encrypt_data(new_password);
    UPDATE sgbd_user
    SET password = v_new_pass_encrypted 
    WHERE email = v_mail_encrypted;
    EXCEPTION
    WHEN email_absent THEN
        RAISE_APPLICATION_ERROR( -20004, 'Email ' || input_email || ' does not exist!');
    WHEN old_pass_not_match THEN
        RAISE_APPLICATION_ERROR( -20005, 'Old password does not match!');
    WHEN different_password THEN
        RAISE_APPLICATION_ERROR( -20006, 'Passwords are not the same!');
END;
/
drop procedure make_friend;
/
CREATE OR REPLACE PROCEDURE make_friend(user_input varchar2, user_receiver varchar2)
AS
    --input: numele persoana 1, persoana 2
    v_id_receiver NUMBER(38);
    v_id_input NUMBER(38);
    v_duplicate NUMBER(38);
    receiver_not_exist EXCEPTION;
    PRAGMA EXCEPTION_INIT(receiver_not_exist, -20007);
    duplicate_friendship EXCEPTION;
    PRAGMA EXCEPTION_INIT(duplicate_friendship, -20008);
    friendship_itself EXCEPTION;
    PRAGMA EXCEPTION_INIT(duplicate_friendship, -20009);
begin
    v_id_receiver := -1;
    select count(*) into v_id_receiver from sgbd_user where upper(username) = upper(user_receiver);
    if (v_id_receiver = 0) then
        raise receiver_not_exist;
    end if;
    select id into v_id_receiver from sgbd_user where upper(username) = upper(user_receiver);
    select id into v_id_input from sgbd_user where upper(username) = upper(user_input);
    if (v_id_input = v_id_receiver) then
        raise friendship_itself;
    end if;
    select count(*) into v_duplicate from sgbd_friendship where user_id = v_id_input AND friend_id = v_id_receiver;
    if (v_duplicate > 0) then
        raise duplicate_friendship;
    end if;
    INSERT INTO sgbd_friendship VALUES(v_id_input, v_id_receiver);
    INSERT INTO sgbd_friendship VALUES(v_id_receiver, v_id_input);
    EXCEPTION
    WHEN receiver_not_exist THEN
        RAISE_APPLICATION_ERROR( -20007, user_receiver || ' does not exist in the database!');
    WHEN duplicate_friendship THEN
        RAISE_APPLICATION_ERROR( -20008, 'This friendship already exists!');
    WHEN friendship_itself THEN
        RAISE_APPLICATION_ERROR( -20009, 'You can not friend yourself!');
end;
/
drop function recommand_friend;
/
CREATE OR REPLACE function recommand_friend(user_input varchar2)
RETURN varchar2 AS
    v_id_user number(38);
    v_numar NUMBER(38);
    v_return_string varchar2(5000);
    v_user_rec varchar2(500);
begin
    select id into v_id_user from sgbd_user where upper(username) = upper(user_input);
    DELETE from dummy;
    FOR v_index_one IN (select distinct user_id from sgbd_friendship where friend_id = v_id_user) LOOP
        --toti oamenii care sunt prieteni cu persoana respectiva
        --acum afisam prietenii in tabelul respectiv
        for v_index_two in (select distinct user_id from sgbd_friendship where friend_id = v_index_one.user_id and user_id != v_id_user)  loop
            DBMS_OUTPUT.PUT_LINE('User: ' || v_index_one.user_id || 'Prieten: ' || v_index_two.user_id);
            insert into dummy values(v_index_two.user_id);
        end loop;
    end loop;
    v_return_string := 'Recommended friends are ';
    for v_index_one in (select distinct * from dummy) loop
        select count(*) into v_numar from dummy where id = v_index_one.id;
        if (v_numar >= 2) then
            select username into v_user_rec from sgbd_user where id = v_index_one.id;
            v_return_string := v_return_string || v_user_rec || ' ';
            --DBMS_OUTPUT.PUT_LINE(v_index_one.id);
        end if;
    end loop;
    return v_return_string;
end;
/
drop function generate_questions;
/
CREATE OR REPLACE FUNCTION generate_questions(username varchar2)
RETURN varchar2 AS
    v_questions varchar2(200);
    v_answear varchar2(200);
    v_points number(38);
    
    TYPE varr IS VARRAY(10) OF number(38);
    question_list varr;
    
    v_contor_ques number(38);
    v_contor_varray number(38);
    v_maxim number;
    v_index pls_integer;
    v_ok number(38);
    
    v_return_string varchar2(5000);
    v_question_string varchar2(500);
BEGIN
    select max(id) into v_maxim from sgbd_questions;
    v_contor_ques := 1;
    question_list := varr(-1, -1, -1,-1, -1, -1, -1, -1, -1, -1);
    WHILE (v_contor_ques <= 10) LOOP       
        v_index := dbms_random.value(1, v_maxim);
        v_ok := 1;
        FOR v_contor_varray IN question_list.FIRST..question_list.LAST LOOP
            if (question_list(v_contor_varray) = v_index) then
                v_ok := 0;
                exit;
            end if;
        end loop;
        if (v_ok = 1) then
            question_list(v_contor_ques) := v_index;
            DBMS_OUTPUT.PUT_LINE(v_index || ' ');
            v_contor_ques := v_contor_ques + 1;
        end if;
    END LOOP;
    v_contor_ques := 1;
    FOR v_index IN question_list.FIRST..question_list.LAST LOOP
        select 'Q' || v_contor_ques || '. Domeniu ' || domain || CHR(10) || questions || CHR(10) || var1 || CHR(10)|| var2 || CHR(10) || var3 || CHR(10) || var4 || CHR(10) || 'Points: ' || points into v_question_string from sgbd_questions where id = question_list(v_index);
        v_return_string := v_return_string || CHR(10) || v_question_string;
        v_contor_ques := v_contor_ques + 1;
    end loop;
    --DBMS_OUTPUT.PUT_LINE(v_return_string);
    return v_return_string;
END generate_questions;
/
drop function get_point;
/
CREATE OR REPLACE FUNCTION get_point(question_string varchar2, answear varchar2)
RETURN number AS
    v_point NUMBER(1);
    v_good_ans VARCHAR2(200);
    v_answear_pattern varchar2(200);
BEGIN
    v_point := 0;
    v_answear_pattern := answear || '%';
    select var_good into v_good_ans from sgbd_questions where questions = question_string;
    if (v_good_ans like v_answear_pattern) then
        v_point := 1;
    end if;
    return v_point;
END get_point;
/