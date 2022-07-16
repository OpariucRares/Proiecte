package modeling.status;

import com.fasterxml.jackson.annotation.JsonProperty;

public class PathAnswear {
    private int nodePoz;
    private int value;
    @JsonProperty("modified")
    private boolean isModified;
    public PathAnswear(){}
    public PathAnswear(int nodePoz, int value, boolean isModified) {
        this.nodePoz = nodePoz;
        this.value = value;
        this.isModified = isModified;
    }

    @Override
    public String toString() {
        return "PathAnswear{" +
                "nodePoz=" + nodePoz +
                ", value=" + value +
                ", isModified=" + isModified +
                '}';
    }

    public int getNodePoz() {
        return nodePoz;
    }

    public int getValue() {
        return value;
    }

    public boolean isModified() {
        return isModified;
    }
}
