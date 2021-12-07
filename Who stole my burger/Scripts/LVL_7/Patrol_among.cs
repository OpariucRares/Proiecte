using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class Patrol_among : MonoBehaviour {

    public float speed;
    public Vector3 Position1;
    public Vector3 Position2;


    void Update()
    {
        transform.position = Vector2.MoveTowards(transform.position, Position1, speed * Time.deltaTime);
        if (Vector2.Distance(transform.position, Position1) < 0.2f)
        {
            Position1.y = Position2.y;
            Position1.x= Position2.x;

        }
        if (health_bar_script.health <= 0)
        {
            Object.Destroy(gameObject);
        }
        
    }
    



}
