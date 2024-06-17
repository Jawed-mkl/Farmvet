<?php
    include("classes/autoload.php");


    // Check if the user is logged in
    if (isset($_SESSION['users_id']) && is_numeric($_SESSION['users_id'])) {

        $id = $_SESSION['users_id'];
        $login = new login();
        $result = $login->check_login($id);

        if (is_array($result) && array_key_exists('error', $result)) {
            // Handle the error case
            echo "Error: " . $result['error'];
        } elseif ($result) {
            $type = $result['type'];

            if ($type === 'farmer') {

            $users = new users_data();
            $users_d = $users -> get_farmer_data($id);

            if(!$users_d){
                header("Location: log-in.php");
                die;
            }
            } 
            elseif ($type === 'veterinary') {

                header("Location: veterinary.php");
                die;
            }
            else {
                echo "Unknown user type!";
            }
        } 
        else {
            header("Location: log-in.php");
            die;
        }
    } else {
        header("Location: log-in.php");
        die;
    }

    //collect veterinary
    $user = new users_data();
    $id = $_SESSION['users_id'];
    $vet = $user->get_vet($id);

    //collect pub
    $pub = new admin();
    $id = $_SESSION['users_id'];
    $pubs = $pub->get_pubs($id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Farmer</title>
    <link rel="stylesheet" href="css/all.min.css" />
    <link rel="stylesheet" href="css/all_vet.css" />
    <link rel="stylesheet" href="css/styles.css" />
    <link rel="stylesheet" href="css/log-out.css">

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;500&#038;display=swap" rel="stylesheet" />
</head>
<body>
    <div class="page ">
        
        <div class="sidebar">
            <div class="fix-sidebar">
                <h3 class="title">FarmVet</h3>
                <ul>
                    <li>
                    <a class="" href="farmer.php">
                        <i class="fa-solid fa-house fa-fw"></i>
                        <span>Home</span>
                    </a>
                    </li>
                    <li>
                    <a class="" href="farmerProfile.php">
                        <i class="fa-regular fa-user fa-fw"></i>
                        <span>Profile</span>
                    </a>
                    </li>
                    <li>
                    <a class="active" href="all_vet.php">
                        <i class="fa-solid fa-user-doctor fa-fw"></i>
                        <span>veterinarians</span>
                    </a>
                    </li>
                    <li>
                    <a class="" href="farmer_msg.php">
                        <i class="fa-solid fa-comments fa-fw"></i>
                        <span>Messages</span>
                    </a>
                    </li>
                    <li>
                    <a class="" href="farmer_shop.php">
                        <i class="fa-solid fa-store"></i>
                        <span>Store</span>
                    </a>
                    </li>
                    <li>
                    <a class="" href="contactf.php">
                        <i class="fa-solid fa-envelope fa-fw"></i>
                        <span>Contact Us</span>
                    </a>
                    </li>
                </ul>
                <div class="language">
                        <div class="language-selected" data-i18n="language">
                            Language
                        </div>
                        <ul class="ul">
                            <li class="li"><a href="#" class="en" onclick="changeLanguage('en')" data-i18n="en" selected>English</a></li>
                            <li class="li"><a href="#" class="fr" onclick="changeLanguage('fr')" data-i18n="fr">French</a></li>
                            <li class="li"><a href="#" class="ar" onclick="changeLanguage('ar')" data-i18n="ar">Arabic</a></li>
                        </ul>
                </div>
                <div class="box">
                <?php
                        $image = "imgs/1000_F_346839683_6nAPzbhpSkIpb8pmAwufkC7c5eD7wYws.jpg";
                        if(file_exists($users_d['image'])){
                            $image = $users_d['image'];
                        }
                    ?>
                    <img src="<?php echo $image; ?>" alt="">
                    <div class="info">
                        <span>@<?php echo $users_d['firstn'] . $users_d['lastn'] ?>
                            <br>
                            <p>Farmer</p>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    
        <div class="content">

        <div class="box1">
            
            <div class="head-box">
                <div class="title">
                    <a href="farmer.php">For you</a>
                    <a href="all_vet.php" class="active">veterinarians</a>
                    <span class="notification">
                        <i class="fa-regular fa-bell fa-lg"></i>
                    </span>
                </div>
            </div>
            <div class="body-box">
                <div class="container">
                    <?php
                        if($vet){

                            foreach ($vet as $vet_row){
                                include("vet_users.php");
                            }
                        }
                        
                    ?>
                </div>

                
            </div>
        </div>

        <div class="box2">
            <div class="head-box">
                <div class="search ">
                    <input class="p-10" type="search" placeholder="Type A Keyword" />
                    <button class="Btn">
                        <div class="sign"><svg viewBox="0 0 512 512"><path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"></path></svg></div>
                        <a href="logout.php" class="text" >Logout</a>
                    </button>
                </div>
            </div>
            <div class="body-box">
            <?php
                    if($pubs){
                        $count = 1;
                        foreach ($pubs as $rowss){
?>
                        <div class="pub">
                            <h1 style="text-decoration: underline;color: red;font-size: 16px;">publication <?php echo $count; ?>:</h1>
                            <div class="title">
                                <h3><?php echo $rowss['title']; ?></h3>
                                <span><?php echo $rowss['date']; ?></span>
                            </div>
                            <span><?php echo $rowss['texte']; ?></span>
                            <img src="<?php echo $rowss['image']; ?>" alt="">

                        </div>
                            
                            <?php
                        }
                    }
                    
                ?>
                
            </div>

        </div>
        
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const showProfileButtons = document.querySelectorAll('.show-profile');
            const profileCards = document.querySelectorAll('.profile-card');

            // Add click event listeners to each "Read More" button
            showProfileButtons.forEach(function(button, index) {

                button.addEventListener('click', function(event) {
                    event.preventDefault();
                    // Display the corresponding profile card
                    profileCards[index].style.display = 'flex';
                });
            });

            // Add click event listeners to close buttons
            const hideButtons = document.querySelectorAll('.close-icon');

            hideButtons.forEach(function(button) {

                button.addEventListener('click', function(event) {
                    event.preventDefault();
                    // Hide the corresponding profile card
                    const card = button.closest('.profile-card');
                    card.style.display = 'none';
                });
            });
        });
</script>

    

</body>
</html>