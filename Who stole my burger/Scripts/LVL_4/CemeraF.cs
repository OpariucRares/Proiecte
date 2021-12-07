using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class CemeraF : MonoBehaviour {

    public GameObject player;



    private void LateUpdate()
    {
        if (player.transform.position.x > -9f)
            transform.position = new Vector3(player.transform.position.x+2, -0.5f, -10f);

    }
}
