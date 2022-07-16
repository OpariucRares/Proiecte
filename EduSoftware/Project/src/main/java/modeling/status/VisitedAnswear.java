package modeling.status;

import com.fasterxml.jackson.annotation.JsonProperty;

public class VisitedAnswear {
    private int nodePoz;
    private boolean value;
    @JsonProperty("modified")
    private boolean isModified;
    public VisitedAnswear(){}
    public VisitedAnswear(int nodePoz, boolean value, boolean isModified) {
        this.nodePoz = nodePoz;
        this.value = value;
        this.isModified = isModified;
    }

    @Override
    public String toString() {
        return "VisitedAnswear{" +
                "nodePoz=" + nodePoz +
                ", value=" + value +
                ", isModified=" + isModified +
                '}';
    }

    public int getNodePoz() {
        return nodePoz;
    }

    public boolean isValue() {
        return value;
    }

    public boolean isModified() {
        return isModified;
    }
}
