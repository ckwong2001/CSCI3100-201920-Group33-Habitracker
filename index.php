<html>
    <head>
        <link rel="stylesheet" type="text/css" href="index.css">
    </head>

    <body>

    <?php
    require "header.php";
?>


    <main>
        <?php
        //display login success message when one has logged in the system
        if (isset($_GET['login'])){
            if($_GET['login'] == 'success')
                echo "<p>You are logged in! </p>";
        }
            if (isset($_SESSION['user_id'])){
                echo '<p>You can access different functions of Habitracker using links at the header. Explore your journey in Habitracker!</p>';
            }
            else {
                //display login failed message when one hasn not logged in the system
                //to prevent people accessing users' information by altering the url
                echo '<p>You are not logged in! Please log in to use Habitracker.</p>';
            }
        ?>
    </main>

   <!--displaying the layout of the index page -->
        <header>
            <div class="content">
                <div class="kolom">
                    <div class="atas">
                        <a href="create_goal.php">
                            <img src="img/target.png">
                        </a>
                    </div>
                    <div class="tengah">
                        <h2>GOALS</h2>
                    </div>
                    <div class="bawah">
                        <p>Set up a goal to step out of your comfort zone and challenge yourself - you might discover something beyond your imagination!</p>
                    </div>
                </div>
                <div class="kolom">
                    <div class="atas">
                        <a href="activity_create_nonrecurring.php">
                            <img src="img/bicycling.png">
                        </a>
                    </div>
                    <div class="tengah">
                        <h2>ACTIVITIES</h2>
                    </div>
                    <div class="bawah">
                        <p>Start an activity and find some hobby-buddies - meet new friends and be one another's support in this exploration!</p></div>
                    </div>
                <div class="kolom">
                    <div class="atas">
                        <a href="chatindex.php">
                            <img src="img/conversation.png">
                        </a>
                    </div>
                    <div class="tengah">
                        <h2>CHAT</h2>
                    </div>
                    <div class="bawah">
                        <p>Talk to friends when you are in doubt - share your experience or get some advice from the supportive user community!</p>
                    </div>
                </div>
                

            </div>
        </header>


    </body>




<?php
    require "footer.php";
?>
