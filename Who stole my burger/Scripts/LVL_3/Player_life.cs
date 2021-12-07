using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.UI;

public class Player_life : MonoBehaviour {


     Image Player_L;

    public Sprite L0;
    public Sprite L1;
    public Sprite L2;
    public Sprite L3;
     public Sprite L4;


    void Start () {
        Player_L = gameObject.GetComponent<Image>();
    }
	
	// Update is called once per frame
	void Update () {
        if (manager3.PlayerHit == 1)
            Player_L.sprite = L1;
        if (manager3.PlayerHit == 2)
            Player_L.sprite = L2;
        if (manager3.PlayerHit == 3)
            Player_L.sprite = L3;
        if (manager3.PlayerHit == 4)
            Player_L.sprite = L4;

    }
}
