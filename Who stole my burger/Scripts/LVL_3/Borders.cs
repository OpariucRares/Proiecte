using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class Borders : MonoBehaviour {



    Vector2 POZUP, POZDOWN;
    // Use this for initialization
    void Start () {
        POZUP = new Vector2(-4.5f, 2f);
        POZDOWN = new Vector2(-4.5f, -2f);
    }
	
	// Update is called once per frame
	void Update () {



        if (gameObject.transform.position.y > 2)
            gameObject.transform.position = POZDOWN;
        if (gameObject.transform.position.y < -2)
            gameObject.transform.position = POZUP;
    }
}
