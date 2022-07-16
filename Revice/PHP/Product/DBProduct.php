<?php
require_once 'Product.php';
require_once $_SERVER['DOCUMENT_ROOT'] .'/PHP/DBConnection.php';
class DBProduct
{
    public function getProductById($id): ?Product
    {
        $dbHandler = new DBConnection();
        $select = $dbHandler->conn->prepare('select id,name,price,rating,store,color,link,photo,type from products where id=?');
        $select->execute([$id]);

        if($result=$select->fetch()){
            return new Product($result['id'],$result['name'],$result['price'],$result['store'],$result['rating'],$result['color'],$result['link'],$result['photo'],$result['type']);
        }
        return null;
    }
    public function getProducts(): array
    {
        $dbHandler = new DBConnection();
        $select = $dbHandler->conn->prepare('select id,name,price,rating,store,color,link,photo,type from products');
        $select->execute();
        $contor=0;
        while($result=$select->fetch()){
            $products[$contor]= new Product($result['id'],$result['name'],$result['price'],$result['store'],$result['rating'],$result['color'],$result['link'],$result['photo'],$result['type']);
            $contor++;
        }
        return $products;
    }
    public function getFiltredProducts($query)
    {
        $dbHandler = new DBConnection();
        $select = $dbHandler->conn->prepare($query);
        $select->execute();
        $contor=0;
        while($result=$select->fetch()){
            $products[$contor]= new Product($result['id'],$result['name'],$result['price'],$result['store'],$result['rating'],$result['color'],$result['link'],$result['photo'],$result['type']);
            $contor++;
        }
        return $products;
    }
    public function getProductsByRandom($type): array
    {
        $dbHandler = new DBConnection();
        $select = $dbHandler->conn->prepare('select id,name,price,rating,store,color,link,photo,type from products where type=? order by rand()');
        $select->execute([$type]);
        $products[] =array();
        $contor=0;
        while(($result=$select->fetch())&&$contor<4){
            $products[$contor]= new Product($result['id'],$result['name'],$result['price'],$result['rating'],$result['store'],$result['color'],$result['link'],$result['photo'],$result['type']);
            $contor++;
        }
        return $products;
    }
    public function getFilterOption($param): array
    {
        $dbHandler = new DBConnection();
        $select = $dbHandler->conn->prepare('SELECT DISTINCT '.$param.' FROM products ORDER BY '.$param);
        $select->execute();
        $contor=0;
        while($result=$select->fetch()){
            $products[$contor]= $result[$param];
            $contor++;
        }
        return $products;
    }
    public function getFiltredNumber($query)
    {
        $dbHandler = new DBConnection();
        $select = $dbHandler->conn->prepare($query);
        $select->execute();
        return $select->rowCount();
    }
}