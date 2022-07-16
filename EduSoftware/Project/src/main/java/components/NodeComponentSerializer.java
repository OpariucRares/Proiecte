package components;

import com.fasterxml.jackson.core.JsonGenerator;
import com.fasterxml.jackson.databind.SerializerProvider;
import com.fasterxml.jackson.databind.ser.std.StdSerializer;

import java.io.IOException;

public class NodeComponentSerializer extends StdSerializer<NodeComponent> {
    public NodeComponentSerializer(){
        this(null);
    }
    public NodeComponentSerializer(Class<NodeComponent> t){
        super(t);
    }

    @Override
    public void serialize(NodeComponent nodeComponent, JsonGenerator jsonGenerator, SerializerProvider serializerProvider) throws IOException {
        jsonGenerator.writeStartObject();
        jsonGenerator.writeStringField("name", nodeComponent.getName());
        jsonGenerator.writeNumberField("coordinateX", nodeComponent.getCoordinateX());
        jsonGenerator.writeNumberField("coordinateY", nodeComponent.getCoordinateY());
        jsonGenerator.writeStringField("colourString", nodeComponent.getColourString());
        jsonGenerator.writeNumberField("radiusCircle", nodeComponent.getRadiusCircle());
        jsonGenerator.writeArrayFieldStart("Adjacent nodes");
        for(NodeComponent indexNodes : nodeComponent.getAdjacentNodes()){
            jsonGenerator.writeStartObject();
            jsonGenerator.writeStringField("nameAdjacent", indexNodes.getName());
            jsonGenerator.writeNumberField("coordinateX", indexNodes.getCoordinateX());
            jsonGenerator.writeNumberField("coordinateY", indexNodes.getCoordinateY());
            jsonGenerator.writeStringField("colourString", indexNodes.getColourString());
            jsonGenerator.writeNumberField("radiusCircle", indexNodes.getRadiusCircle());
            jsonGenerator.writeEndObject();
        }
        jsonGenerator.writeEndArray();
        jsonGenerator.writeArrayFieldStart("Edges");
        for(EdgeComponent indexEdges : nodeComponent.getEdges()){
            jsonGenerator.writeStartObject();
            jsonGenerator.writeStringField("nameNodeLeft", indexEdges.getLeft().getName());
            jsonGenerator.writeStringField("nameNodeRight", indexEdges.getRight().getName());
            jsonGenerator.writeNumberField("costEdge", indexEdges.getCostEdge());
            jsonGenerator.writeStringField("stringColour", indexEdges.getColourString());
            jsonGenerator.writeBooleanField("isDirected", indexEdges.isDirected());
            jsonGenerator.writeEndObject();
        }
        jsonGenerator.writeEndArray();
        jsonGenerator.writeEndObject();
    }
}
