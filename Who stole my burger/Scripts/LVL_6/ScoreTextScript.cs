using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.UI;

public class ScoreTextScript : MonoBehaviour {

    Text text;
    public static int objectsamount;

	// Use this for initialization
	void Start () {
        text = GetComponent<Text>();
		
	}
	
	// Update is called once per frame
	void Update () {
        text.text = "Objects: " + objectsamount.ToString() + "/3";
	}
}
