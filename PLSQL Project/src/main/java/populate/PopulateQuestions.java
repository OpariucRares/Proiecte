package populate;

import entity.Question;
import repository.QuestionRepository;

import java.io.BufferedReader;
import java.io.File;
import java.io.FileReader;
import java.io.IOException;

public class PopulateQuestions {
    public void execute(){
        QuestionRepository questionCommand = new QuestionRepository();
        try {
            String sursa = "src/main/java/questions.txt";
            File file = new File(sursa);
            BufferedReader br = new BufferedReader(new FileReader(sursa));
            String line; //linia pe care o citesti
            String domain = null; //domeniul intrebarilor
            String question;
            String var1;
            String var2;
            String var3;
            String var4;
            String varGood;
            int points;
            do {
                line = br.readLine();
                if (line == null) break;
                if (line.startsWith("D: ")) {
                    //domain
                    domain = line.substring(3);
                    continue;
                }
                //question
                question = line;
                //variante pentru intrebari
                var1 = br.readLine();
                var2 = br.readLine();
                var3 = br.readLine();
                var4 = br.readLine();
                varGood = br.readLine();
                points = 1;
                if (var1 == null) break;
                Question question1 = new Question(domain, question, var1, var2, var3, var4, varGood, points);
                questionCommand.create(question1);
            }
            while (true);
            br.close();
        }
        catch (IOException e) {
            e.printStackTrace();
        }
    }
}
