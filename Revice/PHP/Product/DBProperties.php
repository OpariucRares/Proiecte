<?php

require_once 'Properties.php';
class DBProperties
{
    public function getPropertiesById($id): array
    {
        $dbHandler = new DBConnection();
        $select = $dbHandler->conn->prepare('select id,id_product,name,value from properties where id_product=?');
        $select->execute([$id]);
        $properties[]=null;
        $contor=0;
        while($result=$select->fetch()){
            $row=new Properties($result['id'],$result['id_product'],$result['name'],$result['value']);
            $properties[$contor]=$row;
            $contor++;
        }
        return $properties;
    }
}