using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class Respawn : MonoBehaviour {

    public GameObject Bird1;
    public GameObject Bird2;
    public GameObject Bird3;
    public GameObject Plane1;
    public GameObject Plane2;
    public GameObject Plane3;
  public  Vector3 originalPos1;
    Vector3 originalPos2;
    Vector3 originalPos3;
    Vector3 originalPos4;
    Vector3 originalPos5;
    Vector3 originalPos6;



    // Use this for initialization
    void Start () {
        originalPos1 = Bird1.transform.position;
        originalPos2 = Bird2.transform.position;
        originalPos3 = Bird3.transform.position;
        originalPos4 = Plane1.transform.position;
        originalPos5 = Plane2.transform.position;
        originalPos6 = Plane3.transform.position;
    }

    // Update is called once per frame
    private void OnTriggerEnter2D(Collider2D collision)
    {
       
    
            Bird1.transform.position = originalPos1;
            Bird2.transform.position = originalPos2;
            Bird3.transform.position= originalPos3;
            Plane1.transform.position= originalPos4;
            Plane2.transform.position= originalPos5;
            Plane3.transform.position= originalPos6;


    }
}
