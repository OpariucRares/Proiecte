using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.SceneManagement;

public class manager3 : MonoBehaviour {

    public GameObject Enemy;
    
    public static bool canmove;
    public static int PlayerHit, EnemyHit;
    public static bool EnemyCanMove = true;
    public static bool canshoot = false;

    private void Start()
    {
        canmove = true;
        EnemyCanMove = true;
        canshoot = false;
        PlayerHit = 0;
        EnemyHit = 0;
    }

    // Update is called once per frame
    void Update () {
        if (PlayerHit > 3 || EnemyHit > 120)
        {
            Destroy(Enemy);
            canshoot = false;
            canmove = false;
            Invoke("LoadScene", 5f);

        }

    }

    public void LoadScene()
    {
        SceneManager.LoadScene(1);
    }
}
