package modeling.status;

public class QueueAnswear {
    private int indexNode;
    private boolean removeNode;
    private boolean isModified;
    public QueueAnswear(){}
    public QueueAnswear(int indexNode, boolean removeNode, boolean isModified) {
        this.indexNode = indexNode;
        this.removeNode = removeNode;
        this.isModified = isModified;
    }

    @Override
    public String toString() {
        return "QueueAnswear{" +
                "indexNode=" + indexNode +
                ", removeNode=" + removeNode +
                ", isModified=" + isModified +
                '}';
    }

    public int getIndexNode() {
        return indexNode;
    }

    public boolean isRemoveNode() {
        return removeNode;
    }

    public boolean isModified() {
        return isModified;
    }
}
