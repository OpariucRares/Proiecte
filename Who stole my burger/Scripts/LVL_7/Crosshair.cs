using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class Crosshair : MonoBehaviour {

    
    Transform FirePoint;

    // Use this for initialization
    void Start () {
        Cursor.visible = false;
        
    }

    // Update is called once per frame
    void Update () {


        this.transform.position = Input.mousePosition;
	}
    

}
