using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.SceneManagement;

public class theEnd : MonoBehaviour {

    private void OnTriggerEnter2D(Collider2D collision)
    {


        if (collision.gameObject.name == "Player")
        {
            SceneManager.LoadScene(11);
            manager_level.contor = 10;
        }
    }
}
