package draw;

import javax.swing.*;
import javax.swing.border.LineBorder;
import java.awt.*;
import java.awt.event.ActionEvent;

public class MainFrame extends JFrame {
    ConfigPanel configPanel;
    public DrawingPanel canvas;
    JButton backBtn,forwardBtn;
    JTextArea textBox,bfsBox;
    public MainFrame() {
        super("EduSoftware");
        init();
    }

    private void init() {
        setDefaultCloseOperation(EXIT_ON_CLOSE);

        configPanel=new ConfigPanel(this);
        JPanel canvasPanel=new JPanel();
        canvas = new DrawingPanel(this);



        canvasPanel.setLayout(new BoxLayout(canvasPanel, BoxLayout.Y_AXIS));

        JPanel buttonPanel=new JPanel();
        forwardBtn=new JButton("Forward");
        backBtn=new JButton("Backward");
        backBtn.addActionListener(this::backwardAction);
        forwardBtn.addActionListener(this::forwardAction);
        textBox=new JTextArea(8,25);
        textBox.setLineWrap(true);
        textBox.setBorder(new LineBorder(Color.BLACK,1));
        textBox.setText("Instructions for user.");

        bfsBox=new JTextArea(4,12);
        bfsBox.setLineWrap(true);
        bfsBox.setBorder(new LineBorder(Color.BLACK,1));
        bfsBox.setText("Bfs Queue.");
        bfsBox.setVisible(false);
        buttonPanel.add(backBtn);buttonPanel.add(forwardBtn);buttonPanel.add(textBox);buttonPanel.add(bfsBox);
        canvasPanel.add(canvas);
        canvasPanel.add(buttonPanel);

        add(configPanel,BorderLayout.EAST);
        add(canvasPanel, BorderLayout.WEST);

        pack();
    }
    private void forwardAction(ActionEvent e)
    {
        this.canvas.nextMsg();
    }
    private void backwardAction(ActionEvent e)
    {
        this.canvas.backMsg();
    }
    public JTextArea getTextBox() {
        return textBox;
    }

    public JTextArea getBfsBox() {
        return bfsBox;
    }
}