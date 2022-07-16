package modeling.solutions;

import components.EdgeComponent;
import components.NodeComponent;
import modeling.status.*;

import java.util.List;
import java.util.Set;

public class SolutionPrim extends Solution{

    private List<VisitedAnswear> visitedNodesCommands;
    private List<DistanceAnswear> distancesCommands;
    private List<PathAnswear> pathCommands;
    private Set<EdgeComponent> edgesOfMST;

    public SolutionPrim(List<String> messagesForUser, List<NodeAnswear> modifiedNodeComponents,
                        List<EdgeAnswear> modifiedEdgeComponents, List<NodeComponent> listOfNodes,
                        Set<EdgeComponent> listOfEdges, List<VisitedAnswear> visitedNodesCommands,
                        List<DistanceAnswear> distancesCommands, List<PathAnswear> pathCommands, Set<EdgeComponent> edgesOfMST) {
        super(messagesForUser, modifiedNodeComponents, modifiedEdgeComponents, listOfNodes, listOfEdges);
        this.visitedNodesCommands = visitedNodesCommands;
        this.distancesCommands = distancesCommands;
        this.pathCommands = pathCommands;
        this.edgesOfMST = edgesOfMST;
    }

    public String showSolution(){
        StringBuilder sb = new StringBuilder();
        for(EdgeComponent edgeIndex : edgesOfMST){
            sb.append("Edge: ");
            sb.append(edgeIndex.getLeft().getName());
            sb.append(" ");
            sb.append(edgeIndex.getRight().getName());
            sb.append(" Cost: ");
            sb.append(edgeIndex.getCostEdge());
            sb.append("\n");
        }
        return sb.toString();
    }
    @Override
    public String toString() {
        StringBuilder sb = new StringBuilder();
        for(int i = 0; i < messagesForUser.size(); ++i){
            sb.append("User: ");
            sb.append(messagesForUser.get(i));
            sb.append(" Nodes: ");
            sb.append(modifiedNodeComponents.get(i));
            sb.append(" Edges: ");
            sb.append(modifiedEdgeComponents.get(i));
            sb.append(" Visited: ");
            sb.append(visitedNodesCommands.get(i));
            sb.append(" Distances: ");
            sb.append(distancesCommands.get(i));
            sb.append(" Path: ");
            sb.append(pathCommands.get(i));
            sb.append("\n");
        }
        return sb.toString();
    }

    public List<VisitedAnswear> getVisitedNodesCommands() {
        return visitedNodesCommands;
    }

    public List<DistanceAnswear> getDistancesCommands() {
        return distancesCommands;
    }

    public List<PathAnswear> getPathCommands() {
        return pathCommands;
    }

    public Set<EdgeComponent> getEdgesOfMST() {
        return edgesOfMST;
    }

    public void setEdgesOfMST(Set<EdgeComponent> edgesOfMST) {
        this.edgesOfMST = edgesOfMST;
    }
}
