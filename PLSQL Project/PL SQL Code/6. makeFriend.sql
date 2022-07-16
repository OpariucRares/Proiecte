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