package draw;

import javax.swing.*;
import javax.swing.table.DefaultTableCellRenderer;
import javax.swing.table.DefaultTableModel;
import java.awt.*;
import java.awt.event.ActionEvent;

public class ConfigPanel extends JPanel {
    final MainFrame frame;
    JPanel panelNodes,panelEdges,panelPropreties,panelAlgorithm,panelButtons,panelTable,panelGenarator,panelStart;
    JLabel label1,label2,label3,label4,labelNew,label5;
    JSpinner generatedNodes,sourceN,destN,costN,startNode;
    JButton nodeBtn,edgeBtn,generateBtn,importBtn,exportBtn;
    JRadioButton con,discon,bip,dij,prim,bfs,dfs,dirG,undirG;
    JTable table;
    private boolean isDirected=true;
    static int whatAlg;
    public ConfigPanel(MainFrame frame) {
        this.frame = frame;
        init();
    }
    private void init() {
        this.setLayout(new BoxLayout(this, BoxLayout.Y_AXIS));
        panelGenarator=new JPanel();
        initGenerator();
        panelGenarator.setBorder(BorderFactory.createLineBorder(Color.black));

        panelPropreties=new JPanel();
        initProprieties();
        panelPropreties.setBorder(BorderFactory.createLineBorder(Color.black));

        panelAlgorithm=new JPanel();
        initAlgorithm();
        panelAlgorithm.setBorder(BorderFactory.createLineBorder(Color.black));

        panelButtons=new JPanel();
        initButtons();
        panelButtons.setBorder(BorderFactory.createLineBorder(Color.black));

        panelStart=new JPanel();
        initStart();
        panelStart.setBorder(BorderFactory.createLineBorder(Color.black));

        panelTable=new JPanel();
        initTable();
        panelTable.setBorder(BorderFactory.createLineBorder(Color.black));

        add(panelGenarator);
        add(panelPropreties);
        add(panelAlgorithm);
        add(panelStart);
        add(panelButtons);
        add(panelTable);
    }
    void initGenerator()
    {
        panelGenarator.setLayout(new BoxLayout(panelGenarator, BoxLayout.Y_AXIS));
        label1= new JLabel("Number Of Nodes:");
        generatedNodes = new JSpinner(new SpinnerNumberModel(4, 4, 10, 1));
        nodeBtn = new JButton("Create");
        nodeBtn.addActionListener(this::addNodes);
        panelNodes=new JPanel();
        panelNodes.add(label1);
        panelNodes.add(generatedNodes);
        panelNodes.add(nodeBtn);

        labelNew=new JLabel("Type Of Graph:");
        dirG=new JRadioButton("Directed Graph");
        undirG=new JRadioButton("Undirected Graph");

        JPanel panelInside=new JPanel();
        ButtonGroup bg=new ButtonGroup();
        bg.add(dirG);bg.add(undirG);
        dirG.setSelected(true);
        dirG.addActionListener(this::addType);
        undirG.addActionListener(this::addType);
        panelInside.add(labelNew);panelInside.add(dirG);panelInside.add(undirG);

        label2= new JLabel("Generate Edge:");
        sourceN= new JSpinner(new SpinnerNumberModel(1, 1, 10, 1));
        destN= new JSpinner(new SpinnerNumberModel(1, 1, 10, 1));
        costN = new JSpinner(new SpinnerNumberModel(1, -100, 100, 1));
        edgeBtn = new JButton("Add");
        edgeBtn.addActionListener(this::addEdges);
        panelEdges=new JPanel();
        panelEdges.add(label2);panelEdges.add(sourceN);panelEdges.add(destN);panelEdges.add(costN);panelEdges.add(edgeBtn);
        panelGenarator.add(panelNodes);panelGenarator.add(panelInside);panelGenarator.add(panelEdges);
        panelEdges.setVisible(true);

    }
    void initProprieties()
    {
        JPanel panelInside=new JPanel();
        panelInside.setLayout(new BoxLayout(panelInside, BoxLayout.Y_AXIS));
        label3=new JLabel("Graph proprieties:");
        bip=new JRadioButton("Generate Biapartite Graph");
        con=new JRadioButton("Generate Connected Graph");
        discon=new JRadioButton("Generate Disconnected Graph");
        bip.addActionListener(this::bipartiteAlg);
        con.addActionListener(this::connectedAlg);
        discon.addActionListener(this::disconnectedAlg);
        ButtonGroup bg=new ButtonGroup();
        bg.add(bip);bg.add(con);bg.add(discon);
        panelInside.add(label3);panelInside.add(bip);panelInside.add(con);
        panelInside.add(discon);
        panelPropreties.add(panelInside);
    }
    void initAlgorithm()
    {
        JPanel panelInside=new JPanel();
        panelInside.setLayout(new BoxLayout(panelInside, BoxLayout.Y_AXIS));
        label4=new JLabel("Choose an algorithm:");
        dij=new JRadioButton("Dijkstra Algorithm");
        prim=new JRadioButton("Prim Algorithm");
        bfs=new JRadioButton("BFS Algorithm");
        dfs=new JRadioButton("DFS Algorithm");
        dij.setSelected(true);
        ButtonGroup bg=new ButtonGroup();
        bg.add(dij);bg.add(prim);bg.add(bfs);bg.add(dfs);
        panelInside.add(label4);panelInside.add(dij);panelInside.add(prim);panelInside.add(bfs);panelInside.add(dfs);
        panelAlgorithm.add(panelInside);
    }
    void initButtons()
    {
        JPanel panelInside=new JPanel();
        panelInside.setLayout(new BoxLayout(panelInside, BoxLayout.X_AXIS));
        generateBtn = new JButton("GENERATE");
        generateBtn.addActionListener(this::generateAlg);
        importBtn = new JButton("IMPORT");
        importBtn.addActionListener(this::importAlg);
        exportBtn = new JButton("EXPORT");
        exportBtn.addActionListener(this::exportAlg);
        panelInside.add(generateBtn);panelInside.add(importBtn);panelInside.add(exportBtn);
        panelButtons.add(panelInside);
    }
    void initStart()
    {
        JPanel panelInside=new JPanel();
        panelInside.setLayout(new BoxLayout(panelInside, BoxLayout.X_AXIS));
        label5=new JLabel("Start Node:");
        startNode = new JSpinner(new SpinnerNumberModel(1, 1, 10, 1));
        panelInside.add(label5);panelInside.add(startNode);
        panelStart.add(panelInside);
    }
    void initTable()
    {
        JPanel panelInside=new JPanel();
        table=new JTable();
        defineTable(10,1);
        JScrollPane sp = new JScrollPane(table);
        panelInside.add(sp);
        panelTable.add(panelInside);
    }
    private void addType(ActionEvent e)
    {
        if(dirG.isSelected())
        {
            isDirected=true;
            panelEdges.setVisible(true);
        }
        else if(undirG.isSelected())
        {
            isDirected=false;
            panelEdges.setVisible(true);
        }
    }
    private void connectedAlg(ActionEvent e)
    {
        this.frame.canvas.connectedAlg(getNrNodes());
    }
    private void disconnectedAlg(ActionEvent e)
    {
        this.frame.canvas.disconnectedAlg(getNrNodes());
    }
    private void bipartiteAlg(ActionEvent e)
    {
        this.frame.canvas.bipartiteAlg(getNrNodes());
    }
    private void importAlg(ActionEvent e)
    {
        this.frame.canvas.importAlg();
    }
    private void exportAlg(ActionEvent e)
    {
        this.frame.canvas.exportAlg();
    }
    private void generateAlg(ActionEvent e)
    {

        defineTable(getNrNodes(),getWhatAlg());
        this.frame.canvas.generateAlg(getWhatAlg(),getStartNode());

    }

    public int getWhatAlg() {
        this.frame.getBfsBox().setVisible(false);
        if(dij.isSelected()) whatAlg=1;
        else if(prim.isSelected()) whatAlg=2;
        else if(bfs.isSelected()) {
            whatAlg=3;
            this.frame.getBfsBox().setVisible(true);
        }
        else if(dfs.isSelected()) whatAlg=4;
        return whatAlg;
    }

    private void addNodes(ActionEvent e)
    {
        this.frame.canvas.paintNodes(getNrNodes());
    }
    private void addEdges(ActionEvent e)
    {
        if(isDirected)
        this.frame.canvas.paintEdge(getSource(),getDestination(),getCost(),true);
        else this.frame.canvas.paintEdge(getSource(),getDestination(),getCost(),false);
    }
    public void defineTable(int rows,int alg)
    {
        DefaultTableModel dd = null;
        if(alg==1||alg==2)
            dd=new DefaultTableModel(new Object[]{"Vertex","Cost","Path","Visited","Solution"},rows);
        else if(alg==3||alg==4)
            dd=new DefaultTableModel(new Object[]{"Vertex","Visited","Solution"},rows);
        table.setModel(dd);
        for(int i=0;i<table.getRowCount();i++)
            table.setValueAt(String.valueOf(i+1),i,0);
        Object value = null;
        for(int i=0;i<table.getRowCount();i++)
            for(int j=1;j<table.getColumnCount();j++) {
                if (table.getColumnName(j).equals("Cost"))
                    value = "INF";
                else if(table.getColumnName(j).equals("Path"))
                    value=-1;
                if (table.getColumnName(j).equals("Visited"))
                    value = false;
                else if(table.getColumnName(j).equals("Solution"))
                    value=null;
                table.setValueAt(value, i, j);
            }

        table.setGridColor(Color.BLACK);
        DefaultTableCellRenderer rightRenderer = new DefaultTableCellRenderer();
        rightRenderer.setHorizontalAlignment(JLabel.CENTER);
        for(int i=0;i<table.getColumnCount();i++)
            table.getColumnModel().getColumn(i).setCellRenderer(rightRenderer);
        table.setRowHeight(30);
    }
    private int getNrNodes(){
        return (int)generatedNodes.getValue();
    }
    private int getSource()
    {
        return (int)sourceN.getValue();
    }
    private int getDestination()
    {
        return (int)destN.getValue();
    }
    private int getCost()
    {
        return (int)costN.getValue();
    }
    public boolean isDirected() {
        return isDirected;
    }
    public int getStartNode() {
        return (int)startNode.getValue();
    }

    public JTable getTable() {
        return table;
    }

    public JSpinner getGeneratedNodes() {
        return generatedNodes;
    }
}