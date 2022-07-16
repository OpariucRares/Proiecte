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