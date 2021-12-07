using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class PlyerMove8 : MonoBehaviour {

    public Vector3 Position1;
    public Vector3 Position2;
    public Vector3 Position3;
    // Use this for initialization
    void Start () {
        transform.position = Position2;
		
	}
	
	// Update is called once per frame
	void Update () {

        if (transform.position == Position1 && Input.GetKeyDown(KeyCode.RightArrow))
            transform.position = Position2;
        else if (transform.position == Position3 && Input.GetKeyDown(KeyCode.LeftArrow))
            transform.position = Position2;
        else if (transform.position == Position2 && Input.GetKeyDown(KeyCode.LeftArrow))
            transform.position = Position1;
        else if (transform.position == Position2 && Input.GetKeyDown(KeyCode.RightArrow))
            transform.position = Position3;

    }
}
