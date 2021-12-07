using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class B2 : MonoBehaviour {


    public Rigidbody2D mybody;
    public float jumpheight;

    private void Start()
    {
        mybody = gameObject.GetComponentInParent<Rigidbody2D>();
    }



    private void OnCollisionEnter2D(Collision2D collision)
    {
        if (collision.gameObject.name == "Platforms")
            mybody.velocity = jumpheight * Vector2.up;
    }

}
