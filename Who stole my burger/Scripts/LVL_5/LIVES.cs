using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.UI;

public class LIVES : MonoBehaviour {

    void Update()
    {


        if (manager5.health == 2)
        {
            gameObject.GetComponent<Text>().text = "2";


        }
        if (manager5.health == 1)
        {
            gameObject.GetComponent<Text>().text = "1";

        }
        if (manager5.health == 0)
        {

            gameObject.GetComponent<Text>().text = "0";
        }
    }
}
