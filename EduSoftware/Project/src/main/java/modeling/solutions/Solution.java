package modeling.solutions;

import com.fasterxml.jackson.annotation.JsonIgnore;
import com.fasterxml.jackson.annotation.JsonSubTypes;
import com.fasterxml.jackson.annotation.JsonTypeInfo;
import components.EdgeComponent;
import components.NodeComponent;
import modeling.status.EdgeAnswear;
import modeling.status.NodeAnswear;

import java.io.Serializable;
import java.util.List;
import java.util.Set;

@JsonTypeInfo( use = JsonTypeInfo.Id.NAME, property = "type")
@JsonSubTypes({
        @JsonSubTypes.Type(value = SolutionBFS.class, name = "solBFS"),
        @JsonSubTypes.Type(value = SolutionDFS.class, name = "solDFS"),
        @JsonSubTypes.Type(value = SolutionDijkstra.class, name = "solDijkstra"),
        @JsonSubTypes.Type(value = SolutionPrim.class, name = "solPrim")
})
public abstract class Solution implements Serializable {

    protected List<String> messagesForUser;
    protected List<NodeAnswear> modifiedNodeComponents;
    protected List<EdgeAnswear> modifiedEdgeComponents;

    @JsonIgnore
    protected List<NodeComponent> listOfNodes;
    @JsonIgnore
    protected Set<EdgeComponent> listOfEdges;


    /**
     * It will create the Solution which the GUI will use it.
     * If a command has the EMPTY tag, it will change nothing
     * USER Cases EMPTY -> it will not create an update state, but will modify the changes of the current command and jump to the next state. Otherwise -> Output to the user
     * HIGHLIGHT_ALL:colour -> it will highlight the margins of the table with that colour
     * HIGHLIGHT[pos]:col -> it will highlight only the square with the position "pos" with the colour "col"
     * INIT_ALL:value -> it will initialise every square with the value
     * POZ[position]:value -> it will change the value of the square at the position "position" with value "value"
     * If there are multiple commands, it will be split the "&" separator
     * HIGHLIGHT_EDGE[posOne-posTwo]:colour -> it will colour the edge with the nodes at posOne and posTwo
     * There are 7 tables: user, nodes, edges, visited, distances, path and solution. This will the order of the commands
     * @param messagesForUser - the messages which will be outputted on the screen
     * @param modifiedNodeComponents - the commands which modify the nodes
     * @param modifiedEdgeComponents - the commands which modify the edges
     * @param listOfNodes - the list of nodes
     * @param listOfEdges - the list of edges
     */
    public Solution(List<String> messagesForUser, List<NodeAnswear> modifiedNodeComponents,
                    List<EdgeAnswear> modifiedEdgeComponents, List<NodeComponent> listOfNodes,
                    Set<EdgeComponent> listOfEdges) {
        this.messagesForUser = messagesForUser;
        this.modifiedNodeComponents = modifiedNodeComponents;
        this.modifiedEdgeComponents = modifiedEdgeComponents;
        this.listOfNodes = listOfNodes;
        this.listOfEdges = listOfEdges;
    }

    public Solution() {

    }

    public List<String> getMessagesForUser() {
        return messagesForUser;
    }

    public List<NodeAnswear> getModifiedNodeComponents() {
        return modifiedNodeComponents;
    }

    public List<EdgeAnswear> getModifiedEdgeComponents() {
        return modifiedEdgeComponents;
    }

    public List<NodeComponent> getListOfNodes() {
        return listOfNodes;
    }

    public Set<EdgeComponent> getListOfEdges() {
        return listOfEdges;
    }
}
