using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.UI;

public class Spawn_Enemy : MonoBehaviour {


    public GameObject Square_R;
    public GameObject Square_B;
    public GameObject Cercle_R;
    public GameObject Cercle_B;
    public GameObject Triangle_R;
    public GameObject Triangle_B;

    
    
    Vector2 POZ;
    public static int i;
    int j,k;
    public static bool canSpawn = true;
    public float speed;

    // Use this for initialization
    void Start () {
        
    }

    // Update is called once per frame
    void Update()
    {
    if (canSpawn)
       {
                Random_Poz();
                Random_Shape();
                canSpawn = false;
                Invoke("CanSpawn", 3f);
      }
    
    }
    void CanSpawn()
    {
        canSpawn = true;

    }


    void Random_Shape()
    {
        

        if (canSpawn)
        {


            i = Random.Range(1, 7);
            if (i == 1)
            {
               var Enemy = Instantiate(Square_R, POZ, Quaternion.identity);
                Enemy.GetComponent<Rigidbody2D>().velocity += (Vector2.zero - POZ)*speed;
            }

            if (i == 2)
            {
                var Enemy = Instantiate(Square_B, POZ, Quaternion.identity);
                Enemy.GetComponent<Rigidbody2D>().velocity += (Vector2.zero - POZ) * speed;
            }

            if (i == 3)
            {
                var Enemy = Instantiate(Cercle_R, POZ, Quaternion.identity);
                Enemy.GetComponent<Rigidbody2D>().velocity += (Vector2.zero - POZ) * speed;
            }

            if (i == 4)
            {
                var Enemy = Instantiate(Cercle_B, POZ, Quaternion.identity);
                Enemy.GetComponent<Rigidbody2D>().velocity += (Vector2.zero - POZ) * speed;
            }

            if (i == 5)
            {
                var Enemy = Instantiate(Triangle_R, POZ, Quaternion.identity);
                Enemy.GetComponent<Rigidbody2D>().velocity += (Vector2.zero - POZ) * speed;
            }

            if (i == 6)
            {
                var Enemy = Instantiate(Triangle_B, POZ, Quaternion.identity);
                Enemy.GetComponent<Rigidbody2D>().velocity += (Vector2.zero - POZ) * speed;
                
            }

        }

      
      
    }


    void Random_Poz()
    {
        j = Random.Range(1, 12);
        if (j == 1)
            POZ =new Vector2(-5f, 4f);
        if (j == 2)
            POZ =new Vector2(-5f, -4f);
        if (j == 3)
            POZ =new Vector2(5f, 4f);
        if (j == 4)
            POZ =new Vector2(5f, -4f);
        if (j == 5)
            POZ =new Vector2(-8f, 2.5f);
        if (j == 6)
            POZ =new Vector2(-8f, -2.5f);
        if (j == 7)
            POZ =new Vector2(8f, 2.5f);
        if (j == 8)
            POZ =new Vector2(8f, -2.5f);
        if (j == 9)
            POZ = new Vector2(8f, 0);
        if (j == 10)
            POZ = new Vector2(-8f, 0);
        if (j == 11)
            POZ =new Vector2(0, -4f);
    }


  
}
