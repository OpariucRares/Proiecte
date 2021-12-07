using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.UI;

public class Lose_Life : MonoBehaviour {

    public GameObject Shape;
    Text T;

    

    // Use this for initialization
    void Start () {
		
	}
	
	// Update is called once per frame
	void Update () {
        T = Shape.GetComponent<Text>();
        
    }

    private void OnTriggerEnter2D(Collider2D collision)
    {

        
        if (collision.gameObject.name == "Player")
        {
            if (Spawn_Enemy.i == 1 && (T.text == "SQUARE" || T.text == "RED"))
                manager5.health -= 1;
            if (Spawn_Enemy.i == 2 && (T.text == "BLUE" || T.text == "SQUARE"))
                manager5.health -= 1;
            if (Spawn_Enemy.i == 3 && (T.text == "CERCLE" || T.text == "RED"))
                manager5.health -= 1;
            if (Spawn_Enemy.i == 4 && (T.text == "CERCLE" || T.text == "BLUE"))
                manager5.health -= 1;
            if (Spawn_Enemy.i == 5 && (T.text == "TRIANGLE" || T.text == "RED"))
                manager5.health -= 1;
            if (Spawn_Enemy.i == 6 && (T.text == "TRIANGLE" || T.text == "BLUE"))
                manager5.health -= 1;

            if (gameObject.name != "1")
            {
                Destroy(gameObject);
                manager5.CorectHit++;
            }

        }
        if(collision.gameObject.name== "PrefabShoot(Clone)")
        {
            if (Spawn_Enemy.i == 1 && (T.text == "SQUARE" || T.text == "RED"))
            {
                if (gameObject.name == "1(Clone)")
                    Destroy(gameObject);
                manager5.CorectHit++;
            }
            else
            if (Spawn_Enemy.i == 2 && (T.text == "BLUE" || T.text == "SQUARE"))
            {
                if (gameObject.name == "1(Clone)")
                    Destroy(gameObject);
                manager5.CorectHit++;
            }
            else
            if (Spawn_Enemy.i == 3 && (T.text == "CIRCLE" || T.text == "RED"))
            {
                if (gameObject.name == "1(Clone)")
                    Destroy(gameObject);
                manager5.CorectHit++;
            }
            else
            if (Spawn_Enemy.i == 4 && (T.text == "CIRCLE" || T.text == "BLUE"))
            {
                if (gameObject.name == "1(Clone)")
                    Destroy(gameObject);
                manager5.CorectHit++;
            }
            else
            if (Spawn_Enemy.i == 5 && (T.text == "TRIANGLE" || T.text == "RED"))
            {
                if (gameObject.name == "1(Clone)")
                    Destroy(gameObject);
                manager5.CorectHit++;
            }
            else
            if (Spawn_Enemy.i == 6 && (T.text == "TRIANGLE" || T.text == "BLUE"))
            {
                if (gameObject.name == "1(Clone)")
                    Destroy(gameObject);
                manager5.CorectHit++;
            }
            else
            { manager5.health -= 1;
                manager5.CorectHit--;
            }
                
            
        }


        

    }
}
