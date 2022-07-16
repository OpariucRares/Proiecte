package algorithms;

import components.EdgeComponent;
import components.NodeComponent;
import modeling.problems.ProblemBFSandDFS;
import modeling.solutions.SolutionBFS;
import modeling.status.*;

import java.awt.*;
import java.util.*;
import java.util.List;

public class BFSAlgorithm extends AbstractAlgorithm<ProblemBFSandDFS, SolutionBFS>{
    private List<String> messagesForUser = new ArrayList<>();
    private List<NodeAnswear> modifiedNodeComponents = new ArrayList<>();
    private List<EdgeAnswear> modifiedEdgeComponents = new ArrayList<>();
    private List<VisitedAnswear> visitedNodesCommands = new ArrayList<>();
    private List<QueueAnswear> bfsQueue = new ArrayList<>();
    private List<Integer> solutionListNodes = new ArrayList<>();

    @Override
    public SolutionBFS solve(ProblemBFSandDFS problemBFSandDFS) {
        NodeAnswear nodeNotModified = new NodeAnswear(-1, Color.black, false);
        EdgeAnswear edgeNotModified = new EdgeAnswear(-1, -1, Color.black, false);
        VisitedAnswear visitedNotModified = new VisitedAnswear(-1, false,false);
        QueueAnswear queueNodModified = new QueueAnswear(-1, false, false);

        Set<EdgeComponent> listOfEdges = new HashSet<>();
        List<NodeComponent> listOfNodes = new ArrayList<>(problemBFSandDFS.getGraphProblem());
        for(NodeComponent nodeCollector : problemBFSandDFS.getGraphProblem()){
            listOfEdges.addAll(nodeCollector.getEdges());
        }
        List<Integer> listSolution = new ArrayList<>();
        Queue<Integer> queueNodes = new LinkedList<>();

        NodeComponent startNodeComponent = problemBFSandDFS.getStartingNode();
        int indexNodeStart = problemBFSandDFS.findIndexNode(startNodeComponent);
        boolean[] visited = problemBFSandDFS.getVisited();
        visited[indexNodeStart] = true;
        queueNodes.add(indexNodeStart);
        listSolution.add(indexNodeStart);

        addAllCommands("EMPTY", new NodeAnswear(indexNodeStart, Color.BLACK, true), edgeNotModified, visitedNotModified, new QueueAnswear(indexNodeStart, true, true));
        addAllCommands("We add the starting node in the queue! (" + startNodeComponent.getName() + ")", nodeNotModified, edgeNotModified, visitedNotModified, new QueueAnswear(indexNodeStart, false, true));

        while(!queueNodes.isEmpty()){

            indexNodeStart = queueNodes.poll();

            NodeComponent newNode = problemBFSandDFS.getGraphProblem().get(indexNodeStart);

            if (visited[indexNodeStart])
                addAllCommands("EMPTY", new NodeAnswear(indexNodeStart, Color.BLUE, true), edgeNotModified, new VisitedAnswear(indexNodeStart, true, true), queueNodModified);
            else
                addAllCommands("EMPTY", new NodeAnswear(indexNodeStart, Color.BLACK, true), edgeNotModified, new VisitedAnswear(indexNodeStart, false, true), queueNodModified);
            addAllCommands("We get the node from the queue -> " + newNode.getName(), new NodeAnswear(indexNodeStart, Color.GREEN, true), edgeNotModified, new VisitedAnswear(indexNodeStart, true, true), new QueueAnswear(indexNodeStart, true, true));
            addAllCommands("EMPTY", new NodeAnswear(indexNodeStart, Color.BLUE, true), edgeNotModified, visitedNotModified, queueNodModified);

            for(NodeComponent nodeAdjacent : newNode.getAdjacentNodes()){
                int indexAdjacentNode = problemBFSandDFS.findIndexNode(nodeAdjacent);
                if (visited[indexAdjacentNode])
                    addAllCommands("EMPTY", new NodeAnswear(indexAdjacentNode, Color.BLUE, true), new EdgeAnswear(indexNodeStart, indexAdjacentNode, Color.BLACK, true), visitedNotModified, queueNodModified);
                else
                    addAllCommands("EMPTY", new NodeAnswear(indexAdjacentNode, Color.BLACK, true), new EdgeAnswear(indexNodeStart, indexAdjacentNode, Color.BLACK, true), visitedNotModified, queueNodModified);

                addAllCommands("Check if the the node adjacent is visited", new NodeAnswear(indexAdjacentNode, Color.RED, true),new EdgeAnswear(indexNodeStart, indexAdjacentNode, Color.RED, true) , visitedNotModified, queueNodModified);

                if (!visited[indexAdjacentNode]){
                    addAllCommands("EMPTY", nodeNotModified,edgeNotModified, new VisitedAnswear(indexAdjacentNode, false, true),new QueueAnswear(indexAdjacentNode, true, true));

                    addAllCommands("The node is now visited. We add it to the queue!",  new NodeAnswear(indexAdjacentNode, Color.BLUE, true), edgeNotModified, new VisitedAnswear(indexAdjacentNode, true, true), new QueueAnswear(indexAdjacentNode, false, true));
                    visited[indexAdjacentNode] = true;
                    listSolution.add(indexAdjacentNode);
                    queueNodes.add(indexAdjacentNode);
                }
                else {
                    addAllCommands("The node is already visited", new NodeAnswear(indexAdjacentNode, Color.BLUE, true), new EdgeAnswear(indexNodeStart, indexAdjacentNode, Color.BLACK, true), visitedNotModified, queueNodModified);
                }
                addAllCommands("EMPTY", nodeNotModified,new EdgeAnswear(indexNodeStart, indexAdjacentNode, Color.BLACK, true),new VisitedAnswear(indexAdjacentNode, true, true), queueNodModified);

            }
        }
        addAllCommands("Done! The solution is showed.", nodeNotModified, edgeNotModified, visitedNotModified, queueNodModified);

        SolutionBFS solutionBFS = new SolutionBFS(messagesForUser, modifiedNodeComponents, modifiedEdgeComponents, listOfNodes, listOfEdges, visitedNodesCommands, bfsQueue, listSolution);
        return solutionBFS;
    }

    private void addAllCommands(String userMessage, NodeAnswear nodeCommand, EdgeAnswear edgeCommand,
                                VisitedAnswear visitedCommand, QueueAnswear bfsCommand){
        this.messagesForUser.add(userMessage);
        this.modifiedNodeComponents.add(nodeCommand);
        this.modifiedEdgeComponents.add(edgeCommand);
        this.visitedNodesCommands.add(visitedCommand);
        this.bfsQueue.add(bfsCommand);

    }


}
