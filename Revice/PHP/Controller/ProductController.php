<?php
require_once $_SERVER['DOCUMENT_ROOT'] .'/PHP/Product/DBProduct.php';
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET,POST,PUT,DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$con=new ProductController('getProduct',array(30));

$con->handleRequest();
class ProductController
{

    private $method;
    private $params;

    /**
     * @param $method
     * @param $params
     */
    public function __construct($method, $params)
    {
        $this->method = $method;
        $this->params = $params;
    }
    public function handleRequest(){
        $service=new DBProduct();

        $this->method=$_GET['Method'];
        if(isset($_GET['params']))
        $this->params=explode(',',$_GET['params']);
        //echo $this->params[0];

        switch ($this->method){
            case 'getProduct':{
                //echo 'salut';
                $respons=$this->getProductById($this->params[0]);
                break;
            }
            case 'getProducts':{
                $respons=$this->getProducts();
                break;
            }
            case 'getFiltredProducts':{
                $contor=0;
                $vec=[];
                foreach ($this->params as $par)
                {
                    $vec[$contor]=explode('|',$par);
                    $contor++;
                }
                $partialquery=$this->getFiltredProducts($vec[0],$vec[1],$vec[2],$vec[3],$vec[4],$vec[5],$vec[6]);
                $respons=$this->selectFiltredProducts($partialquery,$vec[7],$vec[8]);
                break;
            }
            case 'getRandomProducts':{
                $respons=$this->getProductsByRandom($this->params[0]);
                break;
            }
            case 'getNumberRows':{
                $contor=0;
                $vec=[];
                foreach ($this->params as $par)
                {
                    $vec[$contor]=explode('|',$par);
                    $contor++;
                }
                $partialquery=$this->getFiltredProducts($vec[0],$vec[1],$vec[2],$vec[3],$vec[4],$vec[5],$vec[6]);
                $respons=$this->countFiltredProducts($partialquery);
                break;
            }
        }
        header($respons['status_code_header']);
        if ($respons['body']) {
            echo $respons['body'];}

        //echo json_encode($respons);
    }

    private function getProductById($params){
        $service=new DBProduct();
        $result=$service->getProductById($this->params[0]);
        $result->setProperties();
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body']=json_encode($result);
        //echo $response['body'];
        return $response;
    }


    private function getProductsByRandom($params){
        $service=new DBProduct();
        $result=$service->getProductsByRandom($this->params[0]);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body']=json_encode($result);
        //echo $response['body'];
        return $response;
    }
    private function getProducts(){
        $service=new DBProduct();
        $result=$service->getProducts();
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        //echo $result->getId();
        $response['body']=json_encode($result);
        //echo $response['body'];
        return $response;
    }
    private function getFiltredProducts($search,$minprice,$maxprice,$store,$type,$rating,$color){
        $globalquery="SELECT id,link,photo,name,price,rating,type,store,color FROM products ";
        $notfirst=0;
        $coloren = array("Black", "Gold", "Silver","Blue","Grey","Green");
        $colorro = array("Negru", "Auriu", "Argintiu","Albastru","Gri","Verde");
        if(!empty($search[0]) && !empty(trim($search[0])))
        {
            $word=strtolower($search[0]);
            $globalquery.="WHERE LOWER(name) LIKE '%$word%' ";
            $notfirst=1;
        }
        if(!empty($minprice[0]))
        {
            if($notfirst==1)
                $globalquery.="AND price >= $minprice[0] ";
            else {
                $globalquery .= "WHERE price >= $minprice[0]  ";
                $notfirst=1;
            }
        }
        if(!empty($maxprice[0]))
        {
            if($notfirst==1)
                $globalquery.="AND price <= $maxprice[0] ";
            else {
                $globalquery .= "WHERE price <= $maxprice[0] ";
                $notfirst=1;
            }
        }
        if(!empty($store[0]))
        {
            if($notfirst==1)
                $globalquery.="AND store IN (";
            else {
                $globalquery .= "WHERE store IN (";
                $notfirst=1;
            }
            for($kk=0;$kk<count($store)-1;$kk++)
            {
                $globalquery.="'$store[$kk]',";
            }
            $globalquery.="'$store[$kk]') ";
        }
        if(!empty($type[0]))
        {
            if($notfirst==1)
                $globalquery.="AND type IN (";
            else {
                $globalquery .= "WHERE type IN (";
                $notfirst=1;
            }
            for($kk=0;$kk<count($type)-1;$kk++)
            {
                $globalquery.="'$type[$kk]',";
            }
            $globalquery.="'$type[$kk]') ";
        }
        if(!empty($rating[0]))
        {
            if($notfirst==1)
                $globalquery.="AND rating IN (";
            else {
                $globalquery .= "WHERE rating IN (";
                $notfirst=1;
            }
            for($kk=0;$kk<count($rating)-1;$kk++)
            {
                $globalquery.="'$rating[$kk]',";
            }
            $globalquery.="'$rating[$kk]') ";
        }
        if(!empty($color[0]))
        {
            if($notfirst==1)
                $globalquery.="AND ( LOWER(color) LIKE ";
            else {
                $globalquery .= "WHERE ( LOWER(color) LIKE ";
                $notfirst=1;
            }
            for($kk=0;$kk<count($color)-1;$kk++)
            {
                for($nn=0;$nn<count($coloren);$nn++)
                    if($color[$kk]==$coloren[$nn])
                    {
                        $rom=strtolower($colorro[$nn]);$enn=strtolower($coloren[$nn]);
                        $globalquery.="'%$rom%' OR  LOWER(color) LIKE '%$enn%' OR LOWER(color) LIKE ";
                        break;
                    }

            }
            for($nn=0;$nn<count($coloren);$nn++)
                if($color[$kk]==$coloren[$nn])
                {
                    $rom=strtolower($colorro[$nn]);$enn=strtolower($coloren[$nn]);
                    $globalquery.="'%$rom%' OR  LOWER(color) LIKE '%$enn%') ";
                    break;
                }
        }
        return $globalquery;

    }
    private function selectFiltredProducts($globalquery,$start_from,$num_per_page)
    {
        $service=new DBProduct();
        $globalquery.=" limit $start_from[0],$num_per_page[0]";
        $result=$service->getFiltredProducts($globalquery);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        //echo $result->getId();
        $response['body']=json_encode($result);
        //echo $response['body'];
        return $response;
    }
    private function countFiltredProducts($globalquery)
    {
        $service=new DBProduct();
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        //echo $result->getId();
        $response['body']=json_encode($service->getFiltredNumber($globalquery));
        //echo $response['body'];
        return $response;
    }


}