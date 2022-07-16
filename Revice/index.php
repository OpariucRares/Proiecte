<?php
//    require_once './PHP/init.php';
//
//    $product=new App();

include_once "./PHP/User/ServiceUser.php";
/** @var TYPE_NAME $lang */
require_once($_SERVER['DOCUMENT_ROOT']. "/PHP/changeLanguage.php");

if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_COOKIE['language'])) {
    $_COOKIE['language'] = "en";
}


//if (isset($_POST['RomanianVersion'])) {
//    //$_SESSION['language'] = "ro";
//    echo "Romana";
//} else if (isset($_POST['EnglishVersion'])) {
//    //$_SESSION['language'] = "en";
//    echo "Engleza";
//}
//echo $_SESSION['language'];
//    header("Location: index.php");


//echo $_SESSION['language'];

?>

<?php
require_once './PHP/config.php';
require_once 'PHP/Product/DBProduct.php';

function toString($params)
{
    $ans='';
    if(is_array($params)) {
        for ($i = 0; $i < count($params) - 1; $i++) {
            $ans .= $params[$i];
            $ans .= '|';
        }
        $ans .= $params[$i];
    }
    else
        $ans=$params;
    return $ans;
}
function listOfProducts($param): array
{
    $contor=0;
    $ok=json_decode($param,true);
    $produse=[];
    if($ok) {
        foreach ($ok as $key1 => $value1) {
            $product = new Product(null, null, null, null, null, null, null, null, null);
            $product->set(json_decode(json_encode($value1), true));
            $produse[$contor] = $product;
            $contor++;
        }
    }
    return $produse;
}

if(isset($_GET['page']))
{
    $page=$_GET['page'];
}
else
{
    $page=1;
}
$num_per_page=9;
$start_from=($page-1)*9;
$havefilter=0;
$service=new DBProduct();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="CSS/index.css">
    <link rel="preload" as="font" href="https://fonts.googleapis.com/icon?family=Material+Icons&display=swap" >
    <link rel="preload" as="font" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Put your description here.">
    <title>Welcome!</title>
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
            <?php
            if (ServiceUser::checkLoginState()) {
                echo '<a href="profile.php" class="btn" style="text-decoration:none"><b>'.$lang['profile'].' <i class="fa fa-user" aria-hidden="true"></i></b></a>';
            } else {
                echo '<a href="login.php" class="btn" style="text-decoration:none"><b>'.$lang['login'].'</b></a>';
                echo '<a href="sign_up.php" class="btn" style="text-decoration:none"><b>'.$lang['sign_up'].'</b></a>';
            }
            ?>
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

<section class="thirdbar">
    <div class="filtru">
        <h1><?php echo $lang['price2']?></h1>
        <div class="price-input">
            <div class="field">
                <span>MIN</span>
                <label>
                    <input type="number" min="0" max="100000" name="minprice" required value="<?php if(isset($_GET['minprice'])) {echo $_GET['minprice']; $havefilter=1;} else {echo 0;}?>" >
                </label>
            </div>
            <div class="separator">-</div>
            <div class="field">
                <span>MAX</span>
                <label>
                    <input type="number" min="0" max="100000" name="maxprice" required value="<?php if(isset($_GET['maxprice'])) {echo $_GET['maxprice']; $havefilter=1;} else {echo 10000;}?>" >
                </label>
            </div>
        </div>

        <div class="checkboxx">
            <h1><?php echo $lang['store']?></h1>
            <?php
            $store=$service->getFilterOption('store');
            foreach ($store as $storename)
            {
                $checked=[];
                if(isset($_GET['stores']))
                {
                    $havefilter=1;
                    $checked=$_GET['stores'];
                }
                ?>
                <div>
                    <label style="color: #B74803;">
                        b
                        <input type="checkbox" name="stores[]" value="<?= $storename?>"
                            <?php if(in_array($storename,$checked)) {echo  "checked";}?>>
                    </label>
                    <?= $storename?>
                </div>
                <?php
            }

            ?>
        </div>
        <div class="checkboxx">
            <h1><?php echo $lang['type']?></h1>
            <?php
            if(isset($_GET['typescat']))
            {
                $auxvec=[];
                $auxvec=$_GET['typescat'];
                for($counter=0;$counter<count($auxvec);$counter++)
                {
                    if($auxvec[$counter]=='Phone') $auxvec[$counter]='Telefon';
                    if($auxvec[$counter]=='Tablet') $auxvec[$counter]='Tableta';
                    if($auxvec[$counter]=='Speaker') $auxvec[$counter]='Boxa';
                }
                $_GET['types']=$auxvec;
                unset($_GET['typescat']);
            }

            $type=$service->getFilterOption('type');
            foreach ($type as $typename)
            {
                $checked1=[];
                if(isset($_GET['types']))
                {
                    $havefilter=1;
                    $checked1=$_GET['types'];
                }
                ?>
                <div>
                    <label style="color: #B74803;">
                        b
                        <input type="checkbox" name="types[]" value="<?= $typename?>"
                            <?php if(in_array($typename,$checked1)) {echo  "checked";}?>
                        />
                    </label>
                    <?php echo $lang[$typename]?>
                </div>
                <?php
            }
            ?>
        </div>
        <div class="checkboxx">
            <h1><?php echo $lang['rating']?></h1>
            <?php
            $rat=$service->getFilterOption('rating');
            foreach ($rat as $ratname)
            {
                $checked2=[];
                if(isset($_GET['ratings']))
                {
                    $havefilter=1;
                    $checked2=$_GET['ratings'];
                }
                ?>
                <div>
                    <label style="color: #B74803;">
                        b
                        <input type="checkbox" name="ratings[]" value="<?= $ratname?>"
                            <?php if(in_array($ratname,$checked2)) {echo  "checked";}?>
                        />
                    </label>
                    <?= $ratname?>
                    <?php echo $lang['star']?>
                </div>
                <?php
            }
            ?>
        </div>
        <div class="checkboxx">
            <h1><?php echo $lang['color']?></h1>
            <?php
            $coloren = array("Black", "Gold", "Silver","Blue","Grey","Green");
            $colorro = array("Negru", "Auriu", "Argintiu","Albastru","Gri","Verde");
            for($ni=0;$ni<count($coloren);$ni++)
            {
                $checked3=[];
                if(isset($_GET['colors']))
                {
                    $havefilter=1;
                    $checked3=$_GET['colors'];
                }
                ?>
                <div>
                    <label style="color: #B74803;">
                        b
                        <input type="checkbox" name="colors[]" value="<?= $coloren[$ni]?>"
                            <?php if(in_array($coloren[$ni],$checked3)) {echo  "checked";}?>
                        />
                    </label>
                    <?php echo $lang[$colorro[$ni]]?>
                </div>
                <?php
            }
            ?>
        </div>
        <div class="filtersearch">
            <h1>
                <button type="submit" class="btnfil"><?php echo $lang['filter']?></button>
            </h1>
        </div>
    </div>

    <div class="produse">
        <div class="cards">
            <div class="new-arrival">
                <h1><?php echo $lang['title']?></h1>
            </div>
            <?php

            $params=(isset($_GET['search']) ? toString($_GET['search']) : '').','.(isset($_GET['minprice']) ? $_GET['minprice'] : '').','.(isset($_GET['maxprice']) ? $_GET['maxprice'] : '').','.
                (isset($_GET['stores']) ? toString($_GET['stores']) : '').','.(isset($_GET['types']) ? toString($_GET['types']) : '').','.(isset($_GET['ratings']) ? toString($_GET['ratings']) : '').','.(isset($_GET['colors']) ? toString($_GET['colors']) : '').','.($start_from).','.($num_per_page);
            $cur=curl_init('http://localhost/PHP/Controller/ProductController.php?Method=getFiltredProducts&params='.$params);
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
            $listaprod=listOfProducts($data);
            foreach ($listaprod as $prod)
            {
                echo '<div class="card">';
                echo '<div class="image-section">';
                echo '<a href="itemView.php?id='.$prod->getId().'"><img src="' . $prod->getPhoto() . '" alt="Unavailable photo" width="600" height="300"></a>';
                echo '</div>';
                echo '<div class="description">';
                echo '<h1>' . $prod->getName() . '</h1>';
                echo '<p><b>'.$lang['price1'].':</b><span>' . $prod->getPrice() . ' RON</span></p>';
                echo '</div>';
                echo '<div class="button-group">';
                echo '<a href="' . $prod->getLink() . '" class="buy">'.$lang['buy'].'<i class="fa fa-shopping-cart" aria-hidden="true"></i></a>';
                echo '<a href="itemView.php?id='.$prod->getId().'" class="favorite">'.$lang['details'].' <i class="fa fa-info-circle" aria-hidden="true"></i></a>';
                echo '</div>';
                echo '<div class="star-icons">';
                for ($i = 0; $i < $prod->getRating(); $i++) {
                    echo '<span class="fa fa-star checked"></span>';
                }
                for ($i = $prod->getRating(); $i < 5; $i++) {
                    echo '<span class="fa fa-star"></span>';
                }
                echo '</div>';
                echo '</div>';
            }
            ?>

            <?php
            $cur=curl_init('http://localhost/PHP/Controller/ProductController.php?Method=getNumberRows&params='.$params);
            curl_setopt( $cur, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json'
            ]);
            curl_setopt($cur, CURLOPT_SSL_VERIFYPEER, 0);
            if ($cur) {
                curl_setopt($cur, CURLOPT_RETURNTRANSFER, true);
                $data = curl_exec ($cur);
                curl_close ($cur);
            }
            $total_record=json_decode($data);
            $total_page=ceil($total_record/$num_per_page);
            $newuri = str_replace("/index.php/", "", $_SERVER['REQUEST_URI']);

            if (strpos($newuri, '&page') !== false) {
                $newuri=substr($newuri, 0, strpos($newuri, '&page'));
            }
            ?>
</section>
<?php
echo "<section>";
echo "<div class=page_buttons>";
if($page>1)
{
    if($havefilter==0)
    {
        echo "<a href='index.php?page=".($page-1)."' class='navigg'>";
        echo '<i class="fa fa-angle-double-left" aria-hidden="true"></i>';
        echo "</a>";
    }
    else {
        echo "<a href='" . $newuri . "&page=" . ($page - 1) . "' class='navigg'>";
        echo '<i class="fa fa-angle-double-left" aria-hidden="true"></i>';
        echo "</a>";
    }
}
if($page<$total_page)
{
    if($havefilter==0)
    {
        echo "<a href='index.php?page=".($page+1)."' class='navigg'>";
        echo '<i class="fa fa-angle-double-right" aria-hidden="true"></i>';
        echo "</a>";
    }
    else {
        echo "<a href='" . $newuri . "&page=" . ($page + 1) . "' class='navigg'>";
        echo '<i class="fa fa-angle-double-right" aria-hidden="true"></i>';
        echo "</a>";
    }
}
echo "</div>";
echo "</section>";
?>
<section class="links">
    <div class="linkcol">
        <h1><?php echo $lang['suport']?></h1>
        <p>
            <a href="index.php?lang=ro"><?php echo $lang['lang_ro']?></a><br>
            <a href="index.php?lang=en"><?php echo $lang['lang_en']?></a><br>
        </p>
    </div>
    <div class="linkcol">
        <h1><?php echo $lang['links']?></h1>
        <p>
            <a href="https://www.w3schools.com/">W3Schools.com</a><br>
            <a href="https://app.diagrams.net/">Diagrams.net</a><br>
            <a href="https://jsfiddle.net/">Jsfiddle.net</a><br>
        </p>
    </div>
    <div class="linkcol">
        <h1><?php echo $lang['contact']?></h1>
        <p>
            <a href="#"><i class="fa fa-instagram fa-lg"></i>Instagram</a><br>
            <a href="#"><i class="fa fa-github fa-lg"></i>Github</a><br>
            <a href="#"><i class="fa fa-facebook fa-lg"></i>Facebook</a><br>
        </p>
    </div>
</section>
</body>
</html>


