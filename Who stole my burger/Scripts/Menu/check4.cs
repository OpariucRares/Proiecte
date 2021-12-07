using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class check4 : MonoBehaviour {

	// Use this for initialization
	void Start () {
		
	}
	
	// Update is called once per frame
	void Update () {
        if (manager_level.contor >= 6)
            Object.Destroy(gameObject);
    }
}
