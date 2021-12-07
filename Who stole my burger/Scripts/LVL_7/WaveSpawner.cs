using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.SceneManagement;

public class WaveSpawner : MonoBehaviour {

    public enum SpawnState { SPAWNING, WAITING, COUNTING};
    [SerializeField] private string newLevel;
    [System.Serializable] //change the variables of the Unity inspector
	public class Wave
    {
        public string name;
        public Transform enemy;
        public int count;
        public float rate;
    }
    public Wave[] waves;
    private int nextWave = 0;
    public float timeBetweenWaves = 5f;
    public float waveCountdown;
    private SpawnState state = SpawnState.COUNTING;

    private float searchCountdown = 1f;

    void Start()
    {
        waveCountdown = timeBetweenWaves;
    }
    void Update()
    {
        
        if (state == SpawnState.WAITING)
        {
            //Check if enemies are still alive
            if (EnemyIsAlive() == false)
            {
                //Begin a new round
                WaveCompleted();
                return;
            }
            else return;
        }
        if (waveCountdown <= 0) 
        {
            if (state != SpawnState.SPAWNING)
            {
                //start spawning wave
                //because is a IEnumerator method
                StartCoroutine(SpawnWave(waves[nextWave]));
            }
        }
        else
        {
            waveCountdown -= Time.deltaTime;
        }
    }

    void WaveCompleted()
    {
        Debug.Log("Wave completed");

        state = SpawnState.COUNTING;
        waveCountdown = timeBetweenWaves;

        if (nextWave + 1 > waves.Length - 1)
        {
            nextWave = 0;
            Debug.Log("All waves Complete! Looping...");
            
            SceneManager.LoadScene(1);
            manager_level.contor++;
            Object.Destroy(gameObject);
        }
        else
        {
            nextWave++;
        }

        
    }
    bool EnemyIsAlive()
    {
        searchCountdown -= Time.deltaTime;
        if (searchCountdown <= 0f)
        {
            searchCountdown = 1f;
            if (GameObject.FindGameObjectWithTag("Enemy") == null)
            {
                return false;
            }
        }
        return true;
    }

    //wait a certain amount of seconds inside of the method
    IEnumerator SpawnWave (Wave _wave)
    {
        Debug.Log("Spawning Wave: " + _wave.name);
        state = SpawnState.SPAWNING;

        //Spawn
        for (int i = 0; i < _wave.count; i++)
        {
            SpawnEnemy(_wave.enemy);
            yield return new WaitForSeconds(1f/_wave.rate);
        }

        state = SpawnState.WAITING;
        yield break; //returns nothing
    }
    void SpawnEnemy (Transform _enemy)
    {
        //spawn enemy
        Debug.Log("Spawning enemy: " + _enemy.name);
        Instantiate(_enemy, transform.position, transform.rotation);
        
    }
}
