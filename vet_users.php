<?php
    $image = "imgs/1000_F_346839683_6nAPzbhpSkIpb8pmAwufkC7c5eD7wYws.jpg";
?>

                <div class="card">
                    <span class="rate">
                        <i class="filled fas fa-star"></i>
                        <i class="filled fas fa-star"></i>
                        <i class="filled fas fa-star"></i>
                        <i class="filled fas fa-star"></i>
                        <i class="far fa-star"></i>
                    </span>
                    <div class="profile-pic">
                        <img src="<?php if(empty($vet_row['image'])){
                                            echo $image;
                                        }
                                        else {
                                            echo $vet_row['image'];
                                        } ?>" 
                        alt="">
                    
                    </div>
                    <div class="bottom">
                        <div class="content">
                            <span class="name">Dr.<?php echo $vet_row['firstn'] . " " . $vet_row['lastn'] ?></span>
                            <span class="about-me"><?php echo $vet_row['bio']; ?></span>
                        </div>
                    <div class="bottom-bottom">
                        <div class="info">
                            <a class="show-profile" id="show-profile" href="">Read More</a>
                            <i class="fas fa-long-arrow-alt-right"></i>
                        </div>
                        <a class="button" href="messages.php?id=<?php echo $vet_row['user_id']; ?>">Contact Me</a>

                    </div>
                    </div>
                </div>


                
                <div class="profile-card" id="profile-card">
                
                    <span id="close-icon" class="close-icon">
                        <i class="fa-solid fa-xmark"></i>
                    </span>
                    <div class="img-box">
                        <img src="<?php if(empty($vet_row['image'])){
                                        echo $image;
                                    }
                                    else {
                                        echo $vet_row['image'];
                                    } ?>" alt="">
                    </div>
                    <div class="info-box">
                        <h2>Dr.<?php echo $vet_row['firstn'] . " " . $vet_row['lastn'] ?></h2>
                        <p>veterinary</p>
                        <span class="rate">
                            <i class="filled fas fa-star"></i>
                            <i class="filled fas fa-star"></i>
                            <i class="filled fas fa-star"></i>
                            <i class="filled fas fa-star"></i>
                            <i class="far fa-star"></i>
                        </span>
                        <div class="location">
                            <i class="fa-solid fa-location-dot"></i>
                            <span><?php echo $vet_row['location']; ?></span>
                        </div>
                        <span><?php echo $vet_row['bio']; ?></span>
                        <input type="submit" class="button" value="contact">
                        
                    </div>
                </div>
                
