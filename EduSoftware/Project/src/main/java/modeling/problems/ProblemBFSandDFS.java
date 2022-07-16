package modeling.problems;

import components.NodeComponent;

import java.util.Arrays;
import java.util.List;

public class ProblemBFSandDFS extends Problem{
    private boolean[] visited;
    private NodeComponent startingNode;
    /**
     * @param graphProblem - the input with the nodes. They will have the adjacent nodes and the edges.
     */
    public ProblemBFSandDFS(List<NodeComponent> graphProblem, NodeComponent startingNode) {
        super(graphProblem);
        this.startingNode = startingNode;
        int numberOfNodes = graphProblem.size();
        visited = new boolean[numberOfNodes];
        Arrays.fill(visited, false);
    }

    public boolean[] getVisited() {
        return visited;
    }

    public void setVisited(boolean[] visited) {
        this.visited = visited;
    }

    public NodeComponent getStartingNode() {
        return startingNode;
    }

    public void setStartingNode(NodeComponent startingNode) {
        this.startingNode = startingNode;
    }
}
