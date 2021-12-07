using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.UI;

public class show_life : MonoBehaviour {

	
	
	
	// Update is called once per frame
	void Update () {
        if(manager.health== 2)
        {
            gameObject.GetComponent<Text>().text = "2";
            

        }
        if(manager.health==1)
        {
            gameObject.GetComponent<Text>().text = "1";
            
        }
        if(manager.health==0)
        {

            gameObject.GetComponent<Text>().text = "0";
        }
	}
}
