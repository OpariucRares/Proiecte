using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class movement5 : MonoBehaviour {



    public static float Z;
     Vector3 Rotation;

    void Start()
    {
    Rotation = new Vector3(0,0,5);
    }

    void FixedUpdate()
    {
        

        if (Input.GetKey("d") )
        {
            gameObject.transform.Rotate( -Rotation);
            Z += 10;

        }

        if (Input.GetKey("a"))
        {
            gameObject.transform.Rotate ( Rotation);
            Z -= 10;

        }
    }

 
}
