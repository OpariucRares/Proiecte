package modeling.status;

import com.fasterxml.jackson.annotation.JsonIgnore;
import com.fasterxml.jackson.annotation.JsonProperty;

import java.awt.*;

public class NodeAnswear {
    @JsonProperty("numberPoz")
    private int numberPoz;
    @JsonIgnore
    private Color colourNode;
    @JsonProperty("modified")
    private boolean isModified;
    private String colourString;
    public NodeAnswear(){}
    public NodeAnswear(int numberPoz, Color colourNode, boolean isModified) {
        this.numberPoz = numberPoz;
        this.colourNode = colourNode;
        this.isModified = isModified;
        if (colourNode == Color.BLACK)
            colourString = "BLACK";
        else if (colourNode == Color.GREEN)
            colourString = "GREEN";
        else if (colourNode == Color.RED)
            colourString = "RED";
        else if (colourNode == Color.BLUE)
            colourString = "BLUE";
    }

    @Override
    public String toString() {
        return "NodeAnswear{" +
                "numberPoz=" + numberPoz +
                ", colourNode=" + colourNode +
                ", isModified=" + isModified +
                '}';
    }

    public String getColourString() {
        return colourString;
    }

    public int getNumberPoz() {
        return numberPoz;
    }

    public Color getColourNode() {
        return colourNode;
    }

    public boolean isModified() {
        return isModified;
    }
}
