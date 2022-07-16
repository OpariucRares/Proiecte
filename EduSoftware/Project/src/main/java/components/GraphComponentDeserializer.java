package components;

import com.fasterxml.jackson.core.JacksonException;
import com.fasterxml.jackson.core.JsonParser;
import com.fasterxml.jackson.databind.DeserializationContext;
import com.fasterxml.jackson.databind.JsonNode;
import com.fasterxml.jackson.databind.ObjectMapper;
import com.fasterxml.jackson.databind.deser.std.StdDeserializer;
import com.fasterxml.jackson.databind.node.ArrayNode;

import java.awt.*;
import java.io.IOException;
import java.util.ArrayList;
import java.util.HashSet;
import java.util.List;
import java.util.Set;
import java.util.stream.Collectors;

public class GraphComponentDeserializer extends StdDeserializer<GraphComponent> {
    public GraphComponentDeserializer(){
        this(null);
    }
    public GraphComponentDeserializer(Class<?> t){
        super(t);
    }

    @Override
    public GraphComponent deserialize(JsonParser jsonParser, DeserializationContext deserializationContext) throws IOException, JacksonException {

        JsonNode node = jsonParser.getCodec().readTree(jsonParser);
        boolean isUndirected = new ObjectMapper().readTree(node.toString()).get("unidirected").booleanValue();
        String typeAlgorithm = new ObjectMapper().readTree(node.toString()).get("typeAlgorithm").asText();
        JsonNode arrNode = new ObjectMapper().readTree(node.toString()).get("listOfNodesGraph");
        List<NodeComponent> listOfNodesGraph = new ArrayList<>();
        Color colourNode = null;
        for (JsonNode indexListOfNodesGraph : arrNode) {
            String colourString = indexListOfNodesGraph.get("colourString").asText();
            if (colourString.equals("BLACK"))
                colourNode = Color.black;
            else if (colourString.equals("BLUE"))
                colourNode = Color.BLUE;
            else if (colourString.equals("RED"))
                colourNode = Color.RED;
            else if (colourString.equals("GREEN"))
                colourNode = Color.GREEN;
            NodeComponent nodeCopy = new NodeComponent(
                    indexListOfNodesGraph.get("name").asText(),
                    (int)indexListOfNodesGraph.get("coordinateX").numberValue(),
                    (int)indexListOfNodesGraph.get("coordinateY").numberValue(),
                    (int)indexListOfNodesGraph.get("radiusCircle").numberValue(),
                    colourNode
            );
            listOfNodesGraph.add(nodeCopy);
        }
        Set<EdgeComponent> edgesGraph = new HashSet<>();
        for(int listOfNodesIndex = 0; listOfNodesIndex < arrNode.size(); ++listOfNodesIndex){
            for(int listOfEdgesIndex = 0; listOfEdgesIndex < arrNode.get(listOfNodesIndex).get("Edges").size(); ++listOfEdgesIndex) {
                String nameNodeLeft = arrNode.get(listOfNodesIndex).get("Edges").get(listOfEdgesIndex).get("nameNodeLeft").asText();
                String nameNodeRight = arrNode.get(listOfNodesIndex).get("Edges").get(listOfEdgesIndex).get("nameNodeRight").asText();
                boolean isDirected = arrNode.get(listOfNodesIndex).get("Edges").get(listOfEdgesIndex).get("isDirected").booleanValue();
                int costEdge = (int)arrNode.get(listOfNodesIndex).get("Edges").get(listOfEdgesIndex).get("costEdge").numberValue();
                String colourString = arrNode.get(listOfNodesIndex).get("Edges").get(listOfEdgesIndex).get("stringColour").asText();
                if (colourString.equals("BLACK"))
                    colourNode = Color.black;
                else if (colourString.equals("BLUE"))
                    colourNode = Color.BLUE;
                else if (colourString.equals("RED"))
                    colourNode = Color.RED;
                else if (colourString.equals("GREEN"))
                    colourNode = Color.GREEN;
                NodeComponent nodeCopyLeft = listOfNodesGraph.get(findNodeByName(listOfNodesGraph, nameNodeLeft));
                NodeComponent nodeCopyRight = listOfNodesGraph.get(findNodeByName(listOfNodesGraph, nameNodeRight));
                EdgeComponent edgeCopy = new EdgeComponent(nodeCopyLeft, nodeCopyRight, costEdge,isDirected, colourNode);
                edgesGraph.add(edgeCopy);
            }
        }
        for(int listOfNodesIndex = 0; listOfNodesIndex < arrNode.size(); ++listOfNodesIndex) {
            for(int listOfEdgesIndex = 0; listOfEdgesIndex < arrNode.get(listOfNodesIndex).get("Adjacent nodes").size(); ++listOfEdgesIndex) {

                String nameNodeAdjacent = arrNode.get(listOfNodesIndex).get("Adjacent nodes").get(listOfEdgesIndex).get("nameAdjacent").asText();
                NodeComponent nodeAdjacent = listOfNodesGraph.get(findNodeByName(listOfNodesGraph, nameNodeAdjacent));
                int finalListOfNodesIndex = listOfNodesIndex;
                List<EdgeComponent> edgesCopy = edgesGraph.stream().filter(e -> e.getLeft().getName().equals(listOfNodesGraph.get(finalListOfNodesIndex).getName()) && e.getRight().getName().equals(nodeAdjacent.getName())).collect(Collectors.toList());
                listOfNodesGraph.get(listOfNodesIndex).addAdjacentNodes(nodeAdjacent, edgesCopy.get(0));
            }
        }
        return new GraphComponent(listOfNodesGraph, isUndirected, typeAlgorithm);
    }
    private Integer findNodeByName(List<NodeComponent> listNodes, String nameNode){
        for(int i = 0; i < listNodes.size(); ++i){
            if (listNodes.get(i).getName().equals(nameNode))
                return i;
        }
        return -1;
    }
}
