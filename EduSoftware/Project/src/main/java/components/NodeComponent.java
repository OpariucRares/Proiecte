package components;


import com.fasterxml.jackson.annotation.*;
import com.fasterxml.jackson.databind.annotation.JsonSerialize;

import java.awt.*;
import java.util.ArrayList;
import java.util.List;
import java.util.Objects;

@JsonSerialize(using = NodeComponentSerializer.class)
public class NodeComponent{

    private String name;
    @JsonProperty("Adjacent nodes")
    private final List<NodeComponent> adjacentNodes = new ArrayList<>();
    @JsonProperty("Edges")
    private final List<EdgeComponent> edges = new ArrayList<>();

    private int coordinateX;
    private int coordinateY;
    private int radiusCircle;
    @JsonIgnore
    private Color colourCircle;
    private String colourString;

    /**
     * @param name - name of the node
     * @param coordinateX - coordinates on the X axis for Java swing
     * @param coordinateY - coordinates on the Y axis for Java swing
     * @param radiusCircle - radius of the circle
     * @param colourCircle - this will be the colour of the circle
     */
    public NodeComponent(String name, int coordinateX, int coordinateY, int radiusCircle, Color colourCircle) {
        this.name = name;
        this.coordinateX = coordinateX;
        this.coordinateY = coordinateY;
        this.radiusCircle = radiusCircle;
        this.colourCircle = colourCircle;
        if (colourCircle == Color.BLACK)
            this.colourString = "BLACK";
        else if (colourCircle == Color.BLUE)
            this.colourString = "BLUE";
        else if (colourCircle == Color.RED)
            this.colourString = "RED";
        else if (colourCircle == Color.GREEN)
            this.colourString = "GREEN";
    }

    public NodeComponent() {

    }

    /**
     * This method adds to the current nodes the adjacent nodes and the edges. If we need for an undirected graph, we swap the nodes.
     * @param nodeComponent - the adjacent node that will be added to the current node
     * @param edgeComponent - the edge with the cost. If the cost is not initialized, it should be 0
     */
    public void addAdjacentNodes(NodeComponent nodeComponent, EdgeComponent edgeComponent){
        adjacentNodes.add(nodeComponent);
        edges.add(edgeComponent);
    }


    public String getColourString() {
        return colourString;
    }

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    public List<NodeComponent> getAdjacentNodes() {
        return adjacentNodes;
    }

    public List<EdgeComponent> getEdges() {
        return edges;
    }

    public int getCoordinateX() {
        return coordinateX;
    }

    public void setCoordinateX(int coordinateX) {
        this.coordinateX = coordinateX;
    }
    public void setCoordinateY(int coordinateY) {
        this.coordinateY = coordinateY;
    }

    public void setRadiusCircle(int radiusCircle) {
        this.radiusCircle = radiusCircle;
    }
    public int getCoordinateY() {
        return coordinateY;
    }


    public int getRadiusCircle() {
        return radiusCircle;
    }



    public Color getColourCircle() {
        return colourCircle;
    }

    public void setColourCircle(Color colourCircle) {
        this.colourCircle = colourCircle;
        if (colourCircle == Color.BLACK)
            this.colourString = "BLACK";
        else if (colourCircle == Color.BLUE)
            this.colourString = "BLUE";
        else if (colourCircle == Color.RED)
            this.colourString = "RED";
        else if (colourCircle == Color.GREEN)
            this.colourString = "GREEN";
    }


    @Override
    public String toString() {
        StringBuilder sb = new StringBuilder();
        sb.append("Name node: ");
        sb.append(name);
        sb.append(" | Adjacent nodes: ");
        for(NodeComponent nodeComponent : adjacentNodes){
            sb.append(nodeComponent.getName());
            sb.append(" ");
        }
        sb.append("\nEdges: ");
        for(EdgeComponent edgeComponent : edges){
            sb.append("\nNode one: ");
            sb.append(edgeComponent.getLeft().getName());
            sb.append(" ");
            sb.append("Node two: ");
            sb.append(edgeComponent.getRight().getName());
            sb.append(" Cost: ");
            sb.append(edgeComponent.getCostEdge());
        }
        sb.append("\n");
        return sb.toString();
    }

    @Override
    public boolean equals(Object o) {
        if (this == o) return true;
        if (o == null || getClass() != o.getClass()) return false;
        NodeComponent that = (NodeComponent) o;
        return coordinateX == that.coordinateX && coordinateY == that.coordinateY && radiusCircle == that.radiusCircle && Objects.equals(name, that.name) && Objects.equals(adjacentNodes, that.adjacentNodes) && Objects.equals(edges, that.edges) && Objects.equals(colourCircle, that.colourCircle);
    }

    @Override
    public int hashCode() {
        return Objects.hash(name, adjacentNodes, edges, coordinateX, coordinateY, radiusCircle, colourCircle);
    }
}
