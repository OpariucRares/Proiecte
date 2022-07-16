package components;

import com.fasterxml.jackson.annotation.JsonIdentityInfo;
import com.fasterxml.jackson.annotation.JsonIgnore;
import com.fasterxml.jackson.annotation.ObjectIdGenerators;

import java.awt.*;
import java.io.Serializable;

@JsonIdentityInfo(
        generator = ObjectIdGenerators.UUIDGenerator.class,
        property = "@json_id"
)
public class EdgeComponent{


    private NodeComponent left;
    private NodeComponent right;
    private int costEdge;
    private boolean isDirected;

    //coordinates for the drawing line and the colour
    @JsonIgnore
    private Color colourEdge;
    private String colourString;
    private int leftPointX;
    private int leftPointY;
    private int rightPointX;
    private int rightPointY;

    /**
     * It will create the edge which will be drawn. The coordinates of the line are the coordinate of the center of the circle.
     * @param left - the starting node will be on the left edge
     * @param right - the final node will be on the right edge
     * @param costEdge - this will be the cost of the edge
     * @param isDirected - this will decide if the edge will have an arrow or not
     */
    public EdgeComponent(NodeComponent left, NodeComponent right, int costEdge, boolean isDirected, Color colourEdge){
        this.left = left;
        this.right = right;
        this.costEdge = costEdge;
        this.isDirected = isDirected;
        this.colourEdge = colourEdge;
        this.leftPointX = left.getCoordinateX();
        this.leftPointY = left.getCoordinateY();
        this.rightPointX = right.getCoordinateX();
        this.rightPointY = right.getCoordinateY();
        if (colourEdge == Color.black)
            this.colourString = "BLACK";
        else if (colourEdge == Color.BLUE)
            this.colourString = "BLUE";
        else if (colourEdge == Color.RED)
            this.colourString = "RED";
        else if (colourEdge == Color.GREEN)
            this.colourString = "GREEN";
    }
    public EdgeComponent(){
    }

    public String getColourString() {
        return colourString;
    }

    public NodeComponent getLeft() {
        return left;
    }

    public NodeComponent getRight() {
        return right;
    }

    public int getCostEdge() {
        return costEdge;
    }

    public void setCostEdge(int costEdge) {
        this.costEdge = costEdge;
    }

    public boolean isDirected() {
        return isDirected;
    }

    public void setDirected(boolean directed) {
        isDirected = directed;
    }

    public Color getColourEdge() {
        return colourEdge;
    }

    public void setColourEdge(Color colourEdge) {
        this.colourEdge = colourEdge;
        if (colourEdge == Color.black)
            this.colourString = "BLACK";
        else if (colourEdge == Color.BLUE)
            this.colourString = "BLUE";
        else if (colourEdge == Color.RED)
            this.colourString = "RED";
        else if (colourEdge == Color.GREEN)
            this.colourString = "GREEN";
    }

    public int getLeftPointX() {
        return leftPointX;
    }

    public void setLeftPointX(int leftPointX) {
        this.leftPointX = leftPointX;
    }

    public int getLeftPointY() {
        return leftPointY;
    }

    public void setLeftPointY(int leftPointY) {
        this.leftPointY = leftPointY;
    }

    public int getRightPointX() {
        return rightPointX;
    }

    public void setRightPointX(int rightPointX) {
        this.rightPointX = rightPointX;
    }

    public int getRightPointY() {
        return rightPointY;
    }

    public void setRightPointY(int rightPointY) {
        this.rightPointY = rightPointY;
    }

    @Override
    public String toString() {
        StringBuilder sb = new StringBuilder();
        sb.append("Edge: Node left -> ");
        sb.append(left.getName());
        sb.append(" Node right -> ");
        sb.append(right.getName());
        sb.append(" Cost -> ");
        sb.append(costEdge);
        return sb.toString();
    }
}
