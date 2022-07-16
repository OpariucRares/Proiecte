package repository;

import entity.UserEntity;

import java.sql.*;
import java.util.ArrayList;
import java.util.List;
import java.util.Scanner;

public class UserRepository extends DataRepository<UserEntity, Integer>{

    @Override
    public void create(UserEntity user) {
        Connection con = Database.getConnection();
        try (PreparedStatement pstmt = con.prepareStatement(
                "insert into sgbd_user(username, email, password) values(?, ?, ?)")) {
            pstmt.setString(1, user.getUsername());
            pstmt.setString(2, user.getEmail());
            pstmt.setString(3, user.getPassword());
            pstmt.executeUpdate();
            con.commit();
            con.close();
        }
        catch (SQLException e) {
            e.printStackTrace();
        }
    }
    public void changePassword(String email, String oldPass, String newPass, String newPassRepeat){
        Connection con = Database.getConnection();
        try{
            CallableStatement cstmt = con.prepareCall(
                    "{call change_password(?, ?, ?, ?)}");
            cstmt.setString(1, email);
            cstmt.setString(2, oldPass);
            cstmt.setString(3, newPass);
            cstmt.setString(4, newPassRepeat);
            cstmt.executeQuery();
            con.close();
        }
        catch (SQLException e) {
            e.printStackTrace();
        }
    }
    public void makeFriend(String user_one, String user_two){
        Connection con = Database.getConnection();
        try{
            CallableStatement cstmt = con.prepareCall(
                    "{call make_friend(?, ?)}");
            cstmt.setString(1, user_one);
            cstmt.setString(2, user_two);
            cstmt.executeQuery();
            con.close();
            System.out.println(user_one + " is now friends with " + user_two);
        }
        catch (SQLException e) {
            e.printStackTrace();
        }
    }
    public void recommend(String user_one){
        Connection con = Database.getConnection();
        try{
            CallableStatement cstmt = con.prepareCall("{? = call recommand_friend(?)}");
            cstmt.registerOutParameter(1, Types.VARCHAR);
            cstmt.setString(2, user_one);
            cstmt.executeUpdate();
            String resultString = cstmt.getString(1);
            System.out.println(resultString);
            con.close();
        }
        catch (SQLException e) {
            e.printStackTrace();
        }
    }
    public void generateQuestions(UserEntity userEntity){
        Connection con = Database.getConnection();
        try{
            String userName = userEntity.getUsername();
            CallableStatement cstmt = con.prepareCall("{? = call generate_questions(?)}");
            cstmt.registerOutParameter(1, Types.VARCHAR);
            cstmt.setString(2, userName);
            cstmt.executeUpdate();
            String resultString = cstmt.getString(1);

            String[] onlyQuestions = resultString.split("\n");
            List<String> questionsUser = new ArrayList<>();
            int takeInfo = 0;
            for(String questionIndex : onlyQuestions){
                if (takeInfo % 7 == 2)
                    questionsUser.add(questionIndex);
                takeInfo++;
                takeInfo = takeInfo % 7;
            }
            //avem intrebarile la utilizatorul curent
            userEntity.getTestUser().addAll(questionsUser);
            //System.out.println(resultString);
            System.out.println("Va rog sa scrieti exact in formatul acesta:  litera) (ex: a) ). Daca nu respectati, se va considera raspuns gresit!");
            Scanner in = new Scanner(System.in);
            int pointsUser = 0;
            String answearUser;
            for(int contorAns = 0; contorAns < 10; ++contorAns){
                for(int contorQuestionIndex = contorAns * 7, index = 0; index < 8; ++index, ++contorQuestionIndex){
                    System.out.println(onlyQuestions[contorQuestionIndex]);
                }
                System.out.println("Raspunsul este: ");
                answearUser = in.nextLine();
                cstmt = con.prepareCall("{? = call get_point(?, ?)}");
                cstmt.registerOutParameter(1, Types.INTEGER);
                cstmt.setString(2, userEntity.getTestUser().get(contorAns));
                cstmt.setString(3, answearUser);
                cstmt.executeUpdate();
                pointsUser += cstmt.getInt(1);
            }
            System.out.println("Punctajul final: " + pointsUser * 10);
            String sqlCommand = "SELECT id FROM SGBD_USER WHERE USERNAME = '" + userEntity.getUsername() + "'";
            Statement stmt = con.createStatement();
            stmt = con.createStatement();
            ResultSet rs = cstmt.executeQuery(sqlCommand);
            int idUser = -1;
            if (rs.next()) idUser = rs.getInt("id");
            PreparedStatement pstmt = con.prepareStatement("insert into sgbd_user_point values(?, ?)");
            pstmt.setString(1, userEntity.getUsername());
            pstmt.setInt(2, pointsUser);
            pstmt.executeUpdate();
            con.commit();
            con.close();
        }
        catch (SQLException e) {
            e.printStackTrace();
        }
    }
    public void showTopFour(UserEntity userEntity){
        try {
            Connection con = Database.getConnection();
            String sqlCommand = "select * from (select * from sgbd_user_point where username ='" + userEntity.getUsername() + "' order by points desc) where rownum < 5";
            Statement stmt = con.createStatement();
            ResultSet rs = stmt.executeQuery(sqlCommand);
            int contor = 1;
            System.out.println("Top 4 punctaje pentru " + userEntity.getUsername());
            while (rs.next()){
                System.out.println("Number " + contor + " -> " + rs.getInt(2) + " points");
                contor++;
            }
            con.close();
        }
        catch (SQLException e) {
            e.printStackTrace();
        }
    }
}
