using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class Camera_Folow_Up : MonoBehaviour {


    public GameObject player;



    private void LateUpdate()
    {
        if (player.transform.position.y > -1f)
            transform.position = new Vector3(0, player.transform.position.y, -10f);

    }
}
