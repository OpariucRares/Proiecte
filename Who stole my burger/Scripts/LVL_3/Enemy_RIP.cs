using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class Enemy_RIP : MonoBehaviour {


    public GameObject ENEMY;
	// Use this for initialization
	void Start () {
		
	}
	
	// Update is called once per frame
	void Update () {
        if (manager3.EnemyHit >= 120)
        {
            Destroy(ENEMY, 1);
            manager_level.contor = 4;
        }
        
    }
}
