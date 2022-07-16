<?php

class Product
{
    private $id;
    private $price;
    private $rating;
    private $name;
    private $brand;
    private $store;
    private $color;
    private $link;
    private $type;
    private $properties=array();

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @return mixed
     */
    public function getRating()
    {
        return $this->rating;
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
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * @return mixed
     */
    public function getStore()
    {
        return $this->store;
    }

    /**
     * @return mixed
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @return mixed
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }
}