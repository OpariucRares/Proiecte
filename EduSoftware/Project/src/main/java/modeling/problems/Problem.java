package modeling.problems;


import components.NodeComponent;

import java.util.List;

public abstract class Problem {
    protected List<NodeComponent> graphProblem;

    /**
     *
     * @param graphProblem - the input with the nodes. They will have the adjacent nodes and the edges.
     */
    public Problem(List<NodeComponent> graphProblem){
        this.graphProblem = graphProblem;
    }

    public List<NodeComponent> getGraphProblem() {
        return graphProblem;
    }

    public void setGraphProblem(List<NodeComponent> graphProblem) {
        this.graphProblem = graphProblem;
    }
    public NodeComponent findNodeComponentByName(String nameNodeComponent){
        for(NodeComponent nodeComponent : graphProblem){
            if (nodeComponent.getName().equals(nameNodeComponent))
                return  nodeComponent;
        }
        return null;
    }
    public Integer findIndexNode(NodeComponent nodeComponent){
        for(int i = 0; i < graphProblem.size(); ++i)
            if (graphProblem.get(i).getName().equals(nodeComponent.getName()))
                return i;
        return -1;
    }

}
