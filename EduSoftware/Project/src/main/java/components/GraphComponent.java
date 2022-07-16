package components;

import com.fasterxml.jackson.databind.annotation.JsonDeserialize;

import java.util.ArrayList;
import java.util.List;

@JsonDeserialize(using = GraphComponentDeserializer.class)
public class GraphComponent {
    private boolean isUnidirected;
    private String typeAlgorithm;
    private List<NodeComponent> listOfNodesGraph = new ArrayList<>();
    public GraphComponent(List<NodeComponent> listOfNodesGraph, boolean isUnidirected, String typeAlgorithm){
        this.listOfNodesGraph = listOfNodesGraph;
        this.isUnidirected = isUnidirected;
        this.typeAlgorithm = typeAlgorithm;
    }
    public GraphComponent(){}

    public boolean isUnidirected() {
        return isUnidirected;
    }

    public void setUnidirected(boolean unidirected) {
        isUnidirected = unidirected;
    }

    public String getTypeAlgorithm() {
        return typeAlgorithm;
    }

    public void setTypeAlgorithm(String typeAlgorithm) {
        this.typeAlgorithm = typeAlgorithm;
    }

    public List<NodeComponent> getListOfNodesGraph() {
        return listOfNodesGraph;
    }

    public void setListOfNodesGraph(List<NodeComponent> listOfNodesGraph) {
        this.listOfNodesGraph = listOfNodesGraph;
    }

    @Override
    public String toString() {
        StringBuilder sb = new StringBuilder();
        sb.append("Undirected ");
        sb.append(this.isUnidirected);
        sb.append("\nType Algorithm ");
        sb.append(this.typeAlgorithm);
        sb.append("\n");
        for(NodeComponent nodeComponent : listOfNodesGraph){
            sb.append(nodeComponent.toString());
            sb.append("\n");
        }
        return sb.toString();
    }
}
