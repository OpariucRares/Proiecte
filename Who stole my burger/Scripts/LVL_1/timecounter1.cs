using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.UI;
public class timecounter1 : MonoBehaviour {

    public float time_i, time_f = 64f;

    public Image Holder;

    public Sprite nr0;
    public Sprite nr1;
    public Sprite nr2;
    public Sprite nr3;
    public Sprite nr4;
    public Sprite nr5;
    public Sprite nr6;
    public Sprite nr7;
    public Sprite nr8;
    public Sprite nr9;
    public Sprite nr10;
    public Sprite nr11;
    public Sprite nr12;
    public Sprite nr13;
    public Sprite nr14;
    public Sprite nr15;



    // Use this for initialization
    void Start()
    {
        Holder = gameObject.GetComponent<Image>();
    }

    // Update is called once per frame
    void Update()
    {


        if (time_i >= time_f)
        {
            manager.respawn = true;
            manager.health -= 1;
            Holder.sprite = nr0;
        }

        time_i += Time.deltaTime;

        if (time_i >= 0 && time_i <= time_f / 16)
            Holder.sprite = nr0;
        if (time_i >= time_f / 16 && time_i <= time_f / 16 * 2)
            Holder.sprite = nr1;
        if (time_i >= time_f / 16 * 2 && time_i <= time_f / 16 * 3)
            Holder.sprite = nr2;
        if (time_i >= time_f / 16 * 3 && time_i <= time_f / 16 * 4)
            Holder.sprite = nr3;
        if (time_i >= time_f / 16 * 4 && time_i <= time_f / 16 * 5)
            Holder.sprite = nr4;
        if (time_i >= time_f / 16 * 5 && time_i <= time_f / 16 * 6)
            Holder.sprite = nr5;
        if (time_i >= time_f / 16 * 6 && time_i <= time_f / 16 * 7)
            Holder.sprite = nr6;
        if (time_i >= time_f / 16 * 7 && time_i <= time_f / 16 * 8)
            Holder.sprite = nr7;
        if (time_i >= time_f / 16 * 8 && time_i <= time_f / 16 * 9)
            Holder.sprite = nr8;
        if (time_i >= time_f / 16 * 9 && time_i <= time_f / 16 * 10)
            Holder.sprite = nr9;
        if (time_i >= time_f / 16 * 10 && time_i <= time_f / 16 * 11)
            Holder.sprite = nr10;
        if (time_i >= time_f / 16 * 11 && time_i <= time_f / 16 * 12)
            Holder.sprite = nr11;
        if (time_i >= time_f / 16 * 12 && time_i <= time_f / 16 * 13)
            Holder.sprite = nr12;
        if (time_i >= time_f / 16 * 13 && time_i <= time_f / 16 * 14)
            Holder.sprite = nr13;
        if (time_i >= time_f / 16 * 14 && time_i <= time_f / 16 * 15)
            Holder.sprite = nr14;
        if (time_i >= time_f / 16 * 15 && time_i <= time_f / 16 * 16)
            Holder.sprite = nr15;



    }
}
