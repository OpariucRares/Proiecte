package generator;

import draw.MainFrame;

import java.util.ArrayList;
import java.util.List;
import java.util.Random;

public class RandomGraphGenerator {
    public static void generateConnectedGraph(MainFrame frame,List<Integer> indexes,boolean isDirected)
    {
        Random rand=new Random();
        int nodes=indexes.size(),first;
        boolean [][]uz=new boolean[nodes+1][nodes+1];
        boolean []ok=new boolean[nodes+1];
        List<Integer> s=new ArrayList<>();
        for(int i=1;i<=nodes;i++)
           s.add(i);
       int nodStart=1+rand.nextInt(nodes);
       first=nodStart;
       ok[nodStart]=true;
       int cate=0;
       while(cate<nodes-1)
       {
           int randPoz=rand.nextInt(s.size());
           int randNod=s.get(randPoz);
           if(!ok[randNod]) {
               if (isDirected)
                   uz[nodStart][randNod] = true;
               else {
                   uz[nodStart][randNod] = true;
                   uz[randNod][nodStart] = true;
               }
               ok[randNod]=true;
               nodStart = randNod;
               cate++;
           }
       }
       if(isDirected)
       {
           uz[nodStart][first]=true;
       }
       int maxEdges;
       if(!isDirected)
       maxEdges=((nodes-1)*nodes)/2-nodes+1;
       else maxEdges=((nodes-1)*nodes)-nodes;
       if(maxEdges>0) {
           int randEdges = ((1 + rand.nextInt(maxEdges))*3)/4;
           int cateMuchii = 0;
           while (cateMuchii < randEdges) {
               int x = 1 + rand.nextInt(nodes);
               int y = 1 + rand.nextInt(nodes);
               if (x != y && !uz[x][y]) {
                   if (isDirected)
                       uz[x][y] = true;
                   else {
                       uz[x][y] = uz[y][x] = true;
                   }
                   cateMuchii++;
               }
           }
       }
       for(int i=1;i<=nodes;i++)
           for(int j=1;j<=nodes;j++)
               if(uz[i][j])
                   frame.canvas.paintEdge(indexes.get(i-1),indexes.get(j-1),rand.nextInt(100),isDirected);
    }
    public static void generateBipartiteGraph(MainFrame frame,List<Integer> indexes,boolean isDirected)
    {
        Random rand=new Random();
        int nodes=indexes.size();
        boolean [][]uz=new boolean[nodes+1][nodes+1];
        boolean []ok=new boolean[nodes+1];
        List<Integer> firstSide=new ArrayList<>();
        List<Integer> secondSide=new ArrayList<>();
        int n=1+rand.nextInt(nodes-1);
        int m=nodes-n;
        while(firstSide.size()<n)
        {
            int elem=1+rand.nextInt(nodes);
            if(!ok[elem]) {
                firstSide.add(elem);
                ok[elem]=true;}
        }
        while(secondSide.size()<m)
        {
            int elem=1+rand.nextInt(nodes);
            if(!ok[elem]) {
                secondSide.add(elem);
                ok[elem]=true;}
        }
        if(!isDirected)
        {
            for(int i=0;i<firstSide.size();i++)
            {
                int randNeigh=1+ rand.nextInt(secondSide.size());
                int contor=0;
                while (contor<randNeigh)
                {
                    int randIn=rand.nextInt(secondSide.size());
                    if(!uz[firstSide.get(i)][secondSide.get(randIn)])
                    {
                        uz[firstSide.get(i)][secondSide.get(randIn)]=true;
                        uz[secondSide.get(randIn)][firstSide.get(i)]=true;
                        contor++;
                    }
                }
            }
        }
        else{
            for(int i=0;i<firstSide.size();i++)
            {
                int randNeigh=1+ rand.nextInt(secondSide.size());
                int contor=0;
                while (contor<randNeigh)
                {
                    int randIn=rand.nextInt(secondSide.size());
                    if(!uz[firstSide.get(i)][secondSide.get(randIn)])
                    {
                        uz[firstSide.get(i)][secondSide.get(randIn)]=true;
                        contor++;
                    }
                }
            }
            for(int i=0;i<secondSide.size();i++)
            {
                int randNeigh=1+ rand.nextInt(firstSide.size());
                int contor=0;
                while (contor<randNeigh)
                {
                    int randIn=rand.nextInt(firstSide.size());
                    if(!uz[firstSide.get(randIn)][secondSide.get(i)])
                    {
                        uz[secondSide.get(i)][firstSide.get(randIn)]=true;
                    }
                    contor++;
                }
            }
        }
        for(int i=1;i<=nodes;i++)
            for(int j=1;j<=nodes;j++)
                if(uz[i][j])
                   frame.canvas.paintEdge(indexes.get(i-1),indexes.get(j-1),rand.nextInt(100),isDirected);
    }
}
