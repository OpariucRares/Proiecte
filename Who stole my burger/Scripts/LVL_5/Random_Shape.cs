using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.UI;

public class Random_Shape : MonoBehaviour {

    public Text T;
    int r;
    bool canInvoke=true;
	// Use this for initialization
	void Start () {
        T.text = "SQUARE";

    }
	
	// Update is called once per frame
	void Update () {

        if (canInvoke)
        { Invoke("Change_T", 7f);
            canInvoke = false;
        }
	}

    void Change_T()
    {
        r = Random.Range(1, 6);

        if (r == 1)
            T.text = "SQUARE";
        if (r == 2)
            T.text = "TRIANGLE";
        if (r == 3)
            T.text = "CIRCLE";
        if (r == 4)
            T.text = "BLUE";
        if (r == 5)
            T.text = "RED";
        canInvoke = true;
    }


}
