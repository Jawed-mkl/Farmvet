<?php
$img = "imgs/1000_F_346839683_6nAPzbhpSkIpb8pmAwufkC7c5eD7wYws.jpg";
if(!empty($row_info['img'])){
    $img = $row_info['img'];
}

$files = "";

if(file_exists($msg['file'])){
   
    $files = $msg['file'] ;

}
?>
<div class="message sent">
    <time style="color: #afafaf;font-size: 10px;transform: translateY(-14px);"><?php echo $msg['date'] ?></time>
    <div class="message-content">
        <span><?php echo $msg['message'] ?></span>

        <?php if (!empty($files)): ?>
            <br>
            <img style="width: 100%;height: 180px;border-radius: 0;" src="<?php echo $files; ?>" alt="Attached Image">
        <?php endif; ?>
       
        
    </div>
    <img src="<?php echo $img; ?>" alt="User">
</div>