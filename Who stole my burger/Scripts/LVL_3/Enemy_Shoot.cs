using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class Enemy_Shoot : MonoBehaviour {

    Vector2 P1;
    Vector2 P2;
    Vector2 P3;
    Vector2 P4;
    Vector2 P5;
    Vector2 POZ;
    public GameObject Player;
    
    public float speed;
    public GameObject ShootPrefab;

    // Use this for initialization
    void Start () {
        P1 = new Vector2(4.5f, -1.8f);
        P2 = new Vector2(4.5f, -0.9f);
        P3 = new Vector2(4.5f, -0f);
        P4 = new Vector2(4.5f, 0.9f);
        P5 = new Vector2(4.5f, 1.8f);

        

    }
	
	// Update is called once per frame
	void Update () {
        POZ.x = Player.GetComponent<Transform>().position.x;
        POZ.y = Player.GetComponent<Transform>().position.y;
        if (POZ == P1 && manager3.canshoot)
        {
            
                Projectile1();

                manager3.canshoot = false;
            Invoke("RestartMove", 5f);

        }
        if (POZ == P5 && manager3.canshoot)
        {
            
                Projectile5();

            manager3.canshoot = false;
            Invoke("RestartMove", 5f);

        }
        if (POZ==P2&& manager3.canshoot)
        {
            
            Projectile2();
            manager3.canshoot = false;
            Invoke("RestartMove", 5f);
        }
        if (POZ == P4&& manager3.canshoot)
        {
            
                Projectile3();
            manager3.canshoot = false;
            Invoke("RestartMove", 5f);
        }

        if(POZ==P3&& manager3.canshoot)
        {
            
                Projectile4();
            manager3.canshoot = false;
            Invoke("RestartMove", 5f);
        }

	}

    void Projectile1()
    {

        var shoot = (GameObject)Instantiate(ShootPrefab,P1,Quaternion.identity);
        shoot.GetComponent<Rigidbody2D>().velocity += Vector2.left * speed;

        Destroy(shoot, 3f);
    }
    void Projectile5()
    {

        var shoot = (GameObject)Instantiate(ShootPrefab, P5, Quaternion.identity);
        shoot.GetComponent<Rigidbody2D>().velocity += Vector2.left * speed;

        Destroy(shoot, 3f);
    }
    void Projectile2()
    {
        

        var shoot1 = (GameObject)Instantiate(ShootPrefab, P2, Quaternion.identity);
        var shoot2 = (GameObject)Instantiate(ShootPrefab,P1, Quaternion.identity);
        var shoot3 = (GameObject)Instantiate(ShootPrefab,P3, Quaternion.identity);
        shoot1.GetComponent<Rigidbody2D>().velocity += Vector2.left * speed;
        shoot2.GetComponent<Rigidbody2D>().velocity += Vector2.left * speed;
        shoot3.GetComponent<Rigidbody2D>().velocity += Vector2.left * speed;

        Destroy(shoot1, 3f);
        Destroy(shoot2, 3f);
        Destroy(shoot3, 3f);
    }
    void Projectile3()
    {
        

        var shoot1 = (GameObject)Instantiate(ShootPrefab, P4, Quaternion.identity);
        var shoot2 = (GameObject)Instantiate(ShootPrefab, P3, Quaternion.identity);
        var shoot3 = (GameObject)Instantiate(ShootPrefab, P5, Quaternion.identity);
        shoot1.GetComponent<Rigidbody2D>().velocity += Vector2.left * speed;
        shoot2.GetComponent<Rigidbody2D>().velocity += Vector2.left * speed;
        shoot3.GetComponent<Rigidbody2D>().velocity += Vector2.left * speed;

        Destroy(shoot1, 3f);
        Destroy(shoot2, 3f);
        Destroy(shoot3, 3f);
    }

    void Projectile4()
    {

        

        
        var shoot1 = (GameObject)Instantiate(ShootPrefab, P1, Quaternion.identity);
        var shoot2 = (GameObject)Instantiate(ShootPrefab, P2, Quaternion.identity);
        
        var shoot4 = (GameObject)Instantiate(ShootPrefab, P4, Quaternion.identity);
        var shoot5 = (GameObject)Instantiate(ShootPrefab, P5, Quaternion.identity);
        shoot1.GetComponent<Rigidbody2D>().velocity += Vector2.left * speed;
        shoot2.GetComponent<Rigidbody2D>().velocity += Vector2.left * speed;
        
        shoot4.GetComponent<Rigidbody2D>().velocity += Vector2.left * speed;
        shoot5.GetComponent<Rigidbody2D>().velocity += Vector2.left * speed;

        
        
        Destroy(shoot1, 3f);
        Destroy(shoot2, 3f);

        Destroy(shoot4, 3f);
        Destroy(shoot5, 3f);
    }

    void RestartMove()
    {
        manager3.EnemyCanMove = true;
    }
}
