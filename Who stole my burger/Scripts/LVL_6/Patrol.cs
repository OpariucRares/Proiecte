using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class Patrol : MonoBehaviour {

    public float Speed;

    public Vector3 Position;
	
	// Update is called once per frame
	void Update () {

        if (ScoreTextScript.objectsamount == 1)
            Destroy(gameObject);
        transform.position = Vector2.MoveTowards(transform.position, Position, Speed * Time.deltaTime);
        
		
	}
}
