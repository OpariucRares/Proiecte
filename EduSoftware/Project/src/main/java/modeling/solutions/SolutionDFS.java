package modeling.solutions;

import components.EdgeComponent;
import components.NodeComponent;
import modeling.status.EdgeAnswear;
import modeling.status.NodeAnswear;
import modeling.status.VisitedAnswear;

import java.util.List;
import java.util.Set;

public class SolutionDFS extends Solution{
    private List<VisitedAnswear> visitedNodesCommands;
    private List<Integer> solutionListNodes;

    public SolutionDFS(List<String> messagesForUser, List<NodeAnswear> modifiedNodeComponents,
                       List<EdgeAnswear> modifiedEdgeComponents, List<NodeComponent> listOfNodes,
                       Set<EdgeComponent> listOfEdges, List<VisitedAnswear> visitedNodesCommands,
                       List<Integer> solutionListNodes) {
        super(messagesForUser, modifiedNodeComponents, modifiedEdgeComponents, listOfNodes, listOfEdges);
        this.visitedNodesCommands = visitedNodesCommands;
        this.solutionListNodes = solutionListNodes;
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
            sb.append("\n");
        }
        return sb.toString();
    }
    public String showSolution(){
        StringBuilder sb = new StringBuilder();
        sb.append("Order of the nodes DFS: ");
        for(Integer indexNodeSolDFS : solutionListNodes){
            sb.append(indexNodeSolDFS);
            sb.append(" ");
        }
        return sb.toString();
    }

    public List<VisitedAnswear> getVisitedNodesCommands() {
        return visitedNodesCommands;
    }

    public List<Integer> getSolutionListNodes() {
        return solutionListNodes;
    }
}
