package populate;

import entity.Question;
import entity.UserEntity;
import repository.QuestionRepository;
import repository.UserRepository;

import java.io.BufferedReader;
import java.io.File;
import java.io.FileReader;
import java.io.IOException;

public class PopulateUsers {
    public void execute(){
        UserRepository userRepository = new UserRepository();
        try {
            String sursa = "src/main/java/users.txt";
            File file = new File(sursa);
            BufferedReader br = new BufferedReader(new FileReader(sursa));
            String line; //linia pe care o citesti
            String username;
            String email;
            String password;
            do {
                line = br.readLine();
                if (line == null) break;
                username = line;
                email = br.readLine();
                password = br.readLine();
                userRepository.create(new UserEntity(username, email, password));

            }
            while (true);
            br.close();
        }
        catch (IOException e) {
            e.printStackTrace();
        }
    }
}
