
<?php
/**
 * @var object $pdo
 */
include_once "./PHP/User/ServiceUser.php";
/** @var TYPE_NAME $lang */
require_once($_SERVER['DOCUMENT_ROOT']. "/PHP/changeLanguage.php");

if (!isset($_SESSION)) {
    session_start();
}
$havefilter=0;
if(isset($_GET['url'])){
    $idproduct=$_GET['url'];
}
else
    $idproduct=1;
$type=0;

?>
<?php
require_once 'PHP/Product/Product.php';
if(isset($_GET['id'])){
    $idproduct=$_GET['id'];
}
else
    $idproduct=30;
$cur=curl_init('http://localhost/PHP/Controller/ProductController.php?Method=getProduct&params='.$idproduct);
curl_setopt( $cur, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json'
]);
curl_setopt($cur, CURLOPT_SSL_VERIFYPEER, 0);
if ($cur) {
    curl_setopt($cur, CURLOPT_RETURNTRANSFER, true);
    $data = curl_exec ($cur);
    //echo $data;
    curl_close ($cur);

}
//echo $query;

$product=new Product(null,null,null,null,null,null,null,null,null);
$product->set(json_decode($data,true));

//echo $product->getId();
//echo $product->getStore();
//echo $product->getType();
//echo json_encode($product->getProperties());


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>itemView</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="You see the product.">
    <link rel="preload" as="font">
    <link rel="stylesheet" href="CSS/itemView.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

<section class="header">
    <div class="container">
        <div class="logo"><img src="UX_UI/complet_logo_I.T-01.webp" alt="logo" style="width:50px;height: 50px;"></div>
        <div class="SearchBar">
            <form action="" method="get">
                <label for="SearchBar"></label><input type="text" id="SearchBar" name="search" value="<?php if(isset($_GET['search'])) {echo $_GET['search']; $havefilter=1;} ?>" placeholder="<?php echo $lang['search']?>">
                <button type="submit" class="Submit" aria-label="Right Align"><i class="fa fa-search fa-lg"></i></button>
        </div>
        <div class="item">
            <a href="login.php" class="btn" style="text-decoration:none"><b><?php echo $lang['login']?></b></a>
            <a href="sign_up.php" class="btn" style="text-decoration:none"><b><?php echo $lang['sign_up']?></b></a>
        </div>
    </div>
</section>
<section class="bara_informatii">
    <nav>
        <div class="logo">
            <label for="btn" class="icon">
                <i class="fa fa-bars fa-lg"></i>
            </label>DevShop
        </div>
        <input type="checkbox" id="btn">
        <ul>
            <li><a href="#"><?php echo $lang['news']?></a></li>
            <li>
                <label for="btn-2" class="show">Categories</label>
                <a href="#"><?php echo $lang['categories']?></a>
                <input type="checkbox" id="btn-2">
                <ul>
                    <li><a href="#"><input type="submit" name="typescat[]" value="<?php echo $lang['Laptop']?>"/></a></li>
                    <li><a href="#"><input type="submit" name="typescat[]" value="<?php echo $lang['Telefon']?>"/></a></li>
                    <li><a href="#"><input type="submit" name="typescat[]" value="<?php echo $lang['Tableta']?>"/></a></li>
                    <li>
                        <label for="btn-3" class="show">More</label>
                        <a href="#">More <span class="fa fa-plus"></span></a>
                        <input type="checkbox" id="btn-3">
                        <ul>
                            <li><a href="#"><input type="submit" name="typescat[]" value="<?php echo $lang['Boxa']?>"/></a></li>
                            <li><a href="#"><input type="submit" name="typescat[]" value="<?php echo $lang['SmartWatch']?>"/></a></li>
                            <li><a href="#"><input type="submit" name="typescat[]" value="<?php echo $lang['TV']?>"/></a></li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li><a href="#"><?php echo $lang['contact']?></a></li>
            <li><a href="#"><?php echo $lang['about']?></a></li>
        </ul>
    </nav>
</section>

<section class="Produs">
    <?php
    $sql = $pdo->prepare ("select name,photo,price,type from products where id='$idproduct'");
    if($sql->execute()){
        $row=$sql->fetch();
        $type=$row['type'];
    }
    echo '<div class="imagini">';
       //echo '<div class="imagini-stanga"><img src="UX_UI/itemView/Sageata.webp" alt="Aici se afla sageate spre stanga"></div>';
       echo '<img src="'. $product->getPhoto() .'" alt="Imagine produs">';
       //echo ' <div class="imagini-dreapta"><img src="UX_UI/itemView/Sageata2.webp" alt="Aici se afla sageata spre dreapta"></div>';
    echo'</div>';
    echo'<div class="informatii">';
    echo '<div>'. $product->getName().'</div> <br>';
    if($product->getPrice()!=0) {
        echo '<div>' . $lang['Pret'] . ': ';
        if (isset($_GET['lang'])&&$_GET['lang'] != 'en')
            echo $product->getPrice();
        else
             echo $product->getPrice() / 5;
        echo ' ' . $lang['Valuta'] . '</div>';
    }
    else
        echo '<div>'. $lang['Pret'].': '. $lang['Stoc'].'</div>';
    echo '<table>
            <tr>
                <th>'. $lang['Specificatie'].'</th>
                <th>'. $lang['Descriere'].'</th>
            </tr>';
            foreach($product->getProperties() as $proprietati) {
                    echo '<tr>
                        <td>' . $proprietati->getName() . '</td>
                        <td>' . $proprietati->getValue() . '</td>
                    </tr>';
                }
    echo '</table>';
    /*

    echo '</tabel>';
   */
    echo "</div>";
    ?>
</section>
<section class="Produse">
    <div>
        <?php echo $lang['Recomandari']?>
    </div>
    <?php
        $cur=curl_init('http://localhost/PHP/Controller/ProductController.php?Method=getRandomProducts&params='.$product->getType());
        curl_setopt( $cur, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);
        curl_setopt($cur, CURLOPT_SSL_VERIFYPEER, 0);
        if ($cur) {
            curl_setopt($cur, CURLOPT_RETURNTRANSFER, true);
            $data = curl_exec ($cur);
            //echo $data;
            curl_close ($cur);
        }
        $data=json_decode($data,true);
        foreach ($data as $key=>$value){
            $produs=new Product(null,null,null,null,null,null,null,null,null);
            $produs->set($value);
            echo ' <div class="asemanator">
                    <a href="?_ijt=49tcm5uv75rp75s3itolb23lgu&_ij_reload=RELOAD_ON_SAVE&id='.$produs->getId().'">
                        <img src="' . $produs->getPhoto() .'" alt="Imagine produs racomandat">
                        </a>
                        <div>
                            '. $produs->getName().'
                        </div>
                    </div>';
        }
    ?>
</section>
<section class="links">
    <div class="linkcol">
        <h3><?php echo $lang['suport']?></h3>
        <p>
            <?php echo '<a href="itemView.php?lang=ro&id='.$idproduct.'">';?><?php echo $lang['lang_ro']?></a><br>
            <?php echo '<a href="itemView.php?lang=en&id='.$idproduct.'">';?><?php echo $lang['lang_en']?></a><br>
        </p>
    </div>
    <div class="linkcol">
        <h3><?php echo $lang['links']?></h3>
        <p>
            <a href="https://www.w3schools.com/">W3Schools.com</a><br>
            <a href="https://app.diagrams.net/">Diagrams.net</a><br>
            <a href="https://jsfiddle.net/">Jsfiddle.net</a><br>
        </p>
    </div>
    <div class="linkcol">
        <h3><?php echo $lang['contact']?></h3>
        <p>
            <a href="#"><i class="fa fa-instagram fa-lg"></i>Instagram</a><br>
            <a href="#"><i class="fa fa-github fa-lg"></i>Github</a><br>
            <a href="#"><i class="fa fa-facebook fa-lg"></i>Facebook</a><br>
        </p>
    </div>
</section>
</body>
</html>