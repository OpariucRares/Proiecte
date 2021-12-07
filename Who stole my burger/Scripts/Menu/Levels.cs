using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.SceneManagement;

public class Levels : MonoBehaviour {



    public void Level1() {

            SceneManager.LoadScene(2);
    }
    public void Level2()
    {
        if (manager_level.contor >= 2)
            SceneManager.LoadScene(3);
    }
    public void Level3()
    {
        if (manager_level.contor >= 3)
            SceneManager.LoadScene(4);
    }
    public void Level4()
    {
        if (manager_level.contor >= 4)
            SceneManager.LoadScene(5);
    }
    public void Level5()
    {
        if (manager_level.contor >= 5)
            SceneManager.LoadScene(6);
    }

    public void Level6()
    {
        if (manager_level.contor >= 6)
            SceneManager.LoadScene(7);
    }
    public void Level7()
    {
        if (manager_level.contor >= 7)
            SceneManager.LoadScene(8);
    }
    public void Level8()
    {
        if (manager_level.contor >= 8)
            SceneManager.LoadScene(9);
    }

    public void Level9()
    {
        if (manager_level.contor >= 9)
            SceneManager.LoadScene(10);
    }
    public void BACK()
    {

        SceneManager.LoadScene(0);
    }
    public void ifs()
    {
        manager_level.contor = 9;
    }
}
