using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.SceneManagement;

public class manager8 : MonoBehaviour {

    public static int health;
    public static bool canmove;
    public static bool enemyReset = false;
    public static int cont = 0;

    // Use this for initialization
    private void Start()
    {
        cont = 0;
        health = 5;
    }
    // Update is called once per frame
    void Update()
    {
        if (health == 0)
        {
            cont = 0;
            SceneManager.LoadScene(9);
        }
        if (cont == 50)
        {
            manager_level.contor++;
            SceneManager.LoadScene(1);

        }
    }
}
