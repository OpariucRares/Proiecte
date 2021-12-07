using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class Camera_Render : MonoBehaviour {


    float defaultWidth;
    public float x;

	// Use this for initialization
	void Start () {
        defaultWidth = Camera.main.orthographicSize * Camera.main.aspect;
	}
	
	// Update is called once per frame
	void Update () {

        Camera.main.orthographicSize =x* defaultWidth / Camera.main.aspect;
	}
}
