using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class FlyMovement : MonoBehaviour {

    public float speed;
    bool canloselife = true;



    
    // Update is called once per frame
    void Update () {

        if(Menu.IsPaused)
        transform.Translate(Vector2.right * speed);
       

    }
    
    private void OnTriggerEnter2D(Collider2D collision)
    {
        if (canloselife&& collision.gameObject.name=="Player")
        {
            manager2.health -= 1;
            canloselife = false;
        }
      
    }
    private void OnTriggerExit2D(Collider2D collision)
    {
        canloselife = true;
    }
    

}
