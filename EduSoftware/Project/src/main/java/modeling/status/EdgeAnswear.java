package modeling.status;

import com.fasterxml.jackson.annotation.JsonIgnore;
import com.fasterxml.jackson.annotation.JsonProperty;

import java.awt.*;

public class EdgeAnswear {
    private int nodeLeftPoz;
    private int nodeRightPoz;
    @JsonIgnore
    private Color edgeColor;
    @JsonProperty("modified")
    private boolean isModified;
    private String colourString;
    public EdgeAnswear(){}
    public EdgeAnswear(int nodeLeftPoz, int nodeRightPoz, Color edgeColor, boolean isModified) {
        this.nodeLeftPoz = nodeLeftPoz;
        this.nodeRightPoz = nodeRightPoz;
        this.edgeColor = edgeColor;
        this.isModified = isModified;
        if (edgeColor == Color.BLACK)
            colourString = "BLACK";
        else if (edgeColor == Color.GREEN)
            colourString = "GREEN";
        else if (edgeColor == Color.RED)
            colourString = "RED";
        else if (edgeColor == Color.BLUE)
            colourString = "BLUE";
    }

    @Override
    public String toString() {
        return "EdgeAnswear{" +
                "nodeLeftPoz=" + nodeLeftPoz +
                ", nodeRightPoz=" + nodeRightPoz +
                ", edgeColor=" + edgeColor +
                ", isModified=" + isModified +
                '}';
    }

    public String getColourString() {
        return colourString;
    }

    public int getNodeLeftPoz() {
        return nodeLeftPoz;
    }

    public int getNodeRightPoz() {
        return nodeRightPoz;
    }

    public Color getEdgeColor() {
        return edgeColor;
    }

    public boolean isModified() {
        return isModified;
    }
}
