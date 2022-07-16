package draw;
import algorithms.BFSAlgorithm;
import algorithms.DFSAlgorithm;
import algorithms.DijkstraAlgorithm;
import algorithms.PrimAlgorithm;
import com.fasterxml.jackson.databind.ObjectMapper;
import components.GraphComponent;
import gif.CreateGif;
import gif.GifSequenceWriter;
import modeling.problems.ProblemBFSandDFS;
import modeling.problems.ProblemDijkstraPrim;
import modeling.solutions.SolutionBFS;
import modeling.solutions.SolutionDFS;
import modeling.solutions.SolutionDijkstra;
import modeling.solutions.SolutionPrim;
import components.EdgeComponent;
import components.NodeComponent;
import generator.RandomGraphGenerator;
import modeling.status.*;

import javax.imageio.ImageIO;
import javax.swing.*;
import java.awt.*;
import java.awt.geom.AffineTransform;
import java.awt.image.BufferedImage;
import java.io.File;
import java.io.IOException;
import java.util.ArrayList;
import java.util.List;
import java.util.Random;
import java.util.Set;

public class DrawingPanel extends JPanel {
    public static int numberImages = 0;
    public static boolean createNewGif = false;
    private List<NodeComponent>nodes=new ArrayList<>();
    private Graphics2D graphics;
    private final MainFrame frame;
    int canvasWidth = 800, canvasHeight = 600;
    int circleR=50;
    BufferedImage image;
    Graphics2D offscreen;
    static boolean directed=true;
    static boolean isFirst=true;

    static int alg;
    static int indexMsg=-1;
    static List<String> messages;
    static List<NodeAnswear> newNodes;
    static List<EdgeAnswear> newEdge;
    static List<DistanceAnswear> distance;
    static List<VisitedAnswear> visited;
    static List<PathAnswear> path;
    static List<List<String>> solution;
    static Set<EdgeComponent> mst;
    static List<Integer> dfsSol;
    static List<Integer> bfsSol;
    static List<QueueAnswear> bfsQueue;
    static List<Integer> afisBfs=new ArrayList<>();
    static int costPoz,pathPoz,vizPoz,solPoz;
    public DrawingPanel(MainFrame frame) {
        this.frame = frame;
        createOffscreenImage();
        init();
    }
    private void createOffscreenImage() {
        image = new BufferedImage(canvasWidth, canvasHeight, BufferedImage.TYPE_INT_ARGB);
        offscreen = image.createGraphics();
        clearWindow();
    }
    final void init() {
        setPreferredSize(new Dimension(canvasWidth, canvasHeight));
    }

    @Override
    protected void paintComponent(Graphics graphics) {
        graphics.drawImage(image, 0, 0, this);
    }

    protected void paintNodes(int howMany) {
        int a,b,r;
        clearWindow();
        nodes.clear();
        a = canvasWidth / 2;
        b = canvasHeight / 2;
        int m = Math.min(a, b);
        r = 4 * m / 5;
        int r2 = Math.abs(m - r) / 2;
        offscreen.setColor(Color.BLACK);
        for (int i = 0; i < howMany; i++) {
            double t = 2 * Math.PI * i / howMany;
            int x = (int) Math.round(a + r * Math.cos(t));
            int y = (int) Math.round(b + r * Math.sin(t));
            drawSingleNode(i+1,x,y,r2,Color.BLACK);
            nodes.add(new NodeComponent(String.valueOf(i+1),x,y,2*r2,Color.BLACK));
        }
        isFirst=true;
        repaint();
    }
    public void paintEdge(int st,int dr,int cost,boolean isDirected)
    {
        if(st<=nodes.size()&&dr<=nodes.size()&&st!=dr)
        if(isFirst||(!isFirst&&directed==isDirected))
        {
            directed=isDirected;
            NodeComponent nodL=nodes.get(st-1);
            NodeComponent nodR=nodes.get(dr-1);
            if(!nodL.getAdjacentNodes().contains(nodR)) {
                offscreen.drawLine(nodL.getCoordinateX(), nodL.getCoordinateY(), nodR.getCoordinateX(), nodR.getCoordinateY());
                if (isDirected) {
                    drawArc(nodL.getCoordinateX(), nodL.getCoordinateY(), nodR.getCoordinateX(), nodR.getCoordinateY());
                    drawText(nodL.getCoordinateX(), nodL.getCoordinateY(), nodR.getCoordinateX(), nodR.getCoordinateY(), cost);
                    nodL.addAdjacentNodes(nodR, new EdgeComponent(nodL, nodR, cost, true, Color.BLACK));
                } else {
                    drawText(nodL.getCoordinateX(), nodL.getCoordinateY(), nodR.getCoordinateX(), nodR.getCoordinateY(), cost);
                    nodL.addAdjacentNodes(nodR, new EdgeComponent(nodL, nodR, cost, false, Color.BLACK));
                    nodR.addAdjacentNodes(nodL, new EdgeComponent(nodR, nodL, cost, false, Color.BLACK));
                }
                //draw again the two nodes
                drawSingleNode(st, nodL.getCoordinateX(), nodL.getCoordinateY(), nodL.getRadiusCircle() / 2, nodL.getColourCircle());
                drawSingleNode(dr, nodR.getCoordinateX(), nodR.getCoordinateY(), nodR.getRadiusCircle() / 2, nodR.getColourCircle());
                isFirst = false;
                repaint();
            }
        }
    }
    public void repaintEdge(int st,int dr,Color color)
    {
        Color back=offscreen.getColor();
        offscreen.setColor(color);
        NodeComponent nodL=nodes.get(st);
        NodeComponent nodR=nodes.get(dr);
        offscreen.drawLine(nodL.getCoordinateX(), nodL.getCoordinateY(), nodR.getCoordinateX(), nodR.getCoordinateY());
        if (directed) {
            drawArc(nodL.getCoordinateX(), nodL.getCoordinateY(), nodR.getCoordinateX(), nodR.getCoordinateY());
            }
        offscreen.setColor(back);
        //draw again the two nodes
        drawSingleNode(st+1, nodL.getCoordinateX(), nodL.getCoordinateY(), nodL.getRadiusCircle() / 2, nodL.getColourCircle());
        drawSingleNode(dr+1, nodR.getCoordinateX(), nodR.getCoordinateY(), nodR.getRadiusCircle() / 2, nodR.getColourCircle());
        repaint();
    }
    private void drawArc(int x1,int y1,int x2,int y2)
    {
        AffineTransform tx = new AffineTransform();
        AffineTransform before=offscreen.getTransform();

        Polygon arrowHead = new Polygon();
        arrowHead.addPoint( 0,5);
        arrowHead.addPoint( -5, -5);
        arrowHead.addPoint( 5,-5);
        tx.setToIdentity();
        double angle = Math.atan2(y2-y1, x2-x1);
        tx.translate((x1+2*x2)/3,(y1+2*y2)/3);
        tx.rotate((angle-Math.PI/2d));
        offscreen.setTransform(tx);
        offscreen.fill(arrowHead);
        offscreen.setTransform(before);



    }
    private void drawText(int x1,int y1,int x2,int y2,int cost)
    {
        offscreen.drawString(String.valueOf(cost),(x1+3*x2)/4,(y1+3*y2)/4);
    }
    private void drawSingleNode(int i,int x,int y,int r2,Color color)
    {
        Color back=offscreen.getColor();
        offscreen.setColor(color);
        offscreen.fillOval(x - r2, y - r2, 2 * r2, 2 * r2);
        offscreen.setColor(back);
        offscreen.setColor(Color.WHITE);offscreen.drawString(String.valueOf(i),x-3,y+3);offscreen.setColor(Color.BLACK);
        repaint();
    }
    protected void clearWindow()
    {
        offscreen.setColor(Color.LIGHT_GRAY);
        offscreen.fillRect(0, 0, canvasWidth, canvasHeight);
        offscreen.setFont(new Font("Serif", Font.BOLD, 16));
        repaint();
    }
    public void disconnectedAlg(int howMany)
    {
        Random random=new Random();
        List<Integer> component=new ArrayList<>();
        List<Integer> lista=new ArrayList<>();
        boolean atLeastOne=false;

        paintNodes(howMany);
        while(lista.size()<nodes.size())
        {
            int elem=1+random.nextInt(nodes.size());
            if(!lista.contains(elem))
                lista.add(elem);
        }
        component.add(lista.get(0));
        for(int i=1;i<lista.size()-1;i++)
        {
            int posibility=random.nextInt(2);
            if(posibility==0)
            {
                RandomGraphGenerator.generateConnectedGraph(this.frame,component,this.frame.configPanel.isDirected());
                component.clear();
                atLeastOne=true;
            }
            component.add(lista.get(i));
        }
        if(atLeastOne) {
            component.add(lista.get(lista.size()-1));
            RandomGraphGenerator.generateConnectedGraph(this.frame, component, this.frame.configPanel.isDirected());
            component.clear();
        }
        else{
            RandomGraphGenerator.generateConnectedGraph(this.frame, component, this.frame.configPanel.isDirected());
            component.clear();
            component.add(lista.get(lista.size()-1));
            RandomGraphGenerator.generateConnectedGraph(this.frame, component, this.frame.configPanel.isDirected());
        }
    }
    public void connectedAlg(int howMany)
    {
        paintNodes(howMany);
        List<Integer> lista=new ArrayList<>();
        for(int i=0;i<nodes.size();i++)
            lista.add(i+1);
        RandomGraphGenerator.generateConnectedGraph(this.frame,lista,this.frame.configPanel.isDirected());
    }
    public void bipartiteAlg(int howMany)
    {
        paintNodes(howMany);
        List<Integer> lista=new ArrayList<>();
        for(int i=0;i<nodes.size();i++)
            lista.add(i+1);
        RandomGraphGenerator.generateBipartiteGraph(this.frame,lista,this.frame.configPanel.isDirected());
    }
    public void generateAlg(int whatAlg,int start)
    {
        numberImages = 0;
        createNewGif = true;
        afisBfs.clear();
        this.frame.getBfsBox().setText(afisBfs.toString());
        repaintAll();
        if(start<=nodes.size()) {
            indexMsg=-1;
            alg=whatAlg;
            if (whatAlg == 1)//DIJKSTRA
            {
                NodeComponent testNode = nodes.get(start - 1);
                ProblemDijkstraPrim problem = new ProblemDijkstraPrim(nodes, testNode);
                SolutionDijkstra sol = new DijkstraAlgorithm().solve(problem);
                messages = sol.getMessagesForUser();
                newNodes=sol.getModifiedNodeComponents();
                newEdge=sol.getModifiedEdgeComponents();
                distance=sol.getDistancesCommands();
                path=sol.getPathCommands();
                visited=sol.getVisitedNodesCommands();
                solution=sol.getAllPathsFromNodeStart();
                costPoz=1;pathPoz=2;vizPoz=3;solPoz=4;
            } else if (whatAlg == 2)//PRIM
            {
                NodeComponent testNode = nodes.get(start - 1);
                ProblemDijkstraPrim problem = new ProblemDijkstraPrim(nodes, testNode);
                SolutionPrim sol = new PrimAlgorithm().solve(problem);
                messages = sol.getMessagesForUser();
                newNodes=sol.getModifiedNodeComponents();
                newEdge=sol.getModifiedEdgeComponents();
                distance=sol.getDistancesCommands();
                path=sol.getPathCommands();
                visited=sol.getVisitedNodesCommands();
                mst=sol.getEdgesOfMST();
                costPoz=1;pathPoz=2;vizPoz=3;solPoz=4;
            } else if (whatAlg == 3)//BFS
            {
                NodeComponent testNode = nodes.get(start - 1);
                ProblemBFSandDFS problemBFSandDFS = new ProblemBFSandDFS(nodes, testNode);
                SolutionBFS sol = new BFSAlgorithm().solve(problemBFSandDFS);
                messages = sol.getMessagesForUser();
                newNodes=sol.getModifiedNodeComponents();
                newEdge=sol.getModifiedEdgeComponents();
                visited=sol.getVisitedNodesCommands();
                bfsSol=sol.getSolutionListNodes();
                bfsQueue=sol.getBfsQueue();
                vizPoz=1;solPoz=2;
            } else if (whatAlg == 4) //DFS
            {
                NodeComponent testNode = nodes.get(start - 1);
                ProblemBFSandDFS problemBFSandDFS = new ProblemBFSandDFS(nodes, testNode);
                SolutionDFS sol = new DFSAlgorithm().solve(problemBFSandDFS);
                messages = sol.getMessagesForUser();
                newNodes=sol.getModifiedNodeComponents();
                newEdge=sol.getModifiedEdgeComponents();
                visited=sol.getVisitedNodesCommands();
                dfsSol=sol.getSolutionListNodes();
                vizPoz=1;solPoz=2;
            }
        }
    }
    private String convertString(List<String> list)
    {
        StringBuilder ans=new StringBuilder();
        for(int i=list.size()-1;i>=0;i--)
            ans.append(list.get(i)+",");
        return ans.toString();
    }
    public void nextMsg()
    {
        if(indexMsg<messages.size()-1)
            indexMsg++;
        if(indexMsg==messages.size()-1) {
            showSol();
            if (createNewGif) {
                new Thread(new CreateGif()).start();
                createNewGif = false;
            }
        }
        if(indexMsg>=messages.size())
            return;
        if(newNodes.get(indexMsg).isModified())
        {
            nodes.get(newNodes.get(indexMsg).getNumberPoz()).setColourCircle(newNodes.get(indexMsg).getColourNode());
            NodeComponent nod=nodes.get(newNodes.get(indexMsg).getNumberPoz());
            drawSingleNode(Integer.parseInt(nod.getName()),nod.getCoordinateX(), nod.getCoordinateY(), nod.getRadiusCircle()/2,newNodes.get(indexMsg).getColourNode());
        }
        if(newEdge.get(indexMsg).isModified())
        {
            for(int i=0;i<nodes.get(newEdge.get(indexMsg).getNodeLeftPoz()).getEdges().size();i++)
                if(Integer.valueOf(nodes.get(newEdge.get(indexMsg).getNodeLeftPoz()).getEdges().get(i).getRight().getName())-1==newEdge.get(indexMsg).getNodeRightPoz())
                    nodes.get(newEdge.get(indexMsg).getNodeLeftPoz()).getEdges().get(i).setColourEdge(newEdge.get(indexMsg).getEdgeColor());
            repaintEdge(newEdge.get(indexMsg).getNodeLeftPoz(),newEdge.get(indexMsg).getNodeRightPoz(),newEdge.get(indexMsg).getEdgeColor());
        }
        if(distance != null && distance.get(indexMsg).isModified() && (alg==1||alg==2))
        {
            Object val=null;
            if(distance.get(indexMsg).isValue()==Integer.MAX_VALUE)
                val="INF";
            else val=distance.get(indexMsg).isValue();
            this.frame.configPanel.getTable().setValueAt(String.valueOf(val),distance.get(indexMsg).getNodePoz(),costPoz);
        }
        if(path != null && path.get(indexMsg).isModified()&&(alg==1||alg==2))
        {
            this.frame.configPanel.getTable().setValueAt(String.valueOf(path.get(indexMsg).getValue()+1),path.get(indexMsg).getNodePoz(),pathPoz);
        }
        if(visited!=null && visited.get(indexMsg).isModified())
        {
            this.frame.configPanel.getTable().setValueAt(String.valueOf(visited.get(indexMsg).isValue()),visited.get(indexMsg).getNodePoz(),vizPoz);
        }
        if(!messages.get(indexMsg).equals("EMPTY") && createNewGif) {
            try {
                ImageIO.write(image, "png", new File("src/main/java/gif/imagesGenerated/images" + numberImages + ".png"));
                numberImages++;
            } catch (IOException e) {
                e.printStackTrace();
            }
        }


        if(bfsQueue!=null && bfsQueue.get(indexMsg).isModified())
        {
            if(bfsQueue.get(indexMsg).isRemoveNode()) {
                if (afisBfs.contains(bfsQueue.get(indexMsg).getIndexNode()))
                    afisBfs.remove((Object) bfsQueue.get(indexMsg).getIndexNode());
            }
            else
                afisBfs.add(bfsQueue.get(indexMsg).getIndexNode());
            this.frame.getBfsBox().setText(afisBfs.toString());
        }
        if(!messages.get(indexMsg).equals("EMPTY"))
            this.frame.getTextBox().setText(messages.get(indexMsg));
        else nextMsg();
    }
    public void backMsg()
    {
        if(indexMsg<=0)
            return;
        if(indexMsg==messages.size()-1){
            for(int i=0;i< nodes.size();i++)
                this.frame.configPanel.getTable().setValueAt(null,i,solPoz);
        }
        if(indexMsg>0)
            indexMsg--;
        if(newNodes.get(indexMsg).isModified())
        {
            nodes.get(newNodes.get(indexMsg).getNumberPoz()).setColourCircle(newNodes.get(indexMsg).getColourNode());
            NodeComponent nod=nodes.get(newNodes.get(indexMsg).getNumberPoz());
            drawSingleNode(Integer.parseInt(nod.getName()),nod.getCoordinateX(), nod.getCoordinateY(), nod.getRadiusCircle()/2,newNodes.get(indexMsg).getColourNode());
        }
        if(newEdge.get(indexMsg).isModified())
        {
            for(int i=0;i<nodes.get(newEdge.get(indexMsg).getNodeLeftPoz()).getEdges().size();i++)
                if(Integer.valueOf(nodes.get(newEdge.get(indexMsg).getNodeLeftPoz()).getEdges().get(i).getRight().getName())-1==newEdge.get(indexMsg).getNodeRightPoz())
                    nodes.get(newEdge.get(indexMsg).getNodeLeftPoz()).getEdges().get(i).setColourEdge(newEdge.get(indexMsg).getEdgeColor());
            repaintEdge(newEdge.get(indexMsg).getNodeLeftPoz(),newEdge.get(indexMsg).getNodeRightPoz(),newEdge.get(indexMsg).getEdgeColor());
        }
        if(distance!=null && distance.get(indexMsg).isModified()&&(alg==1||alg==2))
        {
            Object val=null;
            if(distance.get(indexMsg).isValue()==Integer.MAX_VALUE)
                val="INF";
            else val=distance.get(indexMsg).isValue();
            this.frame.configPanel.getTable().setValueAt(String.valueOf(val),distance.get(indexMsg).getNodePoz(),costPoz);
        }
        if(path!=null && path.get(indexMsg).isModified()&&(alg==1||alg==2))
        {
            this.frame.configPanel.getTable().setValueAt(String.valueOf(path.get(indexMsg).getValue()+1),path.get(indexMsg).getNodePoz(),pathPoz);
        }
        if(visited!=null && visited.get(indexMsg).isModified())
        {
            this.frame.configPanel.getTable().setValueAt(String.valueOf(visited.get(indexMsg).isValue()),visited.get(indexMsg).getNodePoz(),vizPoz);
        }
        if(bfsQueue!=null && bfsQueue.get(indexMsg).isModified())
        {
            if(bfsQueue.get(indexMsg).isRemoveNode()) {
                if (afisBfs.contains(bfsQueue.get(indexMsg).getIndexNode()))
                    afisBfs.remove((Object) bfsQueue.get(indexMsg).getIndexNode());
            }
            else
                afisBfs.add(bfsQueue.get(indexMsg).getIndexNode());
            this.frame.getBfsBox().setText(afisBfs.toString());
        }
        if(!messages.get(indexMsg).equals("EMPTY"))
            this.frame.getTextBox().setText(messages.get(indexMsg));
        else backMsg();
    }
    private void showSol()
    {
        if(alg==1)
        for(int i=0;i< nodes.size();i++)
            this.frame.configPanel.getTable().setValueAt(convertString(solution.get(i)),i,solPoz);
        else if(alg==2)
        {
            int i=0;
            for(EdgeComponent edge:mst)
            {
                this.frame.configPanel.getTable().setValueAt("["+edge.getLeft().getName()+" "+edge.getRight().getName()+"]",i,solPoz);
                i++;
            }
        }
        else if(alg==3)
        {
            for(int i=0;i<bfsSol.size();i++)
                this.frame.configPanel.getTable().setValueAt(String.valueOf(bfsSol.get(i)+1),i,solPoz);
        }
        else if(alg==4)
        {
            for(int i=0;i<dfsSol.size();i++)
                this.frame.configPanel.getTable().setValueAt(String.valueOf(dfsSol.get(i)+1),i,solPoz);
        }
    }
    public void importAlg()
    {
        try {
            ObjectMapper objectMapper = new ObjectMapper();
            GraphComponent graphReadFromJson = objectMapper.readValue(new File("src/main/java/json/test.json"), GraphComponent.class);
            nodes=graphReadFromJson.getListOfNodesGraph();
            clearWindow();
            for(int i=0;i<nodes.size();i++) {
                drawSingleNode(i+1, nodes.get(i).getCoordinateX(), nodes.get(i).getCoordinateY(), nodes.get(i).getRadiusCircle() / 2, nodes.get(i).getColourCircle());
            }
            for(NodeComponent nod:nodes)
                for(EdgeComponent edge:nod.getEdges())
                    drawAgain(Integer.valueOf(edge.getLeft().getName()),Integer.valueOf(edge.getRight().getName()),edge.getCostEdge(),edge.isDirected());
            this.frame.configPanel.getGeneratedNodes().setValue(nodes.size());
        }
        catch (Exception ex)
        {
            System.out.println(ex.getMessage());
        }
    }
    public void exportAlg()
    {
        try {
            GraphComponent graphComponent = new GraphComponent(nodes, directed, "EduSoftware");
            ObjectMapper objectMapper = new ObjectMapper();
            objectMapper.writeValue(new File("src/main/java/json/test.json"), graphComponent);
        }
        catch (Exception ex)
        {
            System.out.println(ex.getMessage());
        }
    }
    private void repaintAll(){
        for(int i=0;i<nodes.size();i++)
        {
            nodes.get(i).setColourCircle(Color.BLACK);
        }
        for(int i=0;i<nodes.size();i++)
            for(NodeComponent nod:nodes.get(i).getAdjacentNodes())
                repaintEdge(i,Integer.parseInt(nod.getName())-1,Color.BLACK);
    }
    private void drawAgain(int st,int dr,int cost,boolean isDirected)
    {
        NodeComponent nodL=nodes.get(st-1);
        NodeComponent nodR=nodes.get(dr-1);
        offscreen.drawLine(nodL.getCoordinateX(), nodL.getCoordinateY(), nodR.getCoordinateX(), nodR.getCoordinateY());
            if (isDirected) {
                drawArc(nodL.getCoordinateX(), nodL.getCoordinateY(), nodR.getCoordinateX(), nodR.getCoordinateY());
                drawText(nodL.getCoordinateX(), nodL.getCoordinateY(), nodR.getCoordinateX(), nodR.getCoordinateY(), cost);
            } else {
                drawText(nodL.getCoordinateX(), nodL.getCoordinateY(), nodR.getCoordinateX(), nodR.getCoordinateY(), cost);
               }
            //draw again the two nodes
            drawSingleNode(st, nodL.getCoordinateX(), nodL.getCoordinateY(), nodL.getRadiusCircle() / 2, nodL.getColourCircle());
            drawSingleNode(dr, nodR.getCoordinateX(), nodR.getCoordinateY(), nodR.getRadiusCircle() / 2, nodR.getColourCircle());
            repaint();
    }
}

