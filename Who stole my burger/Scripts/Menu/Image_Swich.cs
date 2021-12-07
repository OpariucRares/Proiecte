using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class Image_Swich : MonoBehaviour {


    public int counter = 1;
    public GameObject Image1;
    public GameObject Image2;
    public GameObject Image3;
    public GameObject Image4;
    public GameObject Image5;
    public GameObject Image6;
    public GameObject Image7;
    public GameObject Image8;
    public GameObject Image9;

	// Use this for initialization
	void Start () {
		
	}
	
	// Update is called once per frame
	void Update () {
        if (counter == 1)
        {
            Image1.SetActive(true);
            Image2.SetActive(false);
            Image3.SetActive(false);
            Image4.SetActive(false);
            Image5.SetActive(false);
            Image6.SetActive(false);
            Image7.SetActive(false);
            Image8.SetActive(false);
            Image9.SetActive(false);
        }
        if (counter == 2)
        {
            Image1.SetActive(false);
            Image2.SetActive(true);
            Image3.SetActive(false);
            Image4.SetActive(false);
            Image5.SetActive(false);
            Image6.SetActive(false);
            Image7.SetActive(false);
            Image8.SetActive(false);
            Image9.SetActive(false);
        }
        if (counter == 3)
        {
            Image1.SetActive(false);
            Image2.SetActive(false);
            Image3.SetActive(true);
            Image4.SetActive(false);
            Image5.SetActive(false);
            Image6.SetActive(false);
            Image7.SetActive(false);
            Image8.SetActive(false);
            Image9.SetActive(false);
        }
        if (counter == 4)
        {
            Image1.SetActive(false);
            Image2.SetActive(false);
            Image3.SetActive(false);
            Image4.SetActive(true);
            Image5.SetActive(false);
            Image6.SetActive(false);
            Image7.SetActive(false);
            Image8.SetActive(false);
            Image9.SetActive(false);
        }
        if (counter == 5)
        {
            Image1.SetActive(false);
            Image2.SetActive(false);
            Image3.SetActive(false);
            Image4.SetActive(false);
            Image5.SetActive(true);
            Image6.SetActive(false);
            Image7.SetActive(false);
            Image8.SetActive(false);
            Image9.SetActive(false);
        }
        if (counter == 6)
        {
            Image1.SetActive(false);
            Image2.SetActive(false);
            Image3.SetActive(false);
            Image4.SetActive(false);
            Image5.SetActive(false);
            Image6.SetActive(true);
            Image7.SetActive(false);
            Image8.SetActive(false);
            Image9.SetActive(false);
        }
        if (counter == 7)
        {
            Image1.SetActive(false);
            Image2.SetActive(false);
            Image3.SetActive(false);
            Image4.SetActive(false);
            Image5.SetActive(false);
            Image6.SetActive(false);
            Image7.SetActive(true);
            Image8.SetActive(false);
            Image9.SetActive(false);
        }
        if (counter == 8)
        {
            Image1.SetActive(false);
            Image2.SetActive(false);
            Image3.SetActive(false);
            Image4.SetActive(false);
            Image5.SetActive(false);
            Image6.SetActive(false);
            Image7.SetActive(false);
            Image8.SetActive(true);
            Image9.SetActive(false);
        }
        if (counter == 9)
        {
            Image1.SetActive(false);
            Image2.SetActive(false);
            Image3.SetActive(false);
            Image4.SetActive(false);
            Image5.SetActive(false);
            Image6.SetActive(false);
            Image7.SetActive(false);
            Image8.SetActive(false);
            Image9.SetActive(true);
        }
    }

    public void Clicked_Right()
    {
        if (counter + 1 <= 9)
            counter++;

    }
    public void Clicked_Left()
    {
        if (counter != 1)
            counter--;

    }
}
