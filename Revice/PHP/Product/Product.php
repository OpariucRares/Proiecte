<?php
require_once 'DBProperties.php';
    class Product implements \JsonSerializable {
        private $id;
        private $name;
        private $price;
        private $store;
        private $rating;
        private $color;
        private $link;
        private $photo;
        private $type;
        private $properties;


        /**
         * @param $id
         * @param $name
         * @param $price
         * @param $store
         * @param $rating
         * @param $color
         * @param $link
         * @param $photo
         * @param $type
         */
        public function __construct($id, $name, $price, $store, $rating, $color, $link, $photo, $type)
        {
            $this->id = $id;
            $this->name = $name;
            $this->price = $price;
            $this->store = $store;
            $this->rating = $rating;
            $this->color = $color;
            $this->link = $link;
            $this->photo = $photo;
            $this->type = $type;
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
        public function getPrice()
        {
            return $this->price;
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
        public function getRating()
        {
            return $this->rating;
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
        public function getPhoto()
        {
            return $this->photo;
        }

        /**
         * @return mixed
         */
        public function getType()
        {
            return $this->type;
        }

        /**
         * @return mixed
         */
        public function getProperties()
        {
            return $this->properties;
        }
        public function setProperties(){
            $this->properties= (new DBProperties)->getPropertiesById($this->id);
        }

        public function jsonSerialize()
        {
            return get_object_vars($this);
        }

        public function set($data) {

                    //echo $value .'<br>';
                    foreach ($data AS $key1 => $value1){
                        //echo json_encode($value1) .'<br>';
                        if($key1=='properties'){
                            //echo $value1;
                            $contor=0;
                            if($value1) {
                                foreach ($value1 as $dataprop) {
                                    $prop = new Properties(null, null, null, null);
                                    $prop->set($dataprop);
                                    $this->properties[$contor] = $prop;
                                    $contor++;
                                }
                            }
                        }
                        else
                        $this->{$key1} = $value1;

                    }
                }

    }
?>