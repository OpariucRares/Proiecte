using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.UI;

public class Enemy_life : MonoBehaviour {



    public Image Enemy_L;

    public Sprite L0;
    public Sprite L1;
    public Sprite L2;
    public Sprite L3;
    public Sprite L4;
    public Sprite L5;
    public Sprite L6;
    public Sprite L7;

    // Use this for initialization
    void Start () {
        Enemy_L = gameObject.GetComponent<Image>();
	}
	
	// Update is called once per frame
	void Update () {

        if (manager3.EnemyHit >= 15 && manager3.EnemyHit < 30)
            Enemy_L.sprite = L1;
        if (manager3.EnemyHit >= 30 && manager3.EnemyHit < 45)
            Enemy_L.sprite = L2;
        if (manager3.EnemyHit >= 45 && manager3.EnemyHit < 60)
            Enemy_L.sprite = L3;
        if (manager3.EnemyHit >= 60 && manager3.EnemyHit < 75)
            Enemy_L.sprite = L4;
        if (manager3.EnemyHit >= 75 && manager3.EnemyHit < 90)
            Enemy_L.sprite = L5;
        if (manager3.EnemyHit >= 90 && manager3.EnemyHit < 105)
            Enemy_L.sprite = L6;
        if (manager3.EnemyHit >= 105 && manager3.EnemyHit < 120)
            Enemy_L.sprite = L7;
        if (manager3.EnemyHit >= 120)
            Destroy(Enemy_L, 1f);



    }
}
