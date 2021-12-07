using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class monsterSpawnerControl : MonoBehaviour {

    public Transform[] SpawnPoints;
    public GameObject[] monsters;
    int randomSpawnPoint, randomMonster;
    public static bool spawnAllowed;

    // Use this for initialization
    void Start()
    {
        spawnAllowed = true;
        InvokeRepeating("SpawnEnemies", 0f, 1f);

    }
    void SpawnEnemies()
    {
        if (spawnAllowed)
        {
            randomSpawnPoint = Random.Range(0, SpawnPoints.Length);
            randomMonster = Random.Range(0, monsters.Length);
            Instantiate(monsters[randomMonster], SpawnPoints[randomSpawnPoint].position, Quaternion.identity);
        }
    }
}
