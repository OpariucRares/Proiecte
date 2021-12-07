using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.UI;

public class Show_Lives : MonoBehaviour {

    void Update()
    {
      

        if (manager2.health == 2)
        {
            gameObject.GetComponent<Text>().text = "2";

        }
        if (manager2.health == 1)
        {
            gameObject.GetComponent<Text>().text = "1";

        }
        if (manager2.health == 0)
        {

            gameObject.GetComponent<Text>().text = "0";
        }
    }
}
