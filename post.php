<?php 
    $image = "img/profilepic.jpg";
    $timestamp =  $ROW['date'];
?>


                    <div class="post">
                        <div>
                            <img class="post-img" src="<?php echo $image ?>" alt="pfp">
                        </div>
                        <div>
                            <a class="text-grad post-owner" href="">
                                <?php 
                                echo $rowUser['username']; 
                                ?>
                        
                            </a>
                            <?php 
                                echo $ROW['post'];
                            ?>
                            <br><br>
                            <a href="">Like</a> . <a href="">Comment</a> . 
                            <span style="color:#999;"><?php echo date('d/m/Y', strtotime($timestamp)); ?></span>
                        </div>
                    </div>
              