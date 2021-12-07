using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.UI;

public class Hits : MonoBehaviour {


    Text T;

	// Use this for initialization
	void Start () {
        T = gameObject.GetComponent<Text>();

    }
	
	// Update is called once per frame
	void Update () {
        
      T.text  =(60-manager5.CorectHit).ToString();
	}
}
