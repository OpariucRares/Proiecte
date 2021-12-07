using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class shoot : MonoBehaviour {


    private float timeBtwShoots;
    public float StartsTimeBtwShoots;
    public GameObject projectile;

	// Use this for initialization
	void Start () {
        timeBtwShoots = StartsTimeBtwShoots;
		
	}
	
	// Update is called once per frame
	void Update () {
		
        if (timeBtwShoots <= 0)
        {
            Instantiate(projectile, transform.position, Quaternion.identity);
            timeBtwShoots = StartsTimeBtwShoots;
        }
        else
        {
            timeBtwShoots -= Time.deltaTime;
        }
	}
    
}


