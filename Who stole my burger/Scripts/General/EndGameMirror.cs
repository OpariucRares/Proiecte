﻿ using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.SceneManagement;

public class EndGameMirror : MonoBehaviour {



    private void OnTriggerEnter2D(Collider2D collision)
    {


        if (collision.gameObject.name == "Player")
        {
            SceneManager.LoadScene(1);
            manager_level.contor++;
        }
    }
}
