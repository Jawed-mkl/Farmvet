<?php
$img = "imgs/1000_F_346839683_6nAPzbhpSkIpb8pmAwufkC7c5eD7wYws.jpg";
if(!empty($row_info_receiver['img'])){
    $img = $row_info_receiver['img'];
}
$files = "";

if(file_exists($msg['file'])){
   
    $files = $msg['file'] ;

}
?>



<div class="message received">
    <img src="<?php echo $img; ?>" alt="Khalid Charif">
    <div class="message-content">
        <span><?php echo $msg['message'] ?></span>
        <?php if (!empty($files)): ?>
            <br>
            <img style="width: 100%;height: 180px;border-radius: 0;" src="<?php echo $files; ?>" alt="Attached Image">
        <?php endif; ?>
    </div>
    <time style="color: #afafaf;font-size: 10px;transform: translateY(-14px);margin-left: 6px;"><?php echo $msg['date'] ?></time>
</div>