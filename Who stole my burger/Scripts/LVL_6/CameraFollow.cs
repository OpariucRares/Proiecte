using UnityEngine;

public class CameraFollow : MonoBehaviour {

    public Transform target;

    Vector3 velocity = Vector3.zero;
    public float SmoothTime = 1.5f;

    public bool Ymaxenabled = false;
    public float Ymaxvalue = 0;

    public bool Yminenabled = false;
    public float Yminvalue = 0;

    public bool Xmaxenabled = false;
    public float Xmaxvalue = 0;

    public bool Xminenabled = false;
    public float Xminvalue = 0;


    void FixedUpdate()
    {
        Vector3 targetpos = target.position;
        if (Ymaxenabled && Yminenabled)
            targetpos.y = Mathf.Clamp(target.position.y, Yminvalue, Ymaxvalue);
        else if (Yminenabled)
            targetpos.y = Mathf.Clamp(target.position.y, Yminvalue, target.position.y);
        else if (Ymaxenabled)
            targetpos.y = Mathf.Clamp(target.position.y, target.position.y, Ymaxvalue);


        if (Xmaxenabled && Xminenabled)
            targetpos.x = Mathf.Clamp(target.position.x, Xminvalue, Xmaxvalue);
        else if (Xminenabled)
            targetpos.x = Mathf.Clamp(target.position.x, Xminvalue, target.position.x);
        else if (Xmaxenabled)
            targetpos.x = Mathf.Clamp(target.position.x, target.position.x, Xmaxvalue);



        targetpos.z = transform.position.z;
        transform.position = Vector3.SmoothDamp(transform.position, targetpos, ref velocity, SmoothTime);
    }
}
