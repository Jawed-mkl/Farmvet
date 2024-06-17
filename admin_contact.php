<?php
session_start();
    include("classes/connect.php");
    include("classes/log-in.php");
    include("classes/users_data.php");
    include("classes/posts.php");
    include("classes/admin.php");
    $admin = new admin();

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

            // Redirect based on user type
            if ($type === 'admin') {

                $users = new users_data();
                $users_d = $users -> get_info_post($id);

                if(!$users_d){
                    header("Location: log-in.php");
                    die;
                }
                
            }
            else {
                // Handle other user types or show an error
                echo "Unknown user type!";
                header("Location: log-in.php");
                    die;
            } 
        } else {
                // Handle other user types or show an error
            echo "Unknown user type!";
            header("Location: log-in.php");
            die;
        }
    } else {
            header("Location: log-in.php");
            die;
    }

    require 'mail.php';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Retrieve and sanitize form input
        $name = htmlspecialchars($_POST['name']);
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $subject = htmlspecialchars($_POST['subject']);
        $msg = htmlspecialchars($_POST['message']);

        try {
            // Set the sender and recipient of the email
            $mail->setFrom($email, $name);
            $mail->addAddress('makreloufjawed1009@gmail.com');

            // Set the email format to HTML and set the subject and body content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = '<p><strong>Name:</strong> ' . $name . '</p>' .
                            '<p><strong>Email:</strong> ' . $email . '</p>' .
                            '<p><strong>Message:</strong> ' . $msg . '</p>';

            // Send the email
            $mail->send();
            echo 'Email has been sent';
            header("Location: admin_contact.php");
        } catch (Exception $e) {
            echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    $user_id = $_SESSION['users_id'];
    $publication_count = $admin->count_publications($user_id);

    $info = new users_data();

    $row = $info->get_info_post($user_id);

    $image = "imgs/1000_F_346839683_6nAPzbhpSkIpb8pmAwufkC7c5eD7wYws.jpg";
    if(file_exists($row['img'])){
        $image = $row['img'];
    }
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!----======== CSS ======== -->
    <link rel="stylesheet" href="css/all.min.css" />
    <link rel="stylesheet" href="css/lights.css" id="light-mode-stylesheet">
    <link rel="stylesheet" href="css/darks.css" id="dark-mode-stylesheet" disabled>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&#038;display=swap" rel="stylesheet" />
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    
    <title>Contact Us</title> 
</head>
<body>
    <nav class="sidebar close">
        <header>
            <div class="image-text">
                <span class="image">
                    <img src="<?php echo $image; ?>" alt="">
                </span>

                <div class="text logo-text">
                    <span class="name"><?php echo $row['firstn'] . " " . $row['lastn']; ?></span>
                    <span class="profession"><?php echo $row['mail']; ?></span>
                </div>
            </div>

            <i class='bx bx-chevron-right toggle'></i>
        </header>

        <div class="menu-bar">
            <div class="menu">

                <li class="search-box">
                    <i class='bx bx-search icon'></i>
                    <input type="text" placeholder="Search...">
                </li>

                <ul class="menu-links">
                <li class="nav-link">
                        <a href="admin.php">
                            <i class="fa-solid fa-house icon"></i>
                            <span class="text nav-text">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="admin_settings.php">
                            <i class='bx bxs-cog icon'></i>
                            <span class="text nav-text">Settings</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="admin_contact.php">
                            <i class="fa-solid fa-envelope icon"></i>
                            <span class="text nav-text">Contact Us</span>
                        </a>
                    </li>

                </ul>
            </div>

            <div class="bottom-content">
                <li class="">
                    <a href="logout.php">
                        <i class='bx bx-log-out icon' ></i>
                        <span class="text nav-text">Logout</span>
                    </a>
                </li>

                <li class="mode">
                    <div class="sun-moon">
                        <i class='bx bx-moon icon moon'></i>
                        <i class='bx bx-sun icon sun'></i>
                    </div>
                    <span class="mode-text text">Dark mode</span>

                    <div class="toggle-switch">
                        <span class="switch"></span>
                    </div>
                </li>
                
            </div>
        </div>

    </nav>

    <section class="home">
        <!-- Start Head -->
        <div class="head ">
            <div class="search ">
             <img src="imgs/Farmvetlogo_white.png" alt="">
            </div>
            <div class="icons ">
              <img src="<?php echo $image; ?>" alt="" />
            </div>
          </div>
          <!-- End Head -->

        <h2>Contact Us</h2>
        <div class="main">
                    <ul class="box-info">
                        <li>
                            <i class="fa-solid fa-user"></i>
                            <span class="text">
                                <h3><?php $admin->farmer_number(); ?></h3>
                                <p>Farmer</p>
                            </span>
                        </li>
                        <li>
                            <i class="fa-solid fa-user-doctor"></i>
                            <span class="text">
                                <h3><?php $admin->vet_number(); ?></h3>

                                <p>Veterinary</p>
                            </span>
                        </li>
                        <li>
                            <i class="fa-solid fa-file-export"></i>
                            <span class="text">
                                <h3><?php echo "Total number of publications: " . $publication_count; ?></h3>
                                <p></p>
                            </span>
                        </li>
                    </ul>
        </div>			
        
        <div class="form-card1">
            <div class="form-card2">
                <form class="form" method="post" enctype="multipart/form-data">
                <p class="form-heading">Get In Touch</p>

                <div class="form-field">
                    <input required="" placeholder="Name" class="input-field" type="text" name="name" value="<?php echo $users_d['firstn'] . " " . $users_d['lastn'] ?>"/>
                </div>

                <div class="form-field">
                    <input
                    required=""
                    placeholder="Email"
                    class="input-field"
                    type="email"
                    name="email"
                    value="<?php echo $users_d['mail'] ?>"
                    />
                </div>

                <div class="form-field">
                    <input
                    required=""
                    placeholder="Subject"
                    class="input-field"
                    type="text"
                    name="subject"
                    />
                </div>

                <div class="form-field">
                    <textarea
                    style="font-weight: 900;"
                    required=""
                    placeholder="Message"
                    cols="30"
                    rows="5"
                    class="input-field"
                    name= "message"
                    ></textarea>
                </div>

                <input type="submit" class="sendMessage-btn" value="Send Message" />
                </form>
            </div>
        </div>

        
    </section>

    <script src="js/admin.js"></script>

</body>
</html>