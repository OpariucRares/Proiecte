using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class movement4 : MonoBehaviour {


    public float speed, up1,up2;
     
    private Rigidbody2D R;
    bool canJump = true;
	
	void Start () {
        R = GetComponent<Rigidbody2D>();
        
	}
	
	// Update is called once per frame
	void Update () {
        if (manager4.canmove)
        {
            
            transform.Translate(Vector3.right * speed*Time.deltaTime);
            if (canJump)
            {
                if (Input.GetButtonDown("Jump"))
                {
                    R.velocity += Vector2.up * up1;
                }

                if(Input.GetKeyDown(KeyCode.W))
                {
                    R.velocity += Vector2.up * up2;

                }

            }
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
}
