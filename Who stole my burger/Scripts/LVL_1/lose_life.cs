using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class lose_life : MonoBehaviour {

    // Use this for initialization


    // Update is called once per frame
    private void OnCollisionEnter2D(Collision2D collision)
    {
        if (collision.gameObject.name == "Player")
        {
            manager.health -= 1;
            manager.ColDeath = true;
            manager.respawn = true;
            
            
        }
    }
}
