<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Krejzik | Profil</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" type="image/png" href="img/silenyvlk.png">
</head>

<style>
    #search-box{
        background-image: url(img/search.png);
        background-repeat: no-repeat;
        background-position: right;
        width: 400px; 
    }
    #pfp {
        width: 40px; 
        border-radius: 50%;
    }
    #content {
        width: 800px;
        margin: auto;
        min-height: 400px;
    }
    #cover {
        background-color: white;
        text-align: center;
        color: #405d9b;
    }
    #cover-img {
        width: 100%;
    }
    #cover-pfp{
        width: 150px;
        border-radius: 50%;
        border: solid 2px white;
    }
    #menu_buttons {
        width: 100px;
        display: inline-block;
        margin: 2px;
    }
    #username {
        font-size: 20px;
    }
    #below-cover{
        display: flex;
    }
    #friends-area{
        min-height: 400px;
        flex:1;
        margin-right: 10px;
    }
    #posts-area {
        min-height: 400px;
        flex:2.5;
    }
    #friends-img{
        width: 75px;
        float: left;
        margin: 8px;
    }
    #friends-bar{
        min-height: 400px;
        margin-top: 20px;
        padding: 8px;
        color: #405d9b;
        text-align: center;
        font-size: 20px;
    }
    #friends {
        clear: both;
        font-size: 15px;
        font-weight: bold;
        color: #405d9b;
    }
    #new-feed {
        border: solid thin #aaa;
        padding: 10px;
        background-color: white;
        margin-top: 20px;
    }
    textarea {
        width: 100%;
        border: none;
        font-size: 14px;
        height: 60px;
        resize: none;
    }
    #post_button {
        float: right;
        background-color: #F16529;
        border: none;
        color: white;
        padding: 4px;
        font-size: 14px;
        border-radius: 2px;
        width: 50px;
    }
    #post-img {
        width: 75px;
        margin-right: 4px;
    }
    #post-bar {
        margin-top: 20px;
        background-color: white;
        padding: 10px;
    }
    #post {
        padding: 4px;
        font-size: 13px;
        display: flex;
        margin-bottom: 20px;
    }
    #post-owner {
        font-weight: bold;
        color: #405d9b;
    }
    #post a {
        font-size: 12px;

    }
</style>
<body>
    <header>
        <nav class="navbar">
            <a href="index.html" class="nav-logo">
              <img src="img/silenyvlk.png" alt="Logo" class="logo">
              <img src="img/krejzik.png" alt="Logo" class="logotext">
            </a>
            <ul class="nav-menu">
              <li class="nav-item">
                <input type="text" placeholder="Vyhledejte své známé!" id="search-box">
                <img src="img/selfie.jpg" id="pfp" alt="pfp">
              </li>
            </ul>
          </nav>
          <div class="navbar-bottom"></div>
    </header>

    <main>
    <div id="content">
        
        <div id="below-cover">
            <div id="friends-area">
                <div id="friends-bar">
                    
                    <img src="img/selfie.jpg" id="cover-pfp" alt="pfp">
                    Marybanda <br>

                </div>
            </div>

            <div id="posts-area">

                <div id="new-feed">
                    <textarea placeholder="Co máte na mysli?"></textarea>
                    <input type="submit" id="post_button" value="Přidat">
                </div>

                <div id="post-bar">
                    <div id="post">
                        <div>
                            <img id="post-img" src="img/user1.jpg" alt="pfp">
                        </div>
                        <div>
                            <div id="post-owner">First guy</div>
                            Lorem Ipsum is simply dummy text of the printing and typesettings industry.  Lorem Ipsum is simply dummy text of the printing and typesettings industry.  
                            Lorem Ipsum is simply dummy text of the printing and typesettings industry.  Lorem Ipsum is simply dummy text of the printing and typesettings industry.
                            <br><br>
                            <a href="">Like</a> . <a href="">Comment</a> . <span style="color:#999;">5. října 2023</span>
                        </div>
                    </div>

                    <div id="post">
                        <div>
                            <img id="post-img" src="img/user2.jpg" alt="pfp">
                        </div>
                        <div>
                            <div id="post-owner">Second guy</div>
                            Lorem Ipsum is simply dummy text of the printing and typesettings industry.  Lorem Ipsum is simply dummy text of the printing and typesettings industry.  
                            Lorem Ipsum is simply dummy text of the printing and typesettings industry.  Lorem Ipsum is simply dummy text of the printing and typesettings industry.
                            <br><br>
                            <a href="">Like</a> . <a href="">Comment</a> . <span style="color:#999;">5. října 2023</span>
                        </div>
                    </div>

                    <div id="post">
                        <div>
                            <img id="post-img" src="img/user3.jpg" alt="pfp">
                        </div>
                        <div>
                            <div id="post-owner">Third guy</div>
                            Lorem Ipsum is simply dummy text of the printing and typesettings industry.  Lorem Ipsum is simply dummy text of the printing and typesettings industry.  
                            Lorem Ipsum is simply dummy text of the printing and typesettings industry.  Lorem Ipsum is simply dummy text of the printing and typesettings industry.
                            <br><br>
                            <a href="">Like</a> . <a href="">Comment</a> . <span style="color:#999;">5. října 2023</span>
                        </div>
                    </div>

                    <div id="post">
                        <div>
                            <img id="post-img" src="img/user4.jpg" alt="pfp">
                        </div>
                        <div>
                            <div id="post-owner">First guy</div>
                            Lorem Ipsum is simply dummy text of the printing and typesettings industry.  Lorem Ipsum is simply dummy text of the printing and typesettings industry.  
                            Lorem Ipsum is simply dummy text of the printing and typesettings industry.  Lorem Ipsum is simply dummy text of the printing and typesettings industry.
                            <br><br>
                            <a href="">Like</a> . <a href="">Comment</a> . <span style="color:#999;">5. října 2023</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
    </main>
</body>
</html>