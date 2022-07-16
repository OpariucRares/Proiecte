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