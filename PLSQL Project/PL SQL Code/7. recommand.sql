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