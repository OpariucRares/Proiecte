using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class Enemy_movement : MonoBehaviour {


    public float speed;
   public int poz;
    // Use this for initialization
    void Start () {
		
	}
	
	// Update is called once per frame
	void Update () {

        if(manager3.EnemyCanMove)
        poz = Random.Range(1, 6);
        
        if (poz == 1 && manager3.EnemyCanMove)
        {
            gameObject.transform.position = new Vector2(4.5f, -1.8f);
            manager3.EnemyCanMove = false;
            manager3.canshoot = true;
        }
        if (poz == 2 && manager3.EnemyCanMove)
        {
            gameObject.transform.position = new Vector2(4.5f, -0.9f);
            manager3.EnemyCanMove = false;
            manager3.canshoot = true;
        }

        if (poz == 3 && manager3.EnemyCanMove)
        {
            gameObject.transform.position = new Vector2(4.5f, 0f);
            manager3.EnemyCanMove = false;
            manager3.canshoot = true;
        }

        if (poz == 4 && manager3.EnemyCanMove)
        {
            gameObject.transform.position = new Vector2(4.5f, 0.9f);
            manager3.EnemyCanMove = false;
            manager3.canshoot = true;
        }

        if (poz == 5 && manager3.EnemyCanMove)
        {
            gameObject.transform.position = new Vector2(4.5f, 1.8f);
            manager3.EnemyCanMove = false;
            manager3.canshoot = true;
        }
    }


    private void OnTriggerEnter2D(Collider2D collision)
    {
        if (collision.gameObject.name == "PrefabShootP(Clone)")
            manager3.EnemyHit++;

    }


}
