<?php
require_once './config.php';
ini_set('max_execution_time', 3500);
include('simple_html_dom.php');
$indexg=1;
$curl=curl_init();
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_ENCODING, '');

//EMAG
scrapeFromSite($curl,'https://www.emag.ro/laptopuri/p3/c',$pdo,'Laptop');
scrapeFromSite($curl,'https://www.emag.ro/telefoane-mobile/p3/c',$pdo,'Telefon');
scrapeFromSite($curl,'https://www.emag.ro/tablete/p3/c',$pdo,'Tableta');
scrapeFromSite($curl,'https://www.emag.ro/boxe-portabile/p3/c',$pdo,'Boxa');
scrapeFromSite($curl,'https://www.emag.ro/smartwatch/p3/c',$pdo,'SmartWatch');
scrapeFromSite($curl,'https://www.emag.ro/televizoare/filter/tip-tv-f9181,smart-tv-v-8180383/p3/c',$pdo,'TV');

//ALTEX
scrapeFromAltex($curl,'https://altex.ro/telefoane/cpl/filtru/price/1500-2000/',$pdo,'Telefon');
scrapeFromAltex($curl,'https://altex.ro/telefoane/cpl/filtru/price/4000-5000/',$pdo,'Telefon');
scrapeFromAltex($curl,'https://altex.ro/tablete/cpl/filtru/price/3000-4000/',$pdo,'Tableta');
scrapeFromAltex($curl,'https://altex.ro/tablete/cpl/filtru/price/2000-3000/',$pdo,'Tableta');
scrapeFromAltex($curl,'https://altex.ro/laptopuri/cpl/filtru/price/2000-3000/',$pdo,'Laptop');
scrapeFromAltex($curl,'https://altex.ro/smartwatches/cpl/filtru/price/200-500/',$pdo,'SmartWatch');
scrapeFromAltex($curl,'https://altex.ro/smartwatches/cpl/filtru/price/500-1000/',$pdo,'SmartWatch');
scrapeFromAltex($curl,'https://altex.ro/televizoare/cpl/filtru/price/3000-4000/',$pdo,'TV');
scrapeFromAltex($curl,'https://altex.ro/boxe-portabile-telefoane-tablete/cpl/filtru/price/500-1000/',$pdo,'Boxa');

//ITGALAXY

scrapeFromItGalaxy($curl,'https://www.itgalaxy.ro/telefoane-mobile/',$pdo,'Telefon');
scrapeFromItGalaxy($curl,'https://www.itgalaxy.ro/telefoane-mobile/pagina2/',$pdo,'Telefon');
scrapeFromItGalaxy($curl,'https://www.itgalaxy.ro/telefoane-mobile/pagina3/',$pdo,'Telefon');
scrapeFromItGalaxy($curl,'https://www.itgalaxy.ro/laptopuri/',$pdo,'Laptop');
scrapeFromItGalaxy($curl,'https://www.itgalaxy.ro/laptopuri/pagina2/',$pdo,'Laptop');
scrapeFromItGalaxy($curl,'https://www.itgalaxy.ro/laptopuri/pagina3/',$pdo,'Laptop');
scrapeFromItGalaxy($curl,'https://www.itgalaxy.ro/tablete/',$pdo,'Tableta');
scrapeFromItGalaxy($curl,'https://www.itgalaxy.ro/tablete/pagina2/',$pdo,'Tableta');
scrapeFromItGalaxy($curl,'https://www.itgalaxy.ro/tablete/pagina3/',$pdo,'Tableta');
scrapeFromItGalaxy($curl,'https://www.itgalaxy.ro/boxe-portabile/',$pdo,'Boxa');
scrapeFromItGalaxy($curl,'https://www.itgalaxy.ro/boxe-portabile/pagina2/',$pdo,'Boxa');
scrapeFromItGalaxy($curl,'https://www.itgalaxy.ro/boxe-portabile/pagina3/',$pdo,'Boxa');
scrapeFromItGalaxy($curl,'https://www.itgalaxy.ro/televizoare/',$pdo,'TV');
scrapeFromItGalaxy($curl,'https://www.itgalaxy.ro/televizoare/pagina2/',$pdo,'TV');
scrapeFromItGalaxy($curl,'https://www.itgalaxy.ro/televizoare/pagina3/',$pdo,'TV');
scrapeFromItGalaxy($curl,'https://www.itgalaxy.ro/smartwatch/',$pdo,'SmartWatch');
scrapeFromItGalaxy($curl,'https://www.itgalaxy.ro/smartwatch/pagina2/',$pdo,'SmartWatch');
scrapeFromItGalaxy($curl,'https://www.itgalaxy.ro/smartwatch/pagina3/',$pdo,'SmartWatch');

curl_close($curl);


function scrapeFromSite($curl,$site,$pdo,$type)
{
    curl_setopt($curl, CURLOPT_URL, $site);
    $result = curl_exec($curl);
    $html = new simple_html_dom();

    $html->load($result);
    $titles = array();
    $images=array();
    $i = 0;
    foreach ($html->find('div[class=card-v2-info] a') as $post) {

        if (!in_array($post->href, $titles, TRUE)) {
            $titles[$i] = $post->href;
            $img = $post->getElementsByTagName('img');
            if($img!=null) {
                $img_src = $img[0]->getAttribute('src');
                $images[$i] = $img_src;
            }
            else $images[$i] = '';
            $i++;
        }
    }
    $lgvec=count($titles);
    for ($it=0;$it<$lgvec;$it++) {
        curl_setopt($curl, CURLOPT_URL, $titles[$it]);
        $pagina = curl_exec($curl);
        $html->load($pagina);
        foreach ($html->find('h1[class=page-title]') as $text_titlu) {
            $myname=$text_titlu->plaintext;

        }
        $mypret = 0;
        foreach ($html->find('div[class=pricing-block  has-installments] p[class=product-new-price]') as $pret) {
            $mypret = $pret->plaintext;
        }
        foreach ($html->find('div[class=pricing-block  has-installments] p[class=product-new-price has-deal]') as $pret) {
            $mypret = $pret->plaintext;
        }
        foreach ($html->find('div[class=pricing-block] p[class=product-new-price]') as $pret) {
            $mypret = $pret->plaintext;
        }
        $rez='';
        for($k=0;$k<strlen($mypret)&&$mypret[$k]!=' ';$k++)
        {if($mypret[$k]=='&')
                $k+=4;
            else
                $rez .= $mypret[$k];
        }
        $mypret=substr($rez,0,-2);
        $myrating = '0';
        foreach ($html->find('span[class=star-rating-text gtm_rp101318 semibold text-gray-dark EOSMKP-90955-a]') as $rating) {
            $myrating = $rating->plaintext;
        }
        $myrating=$myrating[0];
        $lap1=$lap2=$lap3=$lap4=$lap5=$mycolor=$tel1=$tel2=$tel3=$tel4=$tel5=$tab1=$tab2=$tab3=$tab4=$tab5=$tv1=$tv2=$tv3=$tv4=$wat1=$wat2=$wat3=$wat4=$box1=$box2=$box3='';
        foreach ($html->find('table[class=table table-striped specifications-table]') as $singleTable) {
            $rows = $singleTable->getElementsByTagName('tr'); //pull the table rows from the second table (notice we select the second by item(1).)
            foreach ($rows as $row) {
                $columns = $row->getElementsByTagName('td');
                if(strpos($columns[0],'Culoare')!==false) $mycolor=$columns[1]->plaintext;
                if(strpos($columns[0],'Producator procesor')!==false) $lap1=$columns[1]->plaintext;
                if(strpos($columns[0],'Model procesor')!==false)  $lap2=$columns[1]->plaintext;
                if(strpos($columns[0],'Diagonala display')!==false) $lap3=$columns[1]->plaintext;
                if(strpos($columns[0],'Capacitate memorie')!==false) $lap4=$columns[1]->plaintext;
                if(strpos($columns[0],'Sistem de operare')!==false) $lap5=$columns[1]->plaintext;
                if(strpos($columns[0],'Dimensiune ecran')!==false) $tel1=$columns[1]->plaintext;
                if(strpos($columns[0],'Sistem de operare')!==false) $tel2=$columns[1]->plaintext;
                if(strpos($columns[0],'Memorie interna')!==false) $tel3=$columns[1]->plaintext;
                if(strpos($columns[0],'Rezolutie camera principala')!==false) $tel4=$columns[1]->plaintext;
                if(strpos($columns[0],'Capacitate baterie')!==false) $tel5=$columns[1]->plaintext;
                if(strpos($columns[0],'Diagonala display')!==false) $tab1=$columns[1]->plaintext;
                if(strpos($columns[0],'Sistem de operare')!==false) $tab2=$columns[1]->plaintext;
                if(strpos($columns[0],'Capacitate stocare')!==false) $tab3=$columns[1]->plaintext;
                if(strpos($columns[0],'Rezolutie camera principala')!==false) $tab4=$columns[1]->plaintext;
                if(strpos($columns[0],'Capacitate acumulator')!==false) $tab5=$columns[1]->plaintext;
                if(strpos($columns[0],'Tip TV')!==false) $tv1=$columns[1]->plaintext;
                if(strpos($columns[0],'Diagonala display')!==false) $tv2=$columns[1]->plaintext;
                if(strpos($columns[0],'Tehnologie display')!==false) $tv3=$columns[1]->plaintext;
                if(strpos($columns[0],'Claritate imagine')!==false) $tv4=$columns[1]->plaintext;
                if(strpos($columns[0],'Dimensiune display')!==false) $wat1=$columns[1]->plaintext;
                if(strpos($columns[0],'Tip display')!==false) $wat2=$columns[1]->plaintext;
                if(strpos($columns[0],'Capacitate stocare')!==false) $wat3=$columns[1]->plaintext;
                if(strpos($columns[0],'Capacitate baterie')!==false) $wat4=$columns[1]->plaintext;
                if(strpos($columns[0],'Conectivitate')!==false) $box1=$columns[1]->plaintext;
                if(strpos($columns[0],'Autonomie acumulator')!==false) $box2=$columns[1]->plaintext;
                if(strpos($columns[0],'Putere')!==false) $box3=$columns[1]->plaintext;
            }
        }
        $insert = $pdo->prepare('Insert into products(name,price,rating,store,color,link,photo,type) values(?,?,?,?,?,?,?,?)');
        $insert->execute([$myname,$mypret,$myrating,'Emag',$mycolor,$titles[$it],$images[$it],$type]);
        insertProp($type,$pdo,$lap1,$lap2,$lap3,$lap4,$lap5,$tel1,$tel2,$tel3,$tel4,$tel5,$tab1,$tab2,$tab3,$tab4,$tab5,$wat1,$wat2,$wat3,$wat4,$tv1,$tv2,$tv3,$tv4,$box1,$box2,$box3);
    }
}



function scrapeFromAltex($curl,$site,$pdo,$type)
{
    curl_setopt($curl, CURLOPT_URL, $site);
    $result = curl_exec($curl);
    $html = new simple_html_dom();

    $html->load($result);
    $titles = array();
    $images=array();
    $i = 0;
    foreach ($html->find('ul[class=Products flex flex-wrap relative -mx-1 sm:-mx-2] li a') as $post) {
        $unde='https://altex.ro';
        $unde .= $post->href;

        if(!strpos($unde,'#reviews')&&!strpos($unde,'#resigilate')) {
            if (!in_array($unde, $titles, TRUE)) {

                $img = $post->getElementsByTagName('div[class="Product-photoWrapper"] img');
                $img_src=$img[0]->getAttribute('src');
                $images[$i]=$img_src;
                $titles[$i] = $unde;
                $i++;
            }
        }
    }
    $lgvec=count($titles);
    for ($it=0;$it<$lgvec;$it++) {
        curl_setopt($curl, CURLOPT_URL, $titles[$it]);
        $pagina = curl_exec($curl);
        $html->load($pagina);

        foreach ($html->find('h1[class=mb-2 font-normal text-2xl md:text-36px leading-32 md:leading-46] div') as $text_titlu) {
            $myname=$text_titlu->plaintext;
        }
        $mypret = 0;
        foreach ($html->find('span[class=Price-int leading-none]') as $pret) {
            $mypret = $pret->plaintext;
            break;
        }
        $rez='';
        $token = strtok((string)$mypret, ".");
        while ($token !== false)
        {
            $rez.=$token;
            $token = strtok(" ");
        }
        $mypret=$rez;
        $myrating = '0';
        foreach ($html->find('span[class=align-middle inline-block text-2xl font-medium mx-10px lg:mr-7px]') as $rating) {
            $myrating = $rating->plaintext;
        }
        $token = strtok((string)$myrating, ".");
        $myrating=$token;
        $lap1=$lap2=$lap3=$lap4=$lap5=$mycolor=$tel1=$tel2=$tel3=$tel4=$tel5=$tab1=$tab2=$tab3=$tab4=$tab5=$tv1=$tv2=$tv3=$tv4=$wat1=$wat2=$wat3=$wat4=$box1=$box2=$box3='';
        foreach ($html->find('table[class=Specs-table w-full table-fixed]') as $singleTable) {
            $rows = $singleTable->getElementsByTagName('tr'); //pull the table rows from the second table (notice we select the second by item(1).)
            foreach ($rows as $row) {
                $prop = $row->getElementsByTagName('th');
                $columns = $row->getElementsByTagName('td');
                if(strpos($prop[0],'Culoare')!==false) $mycolor=$columns[0]->plaintext;
                if(strpos($prop[0],'Producator procesor')!==false) $lap1=$columns[0]->plaintext;
                if(strpos($prop[0],'Model procesor')!==false)  $lap2=$columns[0]->plaintext;
                if(strpos($prop[0],'Dimensiune ecran (inch)')!==false) $lap3=$columns[0]->plaintext;
                if(strpos($prop[0],'Capacitate RAM (GB)')!==false) $lap4=$columns[0]->plaintext;
                if(strpos($prop[0],'Sistem operare')!==false) $lap5=$columns[0]->plaintext;
                if(strpos($prop[0],'Dimensiune ecran (inch)')!==false) $tel1=$columns[0]->plaintext;
                if(strpos($prop[0],'Sistem de operare')!==false) $tel2=$columns[0]->plaintext;
                if(strpos($prop[0],'Capacitate stocare')!==false) $tel3=$columns[0]->plaintext;
                if(strpos($prop[0],'Rezolutie (Mp)')!==false) $tel4=$columns[0]->plaintext;
                if(strpos($prop[0],'Capacitate baterie (mAh)')!==false) $tel5=$columns[0]->plaintext;
                if(strpos($prop[0],'Dimensiune ecran (inch)')!==false) $tab1=$columns[0]->plaintext;
                if(strpos($prop[0],'Sistem de operare')!==false) $tab2=$columns[0]->plaintext;
                if(strpos($prop[0],'Capacitate stocare')!==false) $tab3=$columns[0]->plaintext;
                if(strpos($prop[0],'Camera principala')!==false) $tab4=$columns[0]->plaintext;
                if(strpos($prop[0],'Baterie')!==false) $tab5=$columns[0]->plaintext;
                if(strpos($prop[0],'Tip TV')!==false) $tv1=$columns[0]->plaintext;
                if(strpos($prop[0],'Diagonala (cm)')!==false) $tv2=$columns[0]->plaintext;
                if(strpos($prop[0],'Tip Display')!==false) $tv3=$columns[0]->plaintext;
                if(strpos($prop[0],'Rezolutie')!==false) $tv4=$columns[0]->plaintext;
                if(strpos($prop[0],'Dimensiune ecran')!==false) $wat1=$columns[0]->plaintext;
                if(strpos($prop[0],'Tip ecran')!==false) $wat2=$columns[0]->plaintext;
                if(strpos($prop[0],'Memorie interna')!==false) $wat3=$columns[0]->plaintext;
                if(strpos($prop[0],'Capacitate baterie')!==false) $wat4=$columns[0]->plaintext;
                if(strpos($prop[0],'Tip conexiune')!==false) $box1=$columns[0]->plaintext;
                if(strpos($prop[0],'Autonomie')!==false) $box2=$columns[0]->plaintext;
                if(strpos($prop[0],'Putere (W)')!==false) $box3=$columns[0]->plaintext;

            }
        }
        $insert = $pdo->prepare('Insert into products(name,price,rating,store,color,link,photo,type) values(?,?,?,?,?,?,?,?)');
        $insert->execute([$myname,$mypret,$myrating,'Altex',$mycolor,$titles[$it],$images[$it],$type]);
        insertProp($type,$pdo,$lap1,$lap2,$lap3,$lap4,$lap5,$tel1,$tel2,$tel3,$tel4,$tel5,$tab1,$tab2,$tab3,$tab4,$tab5,$wat1,$wat2,$wat3,$wat4,$tv1,$tv2,$tv3,$tv4,$box1,$box2,$box3);
    }
}
function scrapeFromItGalaxy($curl,$site,$pdo,$type)
{
    curl_setopt($curl, CURLOPT_URL, $site);
    $result = curl_exec($curl);
    $html = new simple_html_dom();

    $html->load($result);
    $titles = array();
    $images = array();
    $i = 0;
    $j = 0;
    foreach ($html->find('div[class=margin-bottom-xs grid-full image text-center col-xs-4 col-sm-3 col-md-3] a img') as $img) {
        $img_src=$img->getAttribute('src');
        $images[$j]=$img_src;
        $j++;
    }
    foreach ($html->find('div[class=grid-full col-xs-8 col-sm-8 col-md-6] h5 a') as $post) {
        if (!in_array($post->href, $titles, TRUE)) {
            $titles[$i] = $post->href;
            $i++;
        }
    }
    $lgvec=count($titles);
    for ($it=0;$it<$lgvec;$it++) {
        curl_setopt($curl, CURLOPT_URL, $titles[$it]);
        $pagina = curl_exec($curl);
        $html->load($pagina);

        foreach ($html->find('div[class=name col-xs-12] div[class=pull-left] h1') as $text_titlu) {
            $myname=$text_titlu->plaintext;
        }
        $myname=trim($myname);

        $mypret = '0';
        foreach ($html->find('div[class=price-box] h3') as $pret) {
            $mypret = $pret->plaintext;
            break;
        }
        $mypret=trim($mypret);
        $token = strtok((string)$mypret, ",");
        $mypret=$token;
        $rez='';
        $token = strtok((string)$mypret, ".");
        while ($token !== false)
        {
            $rez.=$token;
            $token = strtok(" ");
        }
        $mypret=$rez;

        $myrating = '0';
        foreach ($html->find('div[class=rating pull-right]') as $rating) {
            $myrating = $rating->plaintext;
        }
        $myrating=trim($myrating);
        $myrating=$myrating[0];

        $prop=$html->find('div[class=char-name col-xs-12 col-sm-4]');
        $val=$html->find('div[class=char-value col-xs-12 col-sm-7]');
        $lap1=$lap2=$lap3=$lap4=$lap5=$mycolor=$tel1=$tel2=$tel3=$tel4=$tel5=$tab1=$tab2=$tab3=$tab4=$tab5=$tv1=$tv2=$tv3=$tv4=$wat1=$wat2=$wat3=$wat4=$box1=$box2=$box3='';
        for ($i = 0; $i < count($prop); $i++) {
            if(strpos(trim($prop[$i]->plaintext),'Culoare')!==false) $mycolor=trim($val[$i]->plaintext);
            if(strpos(trim($prop[$i]->plaintext),'Producator procesor')!==false) $lap1=trim($val[$i]->plaintext);
            if(strpos(trim($prop[$i]->plaintext),'Model procesor')!==false)  $lap2=trim($val[$i]->plaintext);
            if(strpos(trim($prop[$i]->plaintext),'Diagonala display')!==false) $lap3=trim($val[$i]->plaintext);
            if(strpos(trim($prop[$i]->plaintext),'Capacitate memorie')!==false) $lap4=trim($val[$i]->plaintext);
            if(strpos(trim($prop[$i]->plaintext),'Sistem de operare')!==false) $lap5=trim($val[$i]->plaintext);
            if(strpos(trim($prop[$i]->plaintext),'Diagonala')!==false) $tel1=trim($val[$i]->plaintext);
            if(strpos(trim($prop[$i]->plaintext),'Sistem operare')!==false) $tel2=trim($val[$i]->plaintext);
            if(strpos(trim($prop[$i]->plaintext),'Memorie interna')!==false) $tel3=trim($val[$i]->plaintext);
            if(strpos(trim($prop[$i]->plaintext),'Camera principala')!==false) $tel4=trim($val[$i]->plaintext);
            if(strpos(trim($prop[$i]->plaintext),'Capacitate')!==false) $tel5=trim($val[$i]->plaintext);
            if(strpos(trim($prop[$i]->plaintext),'Diagonala')!==false) $tab1=trim($val[$i]->plaintext);
            if(strpos(trim($prop[$i]->plaintext),'Sistem operare')!==false) $tab2=trim($val[$i]->plaintext);
            if(strpos(trim($prop[$i]->plaintext),'Memorie flash integrata')!==false) $tab3=trim($val[$i]->plaintext);
            if(strpos(trim($prop[$i]->plaintext),'Camera foto')!==false) $tab4=trim($val[$i]->plaintext);
            if(strpos(trim($prop[$i]->plaintext),'Baterie')!==false) $tab5=trim($val[$i]->plaintext);
            $tv1='Smart TV';
            if(strpos(trim($prop[$i]->plaintext),'Diagonala cm')!==false) $tv2=trim($val[$i]->plaintext);
            if(strpos(trim($prop[$i]->plaintext),'Tehnologie')!==false) $tv3=trim($val[$i]->plaintext);
            if(strpos(trim($prop[$i]->plaintext),'Format')!==false) $tv4=trim($val[$i]->plaintext);
            if(strpos(trim($prop[$i]->plaintext),'Diagonala ecran')!==false) $wat1=trim($val[$i]->plaintext);
            if(strpos(trim($prop[$i]->plaintext),'Baterie')!==false) $wat4=trim($val[$i]->plaintext);
            if(strpos(trim($prop[$i]->plaintext),'Conectare')!==false) $box1=trim($val[$i]->plaintext);
            if(strpos(trim($prop[$i]->plaintext),'Autonomie')!==false) $box2=trim($val[$i]->plaintext);
            if(strpos(trim($prop[$i]->plaintext),'Putere totala')!==false) $box3=trim($val[$i]->plaintext);
        }
        $insert = $pdo->prepare('Insert into products(name,price,rating,store,color,link,photo,type) values(?,?,?,?,?,?,?,?)');
        $insert->execute([$myname,$mypret,$myrating,'ITGalaxy',$mycolor,$titles[$it],$images[$it],$type]);
        insertProp($type,$pdo,$lap1,$lap2,$lap3,$lap4,$lap5,$tel1,$tel2,$tel3,$tel4,$tel5,$tab1,$tab2,$tab3,$tab4,$tab5,$wat1,$wat2,$wat3,$wat4,$tv1,$tv2,$tv3,$tv4,$box1,$box2,$box3);
    }
}
function insertProp($type,$pdo,$lap1,$lap2,$lap3,$lap4,$lap5,$tel1,$tel2,$tel3,$tel4,$tel5,$tab1,$tab2,$tab3,$tab4,$tab5,$wat1,$wat2,$wat3,$wat4,$tv1,$tv2,$tv3,$tv4,$box1,$box2,$box3)
{
    if($type=='Laptop')
    {
        $insert = $pdo->prepare('Insert into properties(id_product,name,value) values(?,?,?)');
        $insert->execute([$GLOBALS['indexg'],'Producator procesor',$lap1]);
        $insert->execute([$GLOBALS['indexg'],'Model procesor',$lap2]);
        $insert->execute([$GLOBALS['indexg'],'Dimensiune ecran',$lap3]);
        $insert->execute([$GLOBALS['indexg'],'Capacitate memorie',$lap4]);
        $insert->execute([$GLOBALS['indexg'],'Sistem de operare',$lap5]);
    }
    if($type=='Telefon')
    {
        $insert = $pdo->prepare('Insert into properties(id_product,name,value) values(?,?,?)');
        $insert->execute([$GLOBALS['indexg'],'Dimensiune ecran',$tel1]);
        $insert->execute([$GLOBALS['indexg'],'Sistem de operare',$tel2]);
        $insert->execute([$GLOBALS['indexg'],'Capacitate memorie',$tel3]);
        $insert->execute([$GLOBALS['indexg'],'Rezolutie camera principala',$tel4]);
        $insert->execute([$GLOBALS['indexg'],'Capacitate baterie',$tel5]);
    }
    if($type=='Tableta')
    {
        $insert = $pdo->prepare('Insert into properties(id_product,name,value) values(?,?,?)');
        $insert->execute([$GLOBALS['indexg'],'Dimensiune ecran',$tab1]);
        $insert->execute([$GLOBALS['indexg'],'Sistem de operare',$tab2]);
        $insert->execute([$GLOBALS['indexg'],'Capacitate memorie',$tab3]);
        $insert->execute([$GLOBALS['indexg'],'Rezolutie camera principala',$tab4]);
        $insert->execute([$GLOBALS['indexg'],'Capacitate baterie',$tab5]);
    }
    if($type=='SmartWatch')
    {
        $insert = $pdo->prepare('Insert into properties(id_product,name,value) values(?,?,?)');
        $insert->execute([$GLOBALS['indexg'],'Dimensiune ecran',$wat1]);
        $insert->execute([$GLOBALS['indexg'],'Tip ecran',$wat2]);
        $insert->execute([$GLOBALS['indexg'],'Capacitate memorie',$wat3]);
        $insert->execute([$GLOBALS['indexg'],'Capacitate baterie',$wat4]);
    }
    if($type=='TV')
    {
        $insert = $pdo->prepare('Insert into properties(id_product,name,value) values(?,?,?)');
        $insert->execute([$GLOBALS['indexg'],'Tip TV',$tv1]);
        $insert->execute([$GLOBALS['indexg'],'Dimensiune ecran',$tv2]);
        $insert->execute([$GLOBALS['indexg'],'Tehnologie display',$tv3]);
        $insert->execute([$GLOBALS['indexg'],'Rezolutie',$tv4]);
    }
    if($type=='Boxa')
    {
        $insert = $pdo->prepare('Insert into properties(id_product,name,value) values(?,?,?)');
        $insert->execute([$GLOBALS['indexg'],'Conectivitate',$box1]);
        $insert->execute([$GLOBALS['indexg'],'Autonomie',$box2]);
        $insert->execute([$GLOBALS['indexg'],'Putere',$box3]);
    }
    $GLOBALS['indexg']+=1;
}
?>