<?php

class Properties implements \JsonSerializable
{
    private $id;
    private $id_product;
    private $name;
    private $value;

    /**
     * @param $id
     * @param $id_product
     * @param $name
     * @param $value
     */
    public function __construct($id, $id_product, $name, $value)
    {
        $this->id = $id;
        $this->id_product = $id_product;
        $this->name = $name;
        $this->value = $value;
    }


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return mixed
     */
    public function getIdProduct()
    {
        return $this->id_product;
    }
    public function set($data) {
        //echo json_encode($data). '<br>';
        foreach ($data AS $key => $value) {
            $this->{$key} = $value;

        }
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}