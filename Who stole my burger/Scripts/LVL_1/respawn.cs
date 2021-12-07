using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class respawn : MonoBehaviour {

    public GameObject time;

    public GameObject C1;
    public GameObject C2;
    public GameObject C3;
    public GameObject C4;
    public GameObject C5;
    public GameObject C6;

    Vector3 Poz1;
    Vector3 Poz2;
    Vector3 Poz3;
    Vector3 Poz4;
    Vector3 Poz5;
    Vector3 Poz6;


    // Use this for initialization
    void Start () {
        Poz1 = C1.transform.position;
        Poz2 = C2.transform.position;
        Poz3 = C3.transform.position;
        Poz4 = C4.transform.position;
        Poz5 = C5.transform.position;
        Poz6 = C6.transform.position;

	}
	
	// Update is called once per frame
	void Update () {
        if (manager.respawn) {
            transform.position = new Vector3(-8f,-0.4f,-0.1f);
                manager.respawn = false;
            time.GetComponent<timecounter1>().time_i = 0;

            C1.transform.position = Poz1;
            C2.transform.position = Poz2;
            C3.transform.position = Poz3;
            C4.transform.position = Poz4;
            C5.transform.position = Poz5;
            C6.transform.position = Poz6;

        }
	}
}
