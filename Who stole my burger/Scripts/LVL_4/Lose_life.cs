using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class Lose_life : MonoBehaviour {


    public GameObject Player;


    private void OnTriggerEnter2D(Collider2D collision)
    {
        
        manager4.health -= 1;
        Player.transform.position = new Vector3(-7f, 0.45f, 0);
    }

   
}
