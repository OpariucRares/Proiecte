using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class movement2 : MonoBehaviour {


    public float speed;
    Rigidbody2D mybody;
    private bool facingRight = true;
    private float moveInput;
    // Use this for initialization
    void Start () {
        mybody = gameObject.GetComponent<Rigidbody2D>();
    }
	
	// Update is called once per frame
	void Update () {
        if(manager2.canmove)
        Move(Input.GetAxisRaw("Horizontal"));


    }
    void FixedUpdate()
    {
        moveInput = Input.GetAxis("Horizontal");
       if (moveInput > 0 && !facingRight)
            Flip();
        else if (moveInput < 0 && facingRight) Flip();
    }



    public void Move(float HI)
    {
        Vector2 moveVel = mybody.velocity;
        moveVel.x = HI * speed;
        mybody.velocity = moveVel;
    }
    void Flip()
    {
        facingRight = !facingRight;
        Vector3 thescale = transform.localScale;
        thescale.x *= -1;
        transform.localScale = thescale;
    }
}
