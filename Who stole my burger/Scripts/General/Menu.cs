using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.SceneManagement;

public class Menu : MonoBehaviour {

    public static bool IsPaused;
    public GameObject Pause_Menu;

    private void Start()
    {
        IsPaused = true;
        Pause_Menu.SetActive(false);
        Time.timeScale = 1f;
    }

    public void Resume()
    {
       
        Pause_Menu.SetActive(false);
        Time.timeScale = 1f;
        IsPaused = true;
        
    }

   public void Pause()
    {
        
        
            Pause_Menu.SetActive(true);
            Time.timeScale = 0f;
            IsPaused = false;
        
    }
    public void LoadMenu()
    {
        SceneManager.LoadScene(1);
        
    }

  
}
