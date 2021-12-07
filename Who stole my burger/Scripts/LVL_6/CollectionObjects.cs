using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class CollectionObjects : MonoBehaviour {

    void OnTriggerEnter2D(Collider2D collision)
    {
        ScoreTextScript.objectsamount += 1;
        Destroy(gameObject);
        
    }

}
