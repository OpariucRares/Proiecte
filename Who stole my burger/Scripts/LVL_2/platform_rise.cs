using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class platform_rise : MonoBehaviour {

    public float speed;
    public GameObject Player;
  

    private float x, y, z;
    
	// Use this for initialization
	void Start () {
        x = gameObject.GetComponent<Transform>().position.x;
        y = gameObject.GetComponent<Transform>().position.y;
        z = gameObject.GetComponent<Transform>().position.z;

    }
	
	// Update is called once per frame
	void Update () {
        if (Menu.IsPaused)
            transform.Translate(Vector3.up * speed);

	}
    private void OnTriggerEnter2D(Collider2D collision)
    {



        if (collision.gameObject.name == "Player")
        {
            manager2.health -= 1;
            transform.position = new Vector3(x,y,z);
            Player.transform.position = new Vector3(0,0,-0.1f);
           
        }

    }
    

}
