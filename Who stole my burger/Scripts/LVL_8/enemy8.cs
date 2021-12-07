using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class enemy8 : MonoBehaviour
{

    public float maxspeed = 5;
    // Use this for initialization
    void Start()
    {

    }

    // Update is called once per frame
    void Update()
    {
        Vector3 pos = transform.position; // this gets the current position
        pos.y -= maxspeed * Time.deltaTime;
        transform.position = pos;
    }
    void OnTriggerEnter2D(Collider2D other)
    {
        if (other.gameObject.tag == "Player")
        {
            manager8.health--;
            Object.Destroy(gameObject);
            manager8.cont++;
        }
        else if (other.gameObject.tag == "Enemy")
        {
            Object.Destroy(gameObject);
            manager8.cont++;
        }
    }
}
