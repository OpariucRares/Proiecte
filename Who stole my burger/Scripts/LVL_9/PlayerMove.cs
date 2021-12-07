using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.SceneManagement;

public class PlayerMove : MonoBehaviour
{

    [SerializeField] private string newLevel;
    public float speed;
    private Rigidbody2D rb;
    private float InputHorizontal;
    private float InputVertical;
    public float distance;
    public LayerMask whatisLadder;
    private bool isClimbing;
    public Vector3 respawnPoint;

    private bool facingRight;

    void Start()
    {
        facingRight = true;
        rb = GetComponent<Rigidbody2D>();
        respawnPoint = transform.position;

    }
    private void FixedUpdate()
    {
        InputHorizontal = Input.GetAxisRaw("Horizontal");
        rb.velocity = new Vector2(InputHorizontal * speed, rb.velocity.y);
        RaycastHit2D hitInfo = Physics2D.Raycast(transform.position, Vector2.up, distance, whatisLadder);
        if (hitInfo.collider != null)
        {
            if (Input.GetKeyDown(KeyCode.UpArrow))
            {
                isClimbing = true;
            }
            else
            {
                if (hitInfo.collider == null)
                {
                    isClimbing = false;
                }
            }
        }
        if (isClimbing == true && hitInfo.collider != null)
        {
            InputVertical = Input.GetAxisRaw("Vertical");
            rb.velocity = new Vector2(rb.velocity.x, InputVertical * speed);
            rb.gravityScale = 0;
        }
        else
            rb.gravityScale = 0.9f;


        Flip(InputHorizontal);
    }
    private void Flip(float inputHorizontal)
    {
        if (inputHorizontal > 0 && !facingRight || inputHorizontal < 0 && facingRight)
        {
            facingRight = !facingRight;

            Vector3 theScale = transform.localScale;
            theScale.x *= -1;
            transform.localScale = theScale;
        }
    }
    private void OnTriggerEnter2D(Collider2D other)
    {
        if (other.tag == "Shark")
        {
            transform.position = respawnPoint;
            SceneManager.LoadScene(10);
        }

    }
}
