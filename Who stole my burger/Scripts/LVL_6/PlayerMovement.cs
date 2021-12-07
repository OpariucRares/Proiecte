using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.SceneManagement;

public class PlayerMovement : MonoBehaviour {

    [SerializeField] private string newLevel;
    public float speed;
    public float jumpForce;
    private float moveInput;
    public static Vector3 respawnPoint;
   

    private Rigidbody2D rb;

    private bool facingRight = true;

    bool isGrounded = false;
    public Transform groundCheck;

    public float checkRadius;
    public LayerMask whatisGround;

    private int extraJumps;
    public int extraJumpsvalue;

    public Animator animator;


    void Start()
    {
        extraJumps = extraJumpsvalue;
        rb = GetComponent<Rigidbody2D>();

        
        respawnPoint = transform.position;
    }


    void FixedUpdate()
    {
        isGrounded = Physics2D.OverlapCircle(groundCheck.position, checkRadius, whatisGround);
        animator.SetBool("isJump", isGrounded);



        moveInput = Input.GetAxis("Horizontal");
        rb.velocity = new Vector2(moveInput * speed, rb.velocity.y);


        if (moveInput > 0 && !facingRight)
            Flip();
        else if (moveInput < 0 && facingRight) Flip();



    }

    void Update()
    {

        if (isGrounded == true)
            extraJumps = 2;
        if (((Input.GetKeyDown(KeyCode.UpArrow) || Input.GetKeyDown(KeyCode.W) || (Input.GetKeyDown(KeyCode.Space)) && extraJumps > 0)))
        {
            rb.velocity = Vector2.up * jumpForce;
            animator.SetBool("isJump", true);
            GetComponent<Rigidbody2D>().AddForce(new Vector2(0, jumpForce));


        } else if (((Input.GetKeyDown(KeyCode.UpArrow) || Input.GetKeyDown(KeyCode.W) || (Input.GetKeyDown(KeyCode.Space)) && extraJumps == 0 && isGrounded == true)))
        {
            rb.velocity = Vector2.up * jumpForce;
            animator.SetBool("isJump", true);
            GetComponent<Rigidbody2D>().AddForce(new Vector2(0, jumpForce));

        }
    }
    void OnTriggerEnter2D(Collider2D other)
    {
        if (other.tag == "Enemy")
        {
            manager6.health--;
            transform.position = respawnPoint;

        }
        else if (other.tag == "Coletable")
        {

            Destroy(other.gameObject);

        }
        else if (other.tag == "Portal" && ScoreTextScript.objectsamount == 3)
        {
            SceneManager.LoadScene(1);
            manager_level.contor++;
        }
        else if (other.tag == "Portal" && ScoreTextScript.objectsamount < 3)
        {
            ScoreTextScript.objectsamount = 0;
            manager6.health = 3;
            transform.position = respawnPoint;
        }
        else if (other.tag == "checkpoint")
        {
            respawnPoint = other.transform.position;
        }
        else if (other.tag == "Shark")
        {
            manager6.health--;
            SceneManager.LoadScene(7);

        }
      
    }
    void Flip()
    {
        facingRight = !facingRight;
        Vector3 thescale = transform.localScale;
        thescale.x *= -1;
        transform.localScale = thescale;
    }
    
}
