<div class="below-cover">
                <div class="friends-area">
                    <div class="friends-bar">

                        <p style="text-align:center;font-size: 18px;margin-bottom:20px;">Sleduje</p>
                        <?php

                        if ($friends) {
                            foreach ($friends as $friend) {
                                $user = new User();
                                $ROW = $user->getUser($friend['userid']);
                                include("user.php");
                            }
                        }

                        ?>

                    </div>
                </div>

                <div class="posts-area">

                    <?php
                    if ($userData['userid'] == $_SESSION['krejzik_userid'])
                    {
                    ?>
                    <div class="new-feed">
                    <form id="postForm" action="#" method="POST" enctype="multipart/form-data">
                        <textarea id="postText" name="post" placeholder="Co máte na mysli?" style="word-wrap: break-word;"
                            oninput="updateCharacterCount()"></textarea>
                        <div id="charCount" style="float:right;">0/300</div>
                        <input type="file" name="file">
                        <button style="margin-top:20px;" type="submit">PŘIDAT</button>
                    </form>
                    </div>

                    <?php
                    }

                    if ($posts) {
                        echo '<div class="post-bar">';
                        foreach ($posts as $ROW) {
                            $user = new User();
                            $rowUser = $user->getUser($ROW['userid']);

                            include("post.php");
                        }
                        echo '</div>';
                    }

                    $pg = PaginationLink();
                    ?>

                        <a href="<?= $pg['nextPage'] ?>"><button style="float:right;margin-top:10px;"
                                type="button">Dále<i class="fas fa-chevron-right"></i></button>
                        </a>
                        <a href="<?= $pg['prevPage'] ?>"><button style="float:left;margin-top:10px;"
                                type="button"><i class="fas fa-chevron-left"></i>Zpět</button>
                        </a>


                </div>

                <script>
                    function updateCharacterCount() {
                        var text = document.getElementById('postText').value;
                        var charCount = text.length;

                        // Omezení délky textu na 300 znaků
                        if (charCount > 300) {
                            document.getElementById('postText').value = text.substring(0, 300);
                            charCount = 300;
                        }

                        document.getElementById('charCount').innerText = charCount + '/300';
                        }
            </script>
            </div>