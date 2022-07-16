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