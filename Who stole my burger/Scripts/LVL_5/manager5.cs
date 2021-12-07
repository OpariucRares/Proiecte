using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.SceneManagement;

public class manager5 : MonoBehaviour {



    public static int health;
    public static int CorectHit;

    // Use this for initialization
    private void Start()
    {
        health = 3;
        CorectHit = 0;
        Spawn_Enemy.canSpawn = true;
    }

    // Update is called once per frame
    void Update () {
        if (health > 3) health = 3;
        if (health < 0) health = 0;
        if (health == 0)
        {
           
            SceneManager.LoadScene(1);
        }
        else
            if (CorectHit >= 60)
        {
            manager_level.contor = 6;
            SceneManager.LoadScene(1);
        }


    }
}
