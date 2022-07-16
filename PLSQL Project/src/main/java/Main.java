import entity.UserEntity;
import populate.PopulateQuestions;
import populate.PopulateUsers;
import repository.UserRepository;

public class Main {
    public static void main(String[] args){
        registerNewUser();
        populateTables();
        changePassword();
        makeFriends();
        generateQuestionsPoints();
        selectTopFourScores();
    }

    private static void populateTables() {
        new PopulateQuestions().execute();
        new PopulateUsers().execute();
    }
    private static void registerNewUser(){
        UserRepository userRepository = new UserRepository();
        UserEntity rares = new UserEntity("rares", "rares@gmail.com", "pass");
        userRepository.create(rares);
        UserEntity test1 = new UserEntity("test1", "rares@gmail.com", "pass");
        userRepository.create(test1);
        UserEntity test2 = new UserEntity("gigel", "mere", "pass");
        userRepository.create(test2);
        UserEntity test3 = new UserEntity("gigel", "rares@gmail.com", "pass");
        userRepository.create(test3);
        UserEntity gigel = new UserEntity("gigel", "gigel@gmail.com", "pass");
        userRepository.create(gigel);
    }
    private static void changePassword(){
        UserRepository userRepository = new UserRepository();
        UserEntity richard = new UserEntity("richard", "richard16@gmail.com", "JtHRF8");
        userRepository.changePassword("mere@gmail.com", "JtHRF8", "mere", "mere"); //mail does not exist
        userRepository.changePassword("richard16@gmail.com", "mere", "mere", "mere"); //old pass is not correct
        userRepository.changePassword("richard16@gmail.com", "JtHRF8", "mere", "pere"); //new passwords don't match
        //userRepository.changePassword("richard16@gmail.com", "JtHRF8", "mere", "mere"); //working
    }
    private static void makeFriends(){
        UserRepository userRepository = new UserRepository();
        UserEntity richard = new UserEntity("richard", "richard16@gmail.com", "JtHRF8");
        UserEntity emily = new UserEntity("emily", "emily278@gmail.com", "2gXTKMbtwj");
        UserEntity jennifer = new UserEntity("jennifer", "jennifer77@gmail.com", "cYPD3");
        UserEntity charlie = new UserEntity("charlie", "charlie66@gmail.com", "p5TAC");
        UserEntity michael = new UserEntity("michael", "miki9@gmail.com", "hi8Rt");
        userRepository.makeFriend("richard", "emily");
        userRepository.makeFriend("richard", "jennifer");
        userRepository.makeFriend("emily", "michael");
        userRepository.makeFriend("emily", "charlie");
        userRepository.makeFriend("jennifer", "michael");
        userRepository.makeFriend("jennifer", "charlie");
        userRepository.recommend(richard.getUsername());
    }
    private static void generateQuestionsPoints(){
        UserRepository userRepository = new UserRepository();
        UserEntity richard = new UserEntity("richard", "richard16@gmail.com", "JtHRF8");
        userRepository.generateQuestions(richard);
    }
    private static void selectTopFourScores(){
        UserRepository userRepository = new UserRepository();
        UserEntity richard = new UserEntity("richard", "richard16@gmail.com", "JtHRF8");
        userRepository.generateQuestions(richard);
        userRepository.showTopFour(richard);
    }

}
