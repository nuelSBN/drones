<?php
require("./inc/app.php");
$user =  new User();
if (isset($_SESSION['user'])){
  $user = unserialize($_SESSION['user']);
}
$Drones = Drone::getAllDrones();
$Drones = array_slice($Drones,0,20)
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./styles/index.css" />
    <script
      src="https://kit.fontawesome.com/541d44dedf.js"
      crossorigin="anonymous"
    ></script>
    <title>Drones</title>
  </head>
  <body>
    <section class="top__section">
      <header>
        <nav class="container">
          <div class="logo">
            <a href="index.php">
              <i class="fa-brands fa-phoenix-squadron"></i>
              <h1>drones</h1>
            </a>
          </div>
          <div id="menu__box">
            <i class="fa-solid fa-bars-staggered"></i>
          </div>
          <ul class="navbar">
            <li><a class="active" href="index.php">home</a></li>
            <li><a href="alldrones.php">all drones</a></li>
            <?php if($user->isUserAuthenticated()){  ?>
            <li><a href="./auth/logout.php">log out</a></li>
          <li><a class="active" href="./auth/dashboard.php">dashboard</a></li>
            <?php } else {?>
          <li><a href="login.php">sign in</a></li>
          <li><a href="signup.php">sign up</a></li>
            
            <?php } ?>
          </ul>
        </nav>
      </header>
      <div class="hero">
        <div class="hero__text">
          <h1>
            "Drones overall will be more impactful than I think people recognize
            in positive ways to help society."
          </h1>
          <p>Bill Gates</p>
        </div>
      </div>
    </section>
    <main>
       <h1>Drones By Model</h1>
       <section id="featured" class="grid_4">
        <div
          class="featured__card"
           onclick="location.href='alldrones.php?info=model&q=lightweight'"
        >
          <div class="featured__card-text">
            <h3>light weight drones</h3>
            <p>Cute little toy drone for kids</p>
          </div>
          <div class="linear"></div>
          <img
            src="https://www.firstquadcopter.com/wp-content/uploads/2022/04/CSJ_S176_Mini_kids_drone.jpg"
            alt=""
          />
        </div>
        <div
          class="featured__card"
          onclick="location.href='alldrones.php?info=model&q=middleweight'"
        >
          <div class="featured__card-text">
            <h3>middle weight drones</h3>
            <p>4DRC V20 ELF affordable toy drone</p>
          </div>
          <div class="linear"></div>
          <img
            src="https://www.firstquadcopter.com/wp-content/uploads/2022/02/4DRC_V20_ELF_drone.jpg"
            alt=""
          />
        </div>
        <div
          class="featured__card"
          onclick="location.href='alldrones.php?info=model&q=cruiserweight'"
        >
          <div class="featured__card-text">
            <h3>Cruiser weight drones</h3>
            <p>The Best Drone Under $200 for Most Beginners</p>
          </div>
          <div class="linear"></div>
          <img
            src="https://www.firstquadcopter.com/wp-content/uploads/2022/04/k88pro_drone.jpg"
            alt=""
          />
        </div>
        <div
          class="featured__card"
          onclick="location.href='alldrones.php?info=model&q=heavyweight'"
        >
          <div class="featured__card-text">
            <h3>heavy weight drones</h3>
            <p>Fly in the rain, land on water</p>
          </div>
          <div class="linear"></div>
          <img
            src="https://www.firstquadcopter.com/wp-content/uploads/2022/04/CSJ_S176_Mini_kids_drone.jpg"
            alt=""
          />
        </div>
      </section>
     
      <h1 class="states_section">Drones By States</h1>
      
       <section id="featured" class="states_section-box">
       
        <div
          class="featured__card"
          onclick="location.href='alldrones.php?info=state&q=loading'"
          
        >
          <div class="featured__card-text">
            <h3>Drones in a Loading State</h3>
            <p>Cute little toy drone for kids</p>
          </div>
          <div class="linear"></div>
          <img
            src="https://images.pexels.com/photos/442587/pexels-photo-442587.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1"
            alt=""
          />
        </div>
        <div
          class="featured__card"
           onclick="location.href='alldrones.php?info=state&q=delivered'"
        >
          <div class="featured__card-text">
          <h3>Drones in a Delivered State</h3>
            <p>4DRC V20 ELF affordable toy drone</p>
          </div>
          <div class="linear"></div>
          <img
            src="https://images.pexels.com/photos/997130/pexels-photo-997130.jpeg?auto=compress&cs=tinysrgb&w=600"
            alt=""
          />
        </div>
        <div
          class="featured__card"
           onclick="location.href='alldrones.php?info=state&q=delivering'"
        >
          <div class="featured__card-text">
          <h3>Drones in a Delivering State</h3>
            <p>The Best Drone Under $200 for Most Beginners</p>
          </div>
          <div class="linear"></div>
          <img
            src="https://images.pexels.com/photos/3945684/pexels-photo-3945684.jpeg?auto=compress&cs=tinysrgb&w=600"
            alt=""
          />
        </div>
        <div
          class="featured__card"
           onclick="location.href='alldrones.php?info=state&q=idle'"
        >
          <div class="featured__card-text">
          <h3>Drones in the idle State</h3>
            <p>Fly in the rain, land on water</p>
          </div>
          <div class="linear"></div>
          <img
            src="https://images.pexels.com/photos/1087182/pexels-photo-1087182.jpeg?auto=compress&cs=tinysrgb&w=600"
            alt=""
          />
        </div>
        <div
          class="featured__card"
           onclick="location.href='alldrones.php?info=state&q=loaded'"
        >
          <div class="featured__card-text">
          <h3>Drones in the Loaded State</h3>
            <p>Fly in the rain, land on water</p>
          </div>
          <div class="linear"></div>
          <img
            src="https://images.pexels.com/photos/274939/pexels-photo-274939.jpeg?auto=compress&cs=tinysrgb&w=600"
            alt=""
          />
        </div>
        <div
          class="featured__card"
           onclick="location.href='alldrones.php?info=state&q=returning'"
        >
          <div class="featured__card-text">
          <h3>Drones in the Returning State</h3>
            <p>Fly in the rain, land on water</p>
          </div>
          <div class="linear"></div>
          <img
            src="https://images.pexels.com/photos/1336185/pexels-photo-1336185.jpeg?auto=compress&cs=tinysrgb&w=600"
            alt=""
          />
        </div>
      </section>
      <h1>Latest Drones</h1>
      <section id="drones">
        <div class="drones__grid">
          <!-- all the drones will be gotten from the database -->
          <?php foreach($Drones as $drone): ?>
      
      <div
        class="drones__grid-card"       
      >
        <div class="drones__grid-card_img">
            <img
            src=<?= "https://robohash.org/".$drone['serialNumber']; ?>
            onclick="location.href='product.php?serial=<?= $drone['serialNumber'] ?>'"
            alt=""
            />
        </div>
            <div class="drones__grid-card-text">
                <div class="drones__grid-card-textCard">
                    <h3>model - <?= $drone['model'] ?></h3>
                    <p>current state: <?= $drone['state'] ?></p>
                </div>
                <div class="drones__grid-card-box">
                    <button
                    onclick="location.href='product.php?serial=<?= $drone['serialNumber'] ?>'">show more</button>
                </div>
            </div>
      </div>

            <?php endforeach; ?>
        </div>
        <button class="drones__btn"  onclick="location.href='alldrones.php'">
          See All Drones
        </button>
      </section>
    </main>
    <footer>
      <div class="logo__container">
        <div class="logo">
          <a href="./index.html">
            <i class="fa-brands fa-phoenix-squadron"></i>
            <h1>drones</h1>
          </a>
        </div>
      </div>
      <div class="contact">
        <ul class="social__icons">
          <li>
            <a href="#"><i class="fa-brands fa-facebook"></i></a>
          </li>
          <li>
            <a href="#"><i class="fa-brands fa-twitter"></i></a>
          </li>
          <li>
            <a href="#"><i class="fa-brands fa-instagram"></i></a>
          </li>
        </ul>
      </div>
    </footer>

    <script src="./js/index.js"></script>
  </body>
</html>
