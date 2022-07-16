package algorithms;

import components.EdgeComponent;
import components.NodeComponent;
import modeling.problems.ProblemBFSandDFS;
import modeling.solutions.SolutionDFS;
import modeling.status.EdgeAnswear;
import modeling.status.NodeAnswear;
import modeling.status.VisitedAnswear;

import java.awt.*;
import java.util.ArrayList;
import java.util.HashSet;
import java.util.List;
import java.util.Set;

public class DFSAlgorithm extends AbstractAlgorithm<ProblemBFSandDFS, SolutionDFS>{
    private List<String> messagesForUser = new ArrayList<>();
    private List<NodeAnswear> modifiedNodeComponents = new ArrayList<>();
    private List<EdgeAnswear> modifiedEdgeComponents = new ArrayList<>();
    private List<VisitedAnswear> visitedNodesCommands = new ArrayList<>();
    private List<Integer> listSolution = new ArrayList<>();
    NodeAnswear nodeNotModified = new NodeAnswear(-1, Color.black, false);
    EdgeAnswear edgeNotModified = new EdgeAnswear(-1, -1, Color.black, false);
    VisitedAnswear visitedNotModified = new VisitedAnswear(-1, false,false);

    @Override
    public SolutionDFS solve(ProblemBFSandDFS problemBFSandDFS) {


        Set<EdgeComponent> listOfEdges = new HashSet<>();
        List<NodeComponent> listOfNodes = new ArrayList<>(problemBFSandDFS.getGraphProblem());
        for(NodeComponent nodeCollector : problemBFSandDFS.getGraphProblem()){
            listOfEdges.addAll(nodeCollector.getEdges());
        }
        NodeComponent startNodeComponent = problemBFSandDFS.getStartingNode();
        int indexNodeStart = problemBFSandDFS.findIndexNode(startNodeComponent);
        boolean[] visited = problemBFSandDFS.getVisited();

        addAllCommands("EMPTY", new NodeAnswear(indexNodeStart, Color.BLACK, true), edgeNotModified, new VisitedAnswear(indexNodeStart, false, true));
        functionDFS(problemBFSandDFS, indexNodeStart, visited);
        addAllCommands("Done! The solution is showed.", nodeNotModified, edgeNotModified, visitedNotModified);

        SolutionDFS solutionDFS = new SolutionDFS(messagesForUser, modifiedNodeComponents, modifiedEdgeComponents, listOfNodes, listOfEdges, visitedNodesCommands, listSolution);
        return solutionDFS;
    }
    private void functionDFS(ProblemBFSandDFS problemBFSandDFS, int indexNode, boolean[] visitedNodes){
        addAllCommands("EMPTY", new NodeAnswear(indexNode, Color.BLACK, true), edgeNotModified, new VisitedAnswear(indexNode, false, true));
        addAllCommands("We visit the node!", new NodeAnswear(indexNode, Color.BLUE, true), edgeNotModified, new VisitedAnswear(indexNode, true, true));
        visitedNodes[indexNode] = true;
        NodeComponent nodeComponentCopy = problemBFSandDFS.getGraphProblem().get(indexNode);
        listSolution.add(indexNode);
        for(NodeComponent adjacentNodes : nodeComponentCopy.getAdjacentNodes()){
            int indexAdjacentNodes = problemBFSandDFS.findIndexNode(adjacentNodes);
            if (visitedNodes[indexAdjacentNodes])
                addAllCommands("EMPTY", new NodeAnswear(indexAdjacentNodes, Color.BLUE, true), new EdgeAnswear(indexNode, indexAdjacentNodes, Color.BLACK, true), visitedNotModified);
            else
                addAllCommands("EMPTY", new NodeAnswear(indexAdjacentNodes, Color.BLACK, true), new EdgeAnswear(indexNode, indexAdjacentNodes, Color.BLACK, true), visitedNotModified);

            addAllCommands("We check if the adjacent node is visited!", new NodeAnswear(indexAdjacentNodes, Color.RED, true), new EdgeAnswear(indexNode, indexAdjacentNodes, Color.RED, true), visitedNotModified);
            if (!visitedNodes[indexAdjacentNodes]) {

                addAllCommands("We continue the search with the node " + adjacentNodes.getName() + "!", new NodeAnswear(indexAdjacentNodes, Color.GREEN, true), new EdgeAnswear(indexNode, indexAdjacentNodes, Color.BLACK, true), visitedNotModified);

                functionDFS(problemBFSandDFS, indexAdjacentNodes, visitedNodes);
            }
            else{
                addAllCommands("The node is already visited!", new NodeAnswear(indexAdjacentNodes, Color.BLUE, true), edgeNotModified, visitedNotModified);
            }
            addAllCommands("EMPTY", nodeNotModified, new EdgeAnswear(indexNode, indexAdjacentNodes, Color.BLACK, true), visitedNotModified);

        }
    }
    private void addAllCommands(String userMessage, NodeAnswear nodeCommand, EdgeAnswear edgeCommand,
                                VisitedAnswear visitedCommand){
        this.messagesForUser.add(userMessage);
        this.modifiedNodeComponents.add(nodeCommand);
        this.modifiedEdgeComponents.add(edgeCommand);
        this.visitedNodesCommands.add(visitedCommand);

    }
}
