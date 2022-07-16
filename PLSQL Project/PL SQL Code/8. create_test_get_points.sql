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
