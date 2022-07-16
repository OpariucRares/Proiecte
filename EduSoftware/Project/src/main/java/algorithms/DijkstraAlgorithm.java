package algorithms;

import components.EdgeComponent;
import components.NodeComponent;
import modeling.problems.ProblemDijkstraPrim;
import modeling.solutions.SolutionDijkstra;
import modeling.status.*;

import java.awt.*;
import java.util.*;
import java.util.List;

public class DijkstraAlgorithm extends AbstractAlgorithm<ProblemDijkstraPrim, SolutionDijkstra>{

    private List<String> messagesForUser = new ArrayList<>();
    private List<NodeAnswear> modifiedNodeComponents = new ArrayList<>();
    private List<EdgeAnswear> modifiedEdgeComponents = new ArrayList<>();
    private List<VisitedAnswear> visitedNodesCommands = new ArrayList<>();
    private List<DistanceAnswear> distancesCommands = new ArrayList<>();
    private List<PathAnswear> pathCommands = new ArrayList<>();

    /**
     * The algorithm will resolve the input and send the commands to the user.
     * @param problemDijkstraPrim - the input problem
     * @return - the solution of the problem which will be outputted for the user
     */
    @Override
    public SolutionDijkstra solve(ProblemDijkstraPrim problemDijkstraPrim) {

        NodeAnswear nodeNotModified = new NodeAnswear(-1, Color.black, false);
        EdgeAnswear edgeNotModified = new EdgeAnswear(-1, -1, Color.black, false);
        VisitedAnswear visitedNotModified = new VisitedAnswear(-1, false,false);
        DistanceAnswear distanceNotModified = new DistanceAnswear(-1, -1, false);
        PathAnswear pathNotModified = new PathAnswear(-1, -1, false);

        Set<EdgeComponent> listOfEdges = new HashSet<>();
        List<NodeComponent> listOfNodes = new ArrayList<>(problemDijkstraPrim.getGraphProblem());
        for(NodeComponent nodeCollector : problemDijkstraPrim.getGraphProblem()){
            listOfEdges.addAll(nodeCollector.getEdges());
        }
        NodeComponent nodeStartComponent = problemDijkstraPrim.getStartingNode();
        int[] distances = problemDijkstraPrim.getDistances();
        boolean[] visitedNode = problemDijkstraPrim.getVisitedNode();
        int[] pathNodeStart = problemDijkstraPrim.getPathNodeStart();
        PriorityQueue<Integer> pqNodeComponents = problemDijkstraPrim.getPqNodeComponents();

        int indexGarbage = problemDijkstraPrim.findIndexNode(nodeStartComponent);
        addAllCommands("EMPTY", new NodeAnswear(indexGarbage, Color.BLACK, true), edgeNotModified, visitedNotModified, new DistanceAnswear(indexGarbage, Integer.MAX_VALUE, true), pathNotModified);

        addAllCommands("Mark the beginning node " + nodeStartComponent.getName() + " with distance 0!", new NodeAnswear(indexGarbage, Color.GREEN, true), edgeNotModified, visitedNotModified, new DistanceAnswear(indexGarbage, 0, true), pathNotModified);

        while(!pqNodeComponents.isEmpty()){

            int indexOfNewNode = pqNodeComponents.peek();
            pqNodeComponents.remove();
            visitedNode[indexOfNewNode] = true;

            //we get the node from the pk, now we modify the values
            addAllCommands("Find the cheapest unknown vertex", new NodeAnswear(indexOfNewNode, Color.BLACK, true), edgeNotModified, visitedNotModified, distanceNotModified, pathNotModified);
            NodeComponent nodeBeginDK = problemDijkstraPrim.getGraphProblem().get(indexOfNewNode);
            addAllCommands("Cheapest Unknown vertex is " + nodeBeginDK.getName(), new NodeAnswear(indexOfNewNode, Color.RED, true), edgeNotModified,  new VisitedAnswear(indexOfNewNode, false, true), distanceNotModified, pathNotModified);
            addAllCommands("Visit the node", new NodeAnswear(indexOfNewNode, Color.BLUE, true), edgeNotModified, new VisitedAnswear(indexOfNewNode, true, true), distanceNotModified, pathNotModified);

            //find the node with the shortest path from the edges
            int indexOfNeighbourNode = -1;
            for(EdgeComponent edgeStartWithBeginDK: nodeBeginDK.getEdges()){

                indexOfNeighbourNode = problemDijkstraPrim.findIndexNode(edgeStartWithBeginDK.getRight());
                addAllCommands("EMPTY", nodeNotModified, new EdgeAnswear(indexOfNewNode, indexOfNeighbourNode, Color.BLACK, true), visitedNotModified, distanceNotModified, pathNotModified);

                addAllCommands("Check if the node is visited " + edgeStartWithBeginDK.getRight().getName(), nodeNotModified, new EdgeAnswear(indexOfNewNode, indexOfNeighbourNode, Color.RED, true), visitedNotModified, distanceNotModified, pathNotModified);

                if (!visitedNode[indexOfNeighbourNode]){
                    if (distances[indexOfNeighbourNode] == Integer.MAX_VALUE)
                        addAllCommands("Check if we can modify the distance", nodeNotModified, edgeNotModified, visitedNotModified, new DistanceAnswear(indexOfNeighbourNode, Integer.MAX_VALUE, true) , new PathAnswear(indexOfNeighbourNode, pathNodeStart[indexOfNeighbourNode], true));
                    else
                        addAllCommands("Check if we can modify the distance", nodeNotModified, edgeNotModified, visitedNotModified, new DistanceAnswear(indexOfNeighbourNode, distances[indexOfNeighbourNode], true) , new PathAnswear(indexOfNeighbourNode, pathNodeStart[indexOfNeighbourNode], true));
                    if (distances[indexOfNeighbourNode] > distances[indexOfNewNode] + edgeStartWithBeginDK.getCostEdge()){

                        distances[indexOfNeighbourNode] = distances[indexOfNewNode] + edgeStartWithBeginDK.getCostEdge();
                        pqNodeComponents.add(indexOfNeighbourNode);
                        pathNodeStart[indexOfNeighbourNode] = indexOfNewNode;
                        addAllCommands("New distance!", nodeNotModified, new EdgeAnswear(indexOfNewNode, indexOfNeighbourNode, Color.RED, true), visitedNotModified, new DistanceAnswear(indexOfNeighbourNode, distances[indexOfNeighbourNode], true), new PathAnswear(indexOfNeighbourNode, pathNodeStart[indexOfNeighbourNode], true));
                    }
                }
                else{
                    addAllCommands("The node " + edgeStartWithBeginDK.getRight().getName() + " is already visited ", nodeNotModified, new EdgeAnswear(indexOfNewNode, indexOfNeighbourNode, Color.BLACK, true), visitedNotModified, distanceNotModified, pathNotModified);

                }
                addAllCommands("EMPTY", nodeNotModified, new EdgeAnswear(indexOfNewNode, indexOfNeighbourNode, Color.BLACK, true), visitedNotModified, distanceNotModified, pathNotModified);

            }
        }
        addAllCommands("Done! The solution is showed.", nodeNotModified, edgeNotModified, visitedNotModified, distanceNotModified,  pathNotModified);


        List<List<String>> allPathsFromNodeStart = new ArrayList<>();
        for(int i = 0; i < pathNodeStart.length; ++i){
            int j = i;
            List<String> copyPath = new ArrayList<>();
            while (pathNodeStart[j] != -1){
                copyPath.add(problemDijkstraPrim.getGraphProblem().get(j).getName());
                j = pathNodeStart[j];
            }
            copyPath.add(nodeStartComponent.getName());
            allPathsFromNodeStart.add(copyPath);
        }
        SolutionDijkstra solDijkstra = new SolutionDijkstra(messagesForUser, modifiedNodeComponents, modifiedEdgeComponents, listOfNodes, listOfEdges,visitedNodesCommands, distancesCommands, pathCommands, allPathsFromNodeStart);
        return solDijkstra;
    }

    private void addAllCommands(String userMessage, NodeAnswear nodeAnswear, EdgeAnswear edgeAnswear,
                                VisitedAnswear visitedAnswear, DistanceAnswear distanceAnswear, PathAnswear pathAnswear){
        this.messagesForUser.add(userMessage);
        this.modifiedNodeComponents.add(nodeAnswear);
        this.modifiedEdgeComponents.add(edgeAnswear);
        this.visitedNodesCommands.add(visitedAnswear);
        this.distancesCommands.add(distanceAnswear);
        this.pathCommands.add(pathAnswear);

    }
}
