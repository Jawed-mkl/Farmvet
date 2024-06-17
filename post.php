<?php
    $image = "imgs/1000_F_346839683_6nAPzbhpSkIpb8pmAwufkC7c5eD7wYws.jpg";
    if (isset($row_users['type'])) {
        if ($row_users['type'] === 'farmer' && isset($row_farmer['image']) && file_exists($row_farmer['image'])) {
            $image = $row_farmer['image'];
        } elseif ($row_users['type'] === 'veterinary' && isset($row_vet['image']) && file_exists($row_vet['image'])) {
            $image = $row_vet['image'];
        }
    }


?>
    <div class="post-list">
        <div class="info">
            <img src="<?php echo $image; ?>" alt="">
            <span> @<?php echo $row_users['firstn'] . " " . $row_users['lastn'] ?> 
                <br><p><?php echo $row_users['type'] ?> </p>
            </span>
            <p><?php echo $row['date'] ?></p>
            
        </div>
        <div class="text">
            <p><?php echo $row['post'] ?></p>
        </div>
        <div class="image">
            <?php if ($row['has_image'] == 1): ?>
                <img src="<?php echo $row['image']; ?>" alt="">
            <?php endif; ?>
        </div>
        <div class="icons">
            <?php 
                $likes = "";

                if($row['likes'] > 0){

                    $likes = "(" .$row['likes']. ")";
                }
                else {
                    $likes = "";
                }
            ?>
            <a class="like-button" href="like.php?type=post&id=<?php echo $row['post_id'] ?>">
                <i id="heart-icon" class="heart-icon fa-regular fa-heart"></i>
                <?php 
                    echo "<div style='color: darkgray;font-size: 14px;margin: 0 15px 0 0'>";
                    echo  $likes ;
                    echo "</div>";
                ?>
                
            </a>
            <a id="comment-icon" class="like-button" href="comment.php?type=post&id=<?php echo $row['post_id'] ?>">
                <i class="fa-regular fa-comment"></i>
                <?php 
                    echo "<div style='color: darkgray;font-size: 14px;margin: 0 15px 0 0'>";

                    echo "</div>";
                ?>
                
            </a>
            
        </div>
    </div>
    

    


    

    