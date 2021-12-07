using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class Fire : MonoBehaviour {

    public GameObject PrefabFire;
    private Transform T;
    
    public float speed;


    // Use this for initialization
    void Start () {

        
        
    }
	
	// Update is called once per frame
	void Update () {

        T = gameObject.GetComponent<Transform>();

        if (Input.GetButtonDown("Jump"))
        {
            
            var fire = (GameObject)Instantiate(PrefabFire, T.position, T.rotation);
            fire.GetComponent<Rigidbody2D>().velocity = transform.up * speed;

            Destroy(fire, 5f);
        }

	}
}
