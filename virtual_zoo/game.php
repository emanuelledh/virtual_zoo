<?php
require("models/Food.php");
require("models/Apple.php");
require("models/Icecream.php");
require("models/Sushi.php");
require("models/VirtualZoo.php");
require("models/VirtualPet.php");

session_start();

if(!isset($_SESSION['zoo'])){
    $zoo = new VirtualZoo();

    $pet = new VirtualPet(
        'Leo',
        'Jaguar',
        2000
    );

    $pet2 = new VirtualPet(
        'Rick',
        'Monkey',
        1400
    );

    $pet3 = new VirtualPet(
        'Jack',
        'Elephant',
        4200
    );

    $pet4 = new VirtualPet(
        'Phoenix',
        'Eagle',
        1700
    );

    $zoo->addPet($pet);
    $zoo->addPet($pet2);
    $zoo->addPet($pet3);
    $zoo->addPet($pet4);

    $_SESSION['zoo'] = $zoo;
}

$zoo = $_SESSION['zoo'];

if(isset($_GET['pet'])){
    $pet = $zoo->getPet($_GET['pet']);
}else{
    header("Location: index.php");
}

if(isset($_GET['action'])){
    switch ($_GET['action']) {
        case 'eat-apple':
            $pet->eat(new Apple('Apple',200));
            break;

        case 'eat-rotten-apple':
            $pet->eat(new Apple('Rotten Apple',200,true));
            break;

        case 'eat-ice-cream':
            $pet->eat(new IceCream('Icecream',450,'Napolitan'));
            break;

        case 'eat-sushi':
            $pet->eat(new Sushi('Sushi',520,'Takoyaki'));
            break;

        case 'take-potion':
            $pet->eat(new Apple('Golden Apple Juice',$pet->getBasal()));
            break;
            
        case 'change-name':
            if(!empty($_GET['args'])){
            	$pet->setName($_GET['args']);
            }
            break;
        
        default:
            break;
    }
}

if(isset($_GET['fasting'])){
    if($_GET['fasting']=="on"){
        $calorie = $pet->getCurrentCalories()-($pet->getBasal()*15)/100;
        $pet->setCurrentCalories(($calorie>0)?$calorie:0);
        if($pet->getCurrentCalories()<=0){
            echo "<script>alert('I am so sorry! The pet is dead. :(')</script>";
        }
    }
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Virtual Zoo - Playing</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="resources/css/index.css">
  </head>
  <body class="d-flex justify-content-center align-items-center">
    <div class="modal fade" id="changeName" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="changeName" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="staticBackdropLabel">Change name</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form method="GET" class="row g-3 needs-validation" novalidate>
            <div class="modal-body">
                <div class="col-12">
                    <input type="hidden" name="pet" value="<?php echo $_GET['pet']?>">
                    <input type="hidden" name="action" value="change-name">
                    <label for="newPetName" class="form-label">Pet's name</label>
                    <input type="text" class="form-control" id="newPetName" name="args" value="<?php echo $pet->getName()?>" required>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="close" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button id="change" type="submit" class="btn btn-warning">Change</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="d-flex flex-column bg-secondary rounded">
      <div class="d-flex flex-row justify-content-between align-items-center bg-black rounded-top p-4">
        <h3 class="text-light">Cages</h3>
        <a href="routes/exit.php" class="btn btn-warning"><i class="fa-solid fa-xmark"></i></a>
      </div>
      <div class="d-flex flex-row">
      <?php
        $currenCalories = ($pet->getCurrentCalories()*100)/$pet->getBasal();
        if($currenCalories>75){
            $image = $pet->getType();
            $barType = "bg-success";
            $face = "face-smile-beam";
            $situation = "Happy";
        }
        if($currenCalories>25&&$currenCalories<=75){
            $image = $pet->getType()."2";
            $barType = "bg-warning";
            $face = "face-meh";
            $situation = "Is that food?";
        }
        if($currenCalories<=25&&$currenCalories>0){
            $image = $pet->getType()."3";
            $barType = "bg-danger";
            $face = "face-frown-open";
            $situation = "Hungry";
            $zoo->sendSound($pet);
        }
        if($currenCalories<=0){
            $image = $pet->getType()."4";
            $barType = "bg-danger";
            $face = "face-dizzy";
            $situation = "Passed away";
        }
        if($_GET['pet']!=0){
            $back = '<a href="?pet='.($_GET['pet']-1).'" class="badge rounded-pill bg-white" data-bs-toggle="tooltip" data-bs-title="Previus cage"><i class="text-black fa-solid fa-arrow-left fa-2x"></i></a>';
        }else{
            $back = "";
        }
        if(($_GET['pet']+1)!=count($zoo->getCages())){
            $next='<a href="?pet='.($_GET['pet']+1).'" class="badge rounded-pill bg-white" data-bs-toggle="tooltip" data-bs-title="Next cage"><i class="text-black fa-solid fa-arrow-right fa-2x"></i></a>';
        }else{
            $next="";
        }
        echo '
        <div class="col-8">
            <div class="d-flex justify-content-center align-items-center h-100">
                <div class="d-flex flex-column m-3">
                    <div class="d-flex flex-row align-items-center">
                    	<h4 class="text-dark">Name:</h4><h4 class="text-light ms-1">'.$pet->getName().'</h4>
                    	<i role="button" data-bs-toggle="tooltip" data-bs-title="Edit name" id="changeNameTrigger" class="text-black fa-solid fa-pen-to-square mx-2"></i>
                    </div>
                    <div class="d-flex flex-row mb-3"><h6 class="text-dark">Specie:</h6><h6 class="text-light ms-1">'.$pet->getType().'</h6></div>
                    
                    <div class="d-flex flex-row justify-content-center align-items-center">
                        '.$back.'
                        <div class="d-flex justify-content-center align-items-center mb-3 position-relative">
                            <img class="img-fluid col-9 position-absolute top-50 start-50 translate-middle" src="resources/images/cage.png">
                            <img class="img-fluid  col-8" src="resources/images/animals/'.$image.'.png">
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-black">
                                <div class="d-flex flex-row align-items-center">
                                    <i class="text-warning fa-solid fa-'.$face.' fa-2x"></i>
                                    <span class="ms-1">'.$situation.'</span>
                                </div>
                            </span>
                        </div>
                        '.$next.'
                    </div>
        
                    <h4>Calories</h4>
                    <div class="progress">
                        <div class="progress-bar '.$barType.'" role="progressbar" aria-label="Calories" style="width:'.$currenCalories.'%" aria-valuenow="'.$currenCalories.'" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-4 border-start">
            <div class="d-flex flex-column justify-content-center align-items-center m-3">
                <h4>Give:</h4>
                <div class="d-flex flex-column m-3">
                    <a class="mb-2" data-bs-toggle="tooltip" data-bs-title="Apple" href="?pet='.$_GET['pet'].'&action=eat-apple"><img class="img-fluid" src="resources/images/foods/apple.png" style="height: 50px; width: 50px;"></a>
                    <a class="mb-2" data-bs-toggle="tooltip" data-bs-title="Rotten Apple" href="?pet='.$_GET['pet'].'&action=eat-rotten-apple"><img class="img-fluid" src="resources/images/foods/rottenapple.png" style="height: 50px; width: 50px;"></a>
                    <a class="mb-2" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Ice Cream" href="?pet='.$_GET['pet'].'&action=eat-ice-cream"><img class="img-fluid" src="resources/images/foods/icecream.png" style="height: 50px; width: 50px;"></a>
                    <a class="mb-2" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Sushi" href="?pet='.$_GET['pet'].'&action=eat-sushi"><img class="img-fluid" src="resources/images/foods/sushi.png" style="height: 50px; width: 50px;"></a>
                    <a class="mb-2" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Magic Potion" href="?pet='.$_GET['pet'].'&action=take-potion"><img class="img-fluid" src="resources/images/foods/potion.png" style="height: 50px; width: 50px;"></a>
                </div>
            </div>
        </div>
        ';
      ?>
      </div>
    </div>

    <script src="https://kit.fontawesome.com/1d52c626c2.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script>
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

        $(function(){
            var Timer = function(callback, delay) {
                var timerId, start, remaining = delay;

                this.pause = function() {
                    window.clearTimeout(timerId);
                    timerId = null;
                    remaining -= Date.now() - start;
                };

                this.resume = function() {
                    if (timerId) {
                        return;
                    }

                    start = Date.now();
                    timerId = window.setTimeout(callback, remaining);
                };

                this.resume();
            }

            var timer = new Timer(function() {
                location.href = location.href
            }, 20000)

            <?php 
            if($pet->getCurrentCalories()<=0){
                echo 'timer.pause()';
            }
            ?>

            $("#changeNameTrigger").on("click",function(){
                $("#changeName").modal("toggle")
                timer.pause()
            })

            $("#close").on("click",function(){
                $("#changeName").modal("toggle")
                timer.resume()
            })
        })
    </script>
    <script>window.history.pushState(null, document.title, '?pet=<?php echo $_GET['pet']?>&fasting=on')</script>
    </body>
</html>
