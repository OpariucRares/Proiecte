using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.SceneManagement;

public class manager6 : MonoBehaviour {

    public static int health = 3;
    // Use this for initialization
    

    // Update is called once per frame
    void Update()
    {
        if (health == 0)
        {
            ScoreTextScript.objectsamount = 0;
            health = 3;
            transform.position = PlayerMovement.respawnPoint;
            SceneManager.LoadScene(7);
        }
    }
}
