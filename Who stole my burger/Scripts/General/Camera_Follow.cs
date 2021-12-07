using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class Camera_Follow : MonoBehaviour {

    public GameObject player;
    
	
	
    private void LateUpdate()
    {
        if(player.transform.position.x>-10.01f)
        transform.position = new Vector3(player.transform.position.x, 0.54f, -10f);
       
    }
}
