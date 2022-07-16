package algorithms;

import modeling.solutions.Solution;

public abstract class AbstractAlgorithm<Problem, Solution>{
    /**
     * Every algorithm will be extended to this class and have this abstract method which will solve the graph.
     * @return - it will return an object of type Solution
     */
    public abstract Solution solve(Problem problem);
}
