using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class check : MonoBehaviour {

	// Use this for initialization
	void Start () {
		
	}
	
	// Update is called once per frame
	void Update () {
        if (manager_level.contor >= 2)
            Object.Destroy(gameObject);
	}
}
