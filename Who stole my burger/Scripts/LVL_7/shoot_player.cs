using System.Collections;
using System.Collections.Generic;
using UnityEngine;


public class shoot_player : MonoBehaviour
{
    private List<GameObject> letters = new List<GameObject>();
    public GameObject letterPrefab;
    public float letterVelocity;
    Vector3 direction;

    public Rigidbody2D projectile;

    public Transform projectileSpawnPoint;

    public float projectileVelocity;

    public float timeBetweenShots;
    private float timeBetweenShotsCounter;

    private bool canShoot;

    private void Start()
    {
        canShoot = false;

        timeBetweenShotsCounter = timeBetweenShots;

    }

    void Update()
    {
        direction = Input.mousePosition;
        direction.z = 0.0f;
        direction = Camera.main.ScreenToWorldPoint(direction);
        direction = direction - transform.position;
        if (Input.GetMouseButtonDown(0) && canShoot)
        {
            GameObject letter = (GameObject)Instantiate(letterPrefab, transform.position, Quaternion.identity);
            letters.Add(letter);
            canShoot = false; 
        }
        if (!canShoot)
        {
            timeBetweenShotsCounter -= Time.deltaTime;

            if (timeBetweenShotsCounter <= 0)
            {
                canShoot = true;
                timeBetweenShotsCounter = timeBetweenShots;
            }
        }
    }
    
}


