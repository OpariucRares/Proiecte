package modeling.problems;

import components.NodeComponent;

import java.util.*;

public class ProblemDijkstraPrim extends Problem{

    private int[] distances;
    private boolean[] visitedNode;
    private PriorityQueue<Integer> pqNodeComponents;
    private int[] pathNodeStart;

    private NodeComponent startingNode;
    /**
     * We create a priority queue for inserting
     * @param graphProblem - the input with the nodes. They will have the adjacent nodes and the edges.
     */
    public ProblemDijkstraPrim(List<NodeComponent> graphProblem, NodeComponent startingNode) {
        super(graphProblem);
        this.startingNode = startingNode;
        int numberNodes = graphProblem.size();
        distances = new int[numberNodes];
        visitedNode = new boolean[numberNodes];
        pathNodeStart = new int[numberNodes];
        pqNodeComponents = new PriorityQueue<>(new Comparator<>() {
            @Override
            public int compare(Integer indexNodeOne, Integer indexNodeTwo) {
                if (distances[indexNodeOne] > distances[indexNodeTwo])
                    return 1;
                if (distances[indexNodeOne] == distances[indexNodeTwo])
                    return 0;
                return -1;
            }
        });
        Arrays.fill(visitedNode, false);
        Arrays.fill(distances, Integer.MAX_VALUE);
        Arrays.fill(pathNodeStart, -1);

        int indexNodeStart = this.findIndexNode(startingNode);
        pqNodeComponents.add(indexNodeStart);
        distances[indexNodeStart] = 0;
    }

    public NodeComponent getStartingNode() {
        return startingNode;
    }

    public void setStartingNode(NodeComponent startingNode) {
        this.startingNode = startingNode;
    }

    public int[] getDistances() {
        return distances;
    }

    public void setDistances(int[] distances) {
        this.distances = distances;
    }

    public boolean[] getVisitedNode() {
        return visitedNode;
    }

    public void setVisitedNode(boolean[] visitedNode) {
        this.visitedNode = visitedNode;
    }

    public PriorityQueue<Integer> getPqNodeComponents() {
        return pqNodeComponents;
    }

    public void setPqNodeComponents(PriorityQueue<Integer> pqNodeComponents) {
        this.pqNodeComponents = pqNodeComponents;
    }

    public int[] getPathNodeStart() {
        return pathNodeStart;
    }

    public void setPathNodeStart(int[] pathNodeStart) {
        this.pathNodeStart = pathNodeStart;
    }
}
