package modeling.status;

import com.fasterxml.jackson.annotation.JsonProperty;

public class DistanceAnswear {
    private int nodePoz;
    private int value;
    @JsonProperty("modified")
    private boolean isModified;
    public DistanceAnswear(){}
    public DistanceAnswear(int nodePoz, int value, boolean isModified) {
        this.nodePoz = nodePoz;
        this.value = value;
        this.isModified = isModified;
    }

    @Override
    public String toString() {
        return "DistanceAnswear{" +
                "nodePoz=" + nodePoz +
                ", value=" + value +
                ", isModified=" + isModified +
                '}';
    }

    public int getNodePoz() {
        return nodePoz;
    }

    public int isValue() {
        return value;
    }

    public boolean isModified() {
        return isModified;
    }
}
