<?php
    require_once './PHP/init.php';

    $product=new App();
?>
<html>
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="CSS/index.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome!</title>
</head>
<body>
  <section class="header">
  <div class="container">
    <div class="logo"><img src="UX_UI/complet_logo_I.T-01.png" alt="logo" width="50px" height="50px "></div>
    <div class="SearchBar">
      <form>
          <input type="text" id="SearchBar" name="Search" placeholder="Search">
          <button type="submit" class="Submit"><i class="fa fa-search fa-lg"></i></button>
      </form>
    </div>
    <div class="item">
      <a href="login.php"><button class="btn"><b>Login</b></button></a>
      <a href="sign_up.php"><button class="btn"><b>Sign up</b></button></a>
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
        <li><a href="#">News</a></li>
        <li>
          <label for="btn-2" class="show">Categories</label>
          <a href="#">Categories</a>
          <input type="checkbox" id="btn-2">
          <ul>
            <li><a href="#">Phones</a></li>
            <li><a href="#">Tablets</a></li>
            <li><a href="#">Watches</a></li>
            <li>
              <label for="btn-3" class="show">More</label>
              <a href="#">More <span class="fa fa-plus"></span></a>
              <input type="checkbox" id="btn-3">
              <ul>
                <li><a href="#">Drone</a></li>
                <li><a href="#">PC</a></li>
                <li><a href="#">TV</a></li>
              </ul>
            </li>
          </ul>
        </li>
        <li><a href="#">Contact</a></li>
        <li><a href="#">About Us</a></li>
      </ul>
    </nav>
</section>

<section class="thirdbar">
    <div class="filtru">
    	<h1>Price Range</h1>
        <div class="price-input">
          <div class="field">
            <span>MIN</span>
            <input type="number" class="input-min" min="0" value="100">
          </div>
          <div class="separator">-</div>
          <div class="field">
            <span>MAX</span>
            <input type="number" class="input-max" max="3000" value="1500">
          </div>
        </div>

        <div class="checkboxx">
        	<h1>Color</h1>
         <label class="labelbox">
         	<input type="checkbox" class="option-input checkbox" >
         	Black
         </label>
         <label class="labelbox">
         <input type="checkbox" class="option-input checkbox">
         	White
         </label>
         <label class="labelbox">
         <input type="checkbox" class="option-input checkbox">
         	Gold
         </label>
         <label class="labelbox">
         <input type="checkbox" class="option-input checkbox">
         	Silver
         </label>
        </div>

        <div class="checkboxx">
        	<h1>Brand</h1>
         <label class="labelbox">
         	<input type="checkbox" class="option-input checkbox" >
         	Samsung
         </label>
         <label class="labelbox">
         <input type="checkbox" class="option-input checkbox">
         	LG
         </label>
         <label class="labelbox">
         <input type="checkbox" class="option-input checkbox">
         	Huawei
         </label>
         <label class="labelbox">
         <input type="checkbox" class="option-input checkbox">
         	ASUS
         </label>
        </div>

        <div class="checkboxx">
        	<h1>Autonomy</h1>
         <label class="labelbox">
         	<input type="radio" class="option-input radio" name="example">
         	Option1
         </label>
         <label class="labelbox">
         <input type="radio" class="option-input radio" name="example">
         	Option2
         </label>
         <label class="labelbox">
         <input type="radio" class="option-input radio" name="example">
         	Option3
         </label>
        </div>

        <div class="checkboxx">
        	<h1>Rating</h1>
         <label class="labelbox">
         	<input type="radio" class="option-input radio" name="example">
         	1-2 stars
         </label>
         <label class="labelbox">
         <input type="radio" class="option-input radio" name="example">
         	3-4 stars
         </label>
         <label class="labelbox">
         <input type="radio" class="option-input radio" name="example">
         	5 stars
         </label>
        </div>


    </div>

   <div class="produse">
      <div class="cards">
        <div class="new-arrival">
          <h1>What are you looking for?</h1>
        </div>
        <div class="card">
          <div class="image-section">
            <img src="UX_UI/index/1.jpg" alt="1">
          </div>
          <div class="description">
            <h1>Phone</h1>
            <p><b>Price</b><span>$50</span></p>
          </div>
          <div class="button-group">
           <a href="" class="buy">Buy <i class="fa fa-shopping-cart" aria-hidden="true"></i></a>
           <a href="" class="favorite">Add To Favorite <i class="fa fa-heart fa-lg"></i></a>
         </div>
         <div class="star-icons">
           <a href=""><i class="fa fa-star" aria-hidden="true"></i></a>
           <a href=""><i class="fa fa-star" aria-hidden="true"></i></a>
           <a href=""><i class="fa fa-star" aria-hidden="true"></i></a>
           <a href=""><i class="fa fa-star" aria-hidden="true"></i></a>
           <a href=""><i class="fa fa-star" aria-hidden="true"></i></a>
         </div>
       </div>

       <div class="card">
          <div class="image-section">
            <img src="UX_UI/index/2.jpg" alt="2">
          </div>
          <div class="description">
            <h1>Tablet</h1>
            <p><b>Price</b><span>$100</span></p>
          </div>
          <div class="button-group">
           <a href="" class="buy">Buy <i class="fa fa-shopping-cart" aria-hidden="true"></i></a>
           <a href="" class="favorite">Add To Favorite <i class="fa fa-heart fa-lg"></i></a>
         </div>
         <div class="star-icons">
           <a href=""><i class="fa fa-star" aria-hidden="true"></i></a>
           <a href=""><i class="fa fa-star" aria-hidden="true"></i></a>
           <a href=""><i class="fa fa-star" aria-hidden="true"></i></a>
           <a href=""><i class="fa fa-star" aria-hidden="true"></i></a>
           <a href=""><i class="fa fa-star" aria-hidden="true"></i></a>
         </div>
       </div>

       <div class="card">
          <div class="image-section">
            <img src="UX_UI/index/3.jpg" alt="3">
          </div>
          <div class="description">
            <h1>PC</h1>
            <p><b>Price</b><span>$250</span></p>
          </div>
          <div class="button-group">
           <a href="" class="buy">Buy <i class="fa fa-shopping-cart" aria-hidden="true"></i></a>
           <a href="" class="favorite">Add To Favorite <i class="fa fa-heart fa-lg"></i></a>
         </div>
         <div class="star-icons">
           <a href=""><i class="fa fa-star" aria-hidden="true"></i></a>
           <a href=""><i class="fa fa-star" aria-hidden="true"></i></a>
           <a href=""><i class="fa fa-star" aria-hidden="true"></i></a>
           <a href=""><i class="fa fa-star" aria-hidden="true"></i></a>
           <a href=""><i class="fa fa-star" aria-hidden="true"></i></a>
         </div>
       </div>

       <div class="card">
          <div class="image-section">
            <img src="UX_UI/index/4.jpg" alt="4">
          </div>
          <div class="description">
            <h1>TV</h1>
            <p><b>Price</b><span>$150</span></p>
          </div>
          <div class="button-group">
          <a href="" class="buy">Buy <i class="fa fa-shopping-cart" aria-hidden="true"></i></a>
           <a href="" class="favorite">Add To Favorite <i class="fa fa-heart fa-lg"></i></a>
         </div>
         <div class="star-icons">
           <a href=""><i class="fa fa-star" aria-hidden="true"></i></a>
           <a href=""><i class="fa fa-star" aria-hidden="true"></i></a>
           <a href=""><i class="fa fa-star" aria-hidden="true"></i></a>
           <a href=""><i class="fa fa-star" aria-hidden="true"></i></a>
           <a href=""><i class="fa fa-star" aria-hidden="true"></i></a>
         </div>
       </div>

       <div class="card">
          <div class="image-section">
            <img src="UX_UI/index/5.jpg" alt="5">
          </div>
          <div class="description">
            <h1>SmartWatch</h1>
            <p><b>Price</b><span>$50</span></p>
          </div>
          <div class="button-group">
           <a href="" class="buy">Buy <i class="fa fa-shopping-cart" aria-hidden="true"></i></a>
           <a href="" class="favorite">Add To Favorite <i class="fa fa-heart fa-lg"></i></a>
         </div>
         <div class="star-icons">
           <a href=""><i class="fa fa-star" aria-hidden="true"></i></a>
           <a href=""><i class="fa fa-star" aria-hidden="true"></i></a>
           <a href=""><i class="fa fa-star" aria-hidden="true"></i></a>
           <a href=""><i class="fa fa-star" aria-hidden="true"></i></a>
           <a href=""><i class="fa fa-star" aria-hidden="true"></i></a>
         </div>
       </div>

       <div class="card">
          <div class="image-section">
            <img src="UX_UI/index/6.jpg" alt="6">
          </div>
          <div class="description">
            <h1>Drone</h1>
            <p><b>Price</b><span>$150</span></p>
          </div>
          <div class="button-group">
           <a href="" class="buy">Buy <i class="fa fa-shopping-cart" aria-hidden="true"></i></a>
           <a href="" class="favorite">Add To Favorite <i class="fa fa-heart fa-lg"></i></a>
         </div>
         <div class="star-icons">
           <a href=""><i class="fa fa-star" aria-hidden="true"></i></a>
           <a href=""><i class="fa fa-star" aria-hidden="true"></i></a>
           <a href=""><i class="fa fa-star" aria-hidden="true"></i></a>
           <a href=""><i class="fa fa-star" aria-hidden="true"></i></a>
           <a href=""><i class="fa fa-star" aria-hidden="true"></i></a>
         </div>
       </div>

       <div class="card">
          <div class="image-section">
            <img src="UX_UI/index/7.jpg" alt="7">
          </div>
          <div class="description">
            <h1>Laptop</h1>
            <p><b>Price</b><span>$150</span></p>
          </div>
          <div class="button-group">
           <a href="" class="buy">Buy <i class="fa fa-shopping-cart" aria-hidden="true"></i></a>
           <a href="" class="favorite">Add To Favorite <i class="fa fa-heart fa-lg"></i></a>
         </div>
         <div class="star-icons">
           <a href=""><i class="fa fa-star" aria-hidden="true"></i></a>
           <a href=""><i class="fa fa-star" aria-hidden="true"></i></a>
           <a href=""><i class="fa fa-star" aria-hidden="true"></i></a>
           <a href=""><i class="fa fa-star" aria-hidden="true"></i></a>
           <a href=""><i class="fa fa-star" aria-hidden="true"></i></a>
         </div>
       </div>
     </div>
   </div>

</section>
<section class="links">
  <div class="linkcol">
  	<h3>Customer Support</h3>
    <p>
    <a href="#">Romanian Version</a><br>
    <a href="#">English Version</a><br>
    </p>
  </div>
  <div class="linkcol">
    <h3>Useful Links</h3>
    <p>
    	<a href="https://www.w3schools.com/">W3Schools.com</a><br>
    	<a href="https://app.diagrams.net/">Diagrams.net</a><br>
    	<a href="https://jsfiddle.net/">Jsfiddle.net</a><br>
    </p>
  </div>
  <div class="linkcol">
    <h3>Contact</h3>
    <p>
    <a href=""><i class="fa fa-instagram fa-lg"></i>Instagram</a><br>
    <a href=""><i class="fa fa-github fa-lg"></i>Github</a><br>
    <a href=""><i class="fa fa-facebook fa-lg"></i>Facebook</a><br>
    </p>
  </div>
</section>
  </body>
</html>
