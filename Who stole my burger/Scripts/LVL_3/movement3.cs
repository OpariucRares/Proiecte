using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class movement3 : MonoBehaviour {

    public float speed;
    int counter=0;


	// Use this for initialization
	void Start () {
     

	}
	
	// Update is called once per frame
	void Update () {
        if (manager3.canmove)
        {
            if (Input.GetKeyDown("w") && counter != 1)
            {
                gameObject.GetComponent<Rigidbody2D>().velocity += Vector2.up * speed;
                counter++;

            }

            if (Input.GetKeyDown("s") && counter != -1)
            {
                gameObject.GetComponent<Rigidbody2D>().velocity += Vector2.down * speed;
                counter--;

            }
        }


    }

    private void OnTriggerEnter2D(Collider2D collision)
    {
        if(collision.gameObject.name== "PrefabShootE(Clone)")
        manager3.PlayerHit++;
        
    }
}
