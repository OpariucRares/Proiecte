using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class movement : MonoBehaviour {

    public float speed=3f, jumpheight=4f;
    public static bool canJump = true;
    private bool facingRight = true;
    private float moveInput;

    Rigidbody2D mybody;

	// Use this for initialization
	void Start () {
        mybody = gameObject.GetComponent<Rigidbody2D>();
               
    }
    void FixedUpdate()
    {
        moveInput = Input.GetAxis("Horizontal");
        if (moveInput > 0 && !facingRight)
            Flip();
        else if (moveInput < 0 && facingRight) Flip();
    }

    // Update is called once per frame
    void Update () {
        if (manager.canmove)
        {
            Move(Input.GetAxisRaw("Horizontal"));
            if (Input.GetButtonDown("Jump"))
                Jump();
        }
	}

    
    private void OnCollisionEnter2D(Collision2D collision)
    {
        
        canJump = true;
        
    }
    private void OnCollisionExit2D(Collision2D collision)
    {
        canJump = false;
    }

    public void Move(float HI)
    {
        Vector2 moveVel = mybody.velocity;
        moveVel.x = HI * speed;
        mybody.velocity = moveVel;
    }

    public void Jump()
    {
        if(canJump)
        mybody.velocity += jumpheight * Vector2.up;

    }
    void Flip()
    {
        facingRight = !facingRight;
        Vector3 thescale = transform.localScale;
        thescale.x *= -1;
        transform.localScale = thescale;
    }
}
