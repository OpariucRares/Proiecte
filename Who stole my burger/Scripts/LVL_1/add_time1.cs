using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class add_time1 : MonoBehaviour {

    public GameObject time;

    public float goback;


    // Update is called once per frame

    private void OnTriggerEnter2D(Collider2D collision)
    {
        if (time.GetComponent<timecounter1>().time_i >= goback)
        {
            time.GetComponent<timecounter1>().time_i -= goback;
            transform.position = new Vector3(-10, -10, 0);
        }

    }
}
