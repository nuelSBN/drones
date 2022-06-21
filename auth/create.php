<?php
require("../inc/app.php");
$id = null;
$model = null; 
$state = null; 
$weightLimit = null;
$batteryLevel = null;
$err='';
$user =  new User();

if (isset($_SESSION['user'])){
  $user = unserialize($_SESSION['user']);
}

 if(!$user->isUserAuthenticated()){
      $SESSION['status'] = false;
        header("Location: ../login.php");
        die();
  }
if (!empty($_POST) && (isset($_POST['submit']))){
  $id = $user->getId();
  if(isset($_POST['model'])){
    $model = $_POST['model'];
  }
  if(isset($_POST['state'])){
    $state = $_POST['state'];
  }
  if(isset($_POST['weightLimit'])){
    $weightLimit = $_POST['weightLimit'];
  }
  if(isset($_POST['batteryLevel'])){
    $batteryLevel = $_POST['batteryLevel'];
  }

if(is_null($model)|| is_null($state)||is_null($weightLimit)||is_null($batteryLevel)){
  $err = $err . "\nCheck all fields";
}
else{
  try{
    $result = Drone::addDrone($id,$model,$state,$weightLimit,$batteryLevel);
    $_SESSION['created'] = True;
    $_SESSION['status'] = true;
    header("Location: view.php");
  }catch(Exception $ex){
    $err = $err . "\n" . $ex->getMessage();
  } 
}
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script
      src="https://kit.fontawesome.com/541d44dedf.js"
      crossorigin="anonymous"
    ></script>
    <link rel="stylesheet" href="../styles/create.css" />
    <title>Dashboard</title>
  </head>
  <body>
    <header>
      <nav class="container auth-header">
        <div class="logo">
          <a href="../index.php">
            <i class="fa-brands fa-phoenix-squadron"></i>
            <h1>drones</h1>
          </a>
        </div>
        <div id="menu__box">
          <i class="fa-solid fa-bars-staggered"></i>
        </div>
        <ul class="navbar">
          <li><a class="" href="../index.php">home</a></li>
          <li><a href="../alldrones.php">all drones</a></li>
          <li><a href="logout.php">log out</a></li>
          <li><a class="active" href="dashboard.php">dashboard</a></li>
          
        </ul>
      </nav>
    </header>
    <main class="dashboard__main">
      <section id="dashboard">
        <div class="dashboard_title">
          <h2> Welcome, <?= $user->getfullname()?>, </h2>
          <p>Click here to <a href="logout.php"> Log out</a></p>
        </div>
        <div class="dashboard_sub">
          <p class="dashboard_sub_title">Here you can perform the following </p>
          <ul class="dashboard_sub_list">
            <li><a href="create.php"> Create a Drone </a></li>
            <li><a href="view.php"> View, edit and delete the drones that belongs to you<a> </li>
          </ul>
        </div>
        <h4><?= $err ?></h4>
      </section>
      <section id="add_drone">
          <h1 class="uploadTitle">Add a drone</h1>
          <form class="create_form" method="POST" action='<?php echo  htmlspecialchars($_SERVER["PHP_SELF"]);?>'>
            <div class="upload_container">
              <div class="select__container">
                <select name="model">
                  <option selected disabled>drone model</option>
                  <option value="lightWeight">light weight</option>
                  <option value="middleWeight">middle weight</option>
                  <option value="cruiserWeight">cruiser weight</option>
                  <option value="heavyWeight">heavy weight</option>
                </select>
              </div>
              <div class="select__container">
                <select name='state'>
                  <option selected disabled>state</option>
                  <option value="idle">idle</option>
                  <option value="loading">loading</option>
                  <option value="loaded">loaded</option>
                  <option value="delivering">delivering</option>
                  <option value="delivered">delivered</option>
                  <option value="returning">returning</option>
                </select>
              </div>
            </div>
            <div class="upload_container">
              <div class="select__container">
                <input
                type="number"
                placeholder="Battery Level"
                  max="100"
                  min="0"
                  name="batteryLevel"
                  />
                  <label>(%)</label>
                </div>
                <div class="select__container">
                  <input
                  type="number"
                  placeholder="Weight Limit"
                  max="500"
                  min="0"
                  name="weightLimit"
                  />
                  <label>(KG)</label>
                </div>
              </div>
              <div class="select__btn">
                  <button type="submit" name="submit">register drone</button>
              </div>
          </form>
      </section>
    </main>
    <footer id="auth__footer">
      <div class="logo__container">
        <div class="logo">
          <a href="index.php">
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

    <script src="../js/index.js"></script>
  </body>
</html>
