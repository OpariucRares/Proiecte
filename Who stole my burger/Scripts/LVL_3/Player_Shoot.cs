using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class Player_Shoot : MonoBehaviour {

    
    public float speed;
    public Transform PozPlayer;
    public GameObject ShootPrefab;
    public GameObject Player;

    


    // Use this for initialization
    void Start () {
        
    }
	
	// Update is called once per frame
	void Update () {


        PozPlayer = Player.GetComponent<Transform>();
        if (Input.GetButtonDown("Jump"))
            Projectile();

	}


    void Projectile()
    {
        
        var shoot = (GameObject)Instantiate(ShootPrefab, PozPlayer.position, PozPlayer.rotation);
        shoot.GetComponent<Rigidbody2D>().velocity += Vector2.right*speed;

        Destroy(shoot, 3f);
    }
}
