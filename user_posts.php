<?php
    $image = "imgs/1000_F_346839683_6nAPzbhpSkIpb8pmAwufkC7c5eD7wYws.jpg";
    if($row_users['type'] === 'farmer'){
        if(file_exists($row_farmer['image'])){
            $image = $row_farmer['image'];
        }
    }
    elseif($row_users['type'] === 'veterinary'){
        if(file_exists($row_vet['image'])){
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
            <span class="setting" style="display: flex;">
                <p style="margin-right: 10px;">
                <?php
                    echo "<a style='color: red;'  onClick=\" javascript:return confirm('Are You Sur To DELETE This Post')\" href='delete_post.php?postid={$row['post_id']}'>Delete</a>";
                ?>
                </p>
                <p>
                <?php
                    echo "<a style='color: #22c55e;' href='edit.php?id={$row['post_id']}'>Edit</a>";
                ?>
                </p>
            </span>
            
        </div>
        <div class="text">
            <p><?php echo $row['post'] ?></p>
        </div>
        <div class="image">
            <?php if ($row['has_image'] == 1): ?>
                <img src="<?php echo $row['image']; ?>" alt="">
            <?php endif; ?>
        </div>
        <div class="icons" >
            <?php 
                $likes = "";

                if($row['likes'] > 0){

                    $likes = "(" .$row['likes']. ")";
                }
                else {
                    $likes = "";
                }
            ?>
            <a style="display: flex;" class="like-button" href="like.php?type=post&id=<?php echo $row['post_id'] ?>">
                <i id="heart-icon" class="heart-icon fa-regular fa-heart"></i>
                <?php 
                    echo "<div style='color: darkgray;font-size: 14px;margin: 0 15px 0 0'>";
                    echo  $likes ;
                    echo "</div>";
                ?>
                
            </a>
            
            <i class="fa-regular fa-comment"></i>
        </div>
    </div>