using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.UI;

public class ShowLives8 : MonoBehaviour {

    void Update()
    {
        if (manager8.health == 5)
        {
            gameObject.GetComponent<Text>().text = "5";

        }
        if (manager8.health == 4)
        {
            gameObject.GetComponent<Text>().text = "4";

        }
        if (manager8.health == 3)
        {
            gameObject.GetComponent<Text>().text = "3";

        }
        if (manager8.health == 2)
        {
            gameObject.GetComponent<Text>().text = "2";

        }
        if (manager8.health == 1)
        {
            gameObject.GetComponent<Text>().text = "1";

        }
        if (manager8.health == 0)
        {

            gameObject.GetComponent<Text>().text = "0";
        }
    }
}
