using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.SceneManagement;

public class manager : MonoBehaviour {


    public static int health;
    public static bool respawn = false;
    public static bool ColDeath = false;
    public static bool tryAgain = false;
    public static bool canmove = true;


    private void Start()
    {
        health = 1;
        canmove = true;
    }
    // Update is called once per frame
    void Update () {
        if (health == 0)
        {
            canmove = false;
            SceneManager.LoadScene(2);
        }

	}
}
