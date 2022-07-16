package modeling.solutions;

import components.EdgeComponent;
import components.NodeComponent;
import modeling.status.*;

import java.util.List;
import java.util.Set;

public class SolutionDijkstra extends Solution{
    private List<VisitedAnswear> visitedNodesCommands;
    private List<DistanceAnswear> distancesCommands;
    private List<PathAnswear> pathCommands;
    private List<List<String>> allPathsFromNodeStart;
    public SolutionDijkstra(){}
    public SolutionDijkstra(List<String> messagesForUser, List<NodeAnswear> modifiedNodeComponents,
                            List<EdgeAnswear> modifiedEdgeComponents, List<NodeComponent> listOfNodes,
                            Set<EdgeComponent> listOfEdges, List<VisitedAnswear> visitedNodesCommands,
                            List<DistanceAnswear> distancesCommands, List<PathAnswear> pathCommands,
                            List<List<String>> allPathsFromNodeStart) {
        super(messagesForUser, modifiedNodeComponents, modifiedEdgeComponents, listOfNodes, listOfEdges);
        this.visitedNodesCommands = visitedNodesCommands;
        this.distancesCommands = distancesCommands;
        this.pathCommands = pathCommands;
        this.allPathsFromNodeStart = allPathsFromNodeStart;
    }

    public String showSolution(){
        StringBuilder sb = new StringBuilder();
        for(List<String> positionSolution : allPathsFromNodeStart){
            for(String ansSol : positionSolution){
                sb.append(ansSol);
                sb.append(" ");
            }
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
    public List<PathAnswear> getPathCommands() {
        return pathCommands;
    }
    public List<DistanceAnswear> getDistancesCommands() {
        return distancesCommands;
    }

    public List<List<String>> getAllPathsFromNodeStart() {
        return allPathsFromNodeStart;
    }
}
