﻿using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.UI;

public class daca : MonoBehaviour {

    Image Healthbar;
    public float maxhealth = 200f;
    public static float health;
    // Use this for initialization
    void Start()
    {
        Healthbar = GetComponent<Image>();
        health = maxhealth;
    }

    // Update is called once per frame
    void Update()
    {
        Healthbar.fillAmount = health / maxhealth;

    }
}
