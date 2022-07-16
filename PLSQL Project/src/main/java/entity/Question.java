package entity;


import java.util.Objects;

public class Question extends AbstractEntity{
    private long id;

    public Question(String domain, String questions,
                    String var1, String var2, String var3, String var4, String varGood, int points) {
        this.domain = domain;
        this.questions = questions;
        this.var1 = var1;
        this.var2 = var2;
        this.var3 = var3;
        this.var4 = var4;
        this.varGood = varGood;
        this.points = points;
    }

    private String domain;
    private String questions;
    private String var1;
    private String var2;
    private String var3;
    private String var4;
    private String varGood;
    private Integer points;

    public Question() {

    }

    public long getId() {
        return id;
    }

    public void setId(long id) {
        this.id = id;
    }

    public String getDomain() {
        return domain;
    }

    public void setDomain(String domain) {
        this.domain = domain;
    }

    public String getQuestions() {
        return questions;
    }

    public void setQuestions(String questions) {
        this.questions = questions;
    }

    public String getVar1() {
        return var1;
    }

    public void setVar1(String var1) {
        this.var1 = var1;
    }

    public String getVar2() {
        return var2;
    }

    public void setVar2(String var2) {
        this.var2 = var2;
    }

    public String getVar3() {
        return var3;
    }

    public void setVar3(String var3) {
        this.var3 = var3;
    }

    public String getVar4() {
        return var4;
    }

    public void setVar4(String var4) {
        this.var4 = var4;
    }

    public String getVarGood() {
        return varGood;
    }

    public void setVarGood(String varGood) {
        this.varGood = varGood;
    }

    public int getPoints() {
        return points;
    }

    public void setPoints(int points) {
        this.points = points;
    }

}
