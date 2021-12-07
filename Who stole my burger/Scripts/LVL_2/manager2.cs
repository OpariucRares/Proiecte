using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.SceneManagement;

public class manager2 : MonoBehaviour {

    public static int health;
    public static bool canmove;
    public static bool enemyReset = false;
    // Use this for initialization
    private void Start()
    {
        health = 1;
        canmove = true;
    }

    // Update is called once per frame
    void Update () {
        if (health == 0)
        { canmove = false;
            SceneManager.LoadScene(3);
        }
    }
}
