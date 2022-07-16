package repository;

import entity.Question;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.SQLException;

public class QuestionRepository extends DataRepository<Question, Integer>{

    @Override
    public void create(Question question) {
        Connection con = Database.getConnection();
        try (PreparedStatement pstmt = con.prepareStatement(
                "insert into SGBD_QUESTIONS(domain, questions, var1, var2, var3, var4, var_good, points) values(?, ?, ?, ?, ?, ?, ?, ?)")) {
            pstmt.setString(1, question.getDomain());
            pstmt.setString(2, question.getQuestions());
            pstmt.setString(3, question.getVar1());
            pstmt.setString(4, question.getVar2());
            pstmt.setString(5, question.getVar3());
            pstmt.setString(6, question.getVar4());
            pstmt.setString(7, question.getVarGood());
            pstmt.setInt(8, question.getPoints());
            pstmt.executeUpdate();
            con.commit();
            con.close();
        }
        catch (SQLException e) {
            e.printStackTrace();
        }
    }
}
