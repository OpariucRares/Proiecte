using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class projectile_player : MonoBehaviour {

    public float speed = 1.5f;
    private Vector3 target;

    void Start()
    {
        target = Camera.main.ScreenToWorldPoint(Input.mousePosition);
    }

    void Update()
    {
        if (Input.GetMouseButtonDown(0))
        {
            target = Camera.main.ScreenToWorldPoint(Input.mousePosition);
            target.z = transform.position.z;
        }
        transform.position = Vector3.MoveTowards(transform.position, target, speed * Time.deltaTime);
        if (target.x == transform.position.x && target.y == transform.position.y)
            Object.Destroy(gameObject);
    }
    public void OnTriggerEnter2D(Collider2D other)
    {
        if (other.tag == "Enemy")
        {
            health_bar_script.health -= 33f;
            Object.Destroy(gameObject);
        }

    }
}
