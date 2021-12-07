using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.SceneManagement;

public class manager4 : MonoBehaviour {

    public static int health;
    public static bool canmove=true;
    private void Start()
    {
        health = 3;
        canmove = true;
    }

    // Update is called once per frame
    void Update () {
        if (health > 3) health = 3;
        if (health < 0) health = 0;
        if (health == 0)
        {
            canmove = false;
            SceneManager.LoadScene(1);
        }
    }
}
