<?php
session_start();
#error_reporting(E_ALL);
require_once("Includes/db.php");




$loggedin = ( isset($_SESSION['signedin']) && $_SESSION['signedin'] == '1' ? TRUE : FALSE );
//Check credentials
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Anyone Can Cook</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <!-- Le styles -->
        <link href="assets/css/bootstrap.css" rel="stylesheet">
        <link href="assets/css/tommy.css" rel="stylesheet"> 
        <link href="assets/css/bootstrap-responsive.css" rel="stylesheet">

        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

        <!-- Fav and touch icons -->
        <link rel="shortcut icon" href="../assets/ico/favicon.ico">
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">
    </head>

    <body>

        <!-------------------------------------toptext----------------------------------------->
        <div style="text-align: center;
             margin-top:0.5em;">
            <p>This is a webpage made as a school project between the schools FAU(Florida) and SFSU(San Fransisco)</p>
        </div>
        <!-------------------------------------navbar----------------------------------------->
        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                    <div class="nav-collapse collapse">
                        <div class="row">
                            <div class="span7">
                                <img src="logo.png" class="fluid" style="max-width: 90%;">
                                <h4>The perfect place to learn, search and share recipes!</h4>
                            </div>


                            <div class="span5">
                                <div class="span5">
                                    <div class="navbar-form pull-right">
                                        <?php
                                        if (isset($_POST['logon2'])) {
                                            if ((Recipe::getInstance()->checkuserpass($_POST['username'], $_POST['password'])) === TRUE) {
                                                $_SESSION['signedin'] = 1;
                                                $_SESSION['username'] = $_POST['username'];
                                                echo '<meta http-equiv="refresh" content="0;URL=\'http://sfsuswe.com/~f12g31/index.php\' />';
                                            } else {
                                                echo "Invalid name and/or password";
                                            }
                                        }
                                        ?>
                                        <?
                                        //if user is logged in
                                        if (isset($_SESSION['signedin']) && $_SESSION['signedin'] == '1') {
                                            echo '<h4>Welcome, ' . $_SESSION['username'] . '!</h4>
                                            <a href="index.php?page=logout">Logout</a>';
                                        }
                                        //if user is not logged in
                                        else {
                                            echo '
                                        <form name="logon" action="index.php" method="POST" >
                                        <table width="452" border="0" cellspacing="2">
                                            <tr>
                                                <td width="64">Username:</td>
                                                <td width="63">Password:</td>                                              
                                                <td width="10"><a href="index.php?page=signup" class="span2">SIGN UP FREE...!</a></td>
                                            </tr>
                                            <tr>
                                                <td><input class="span2" type="text" name="username" id="username"/></td>
                                                <td><input class="span2" type="password" name="password" id="password"></td>
                                                <td><input type="submit" name="logon2" value="Login"  class="btn"/></td>
                                            </tr>
                                                             
                                            <tr>
                                                <td></td>
                                                <td><a href="#">Forgot password?</a></td>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">

                                                </td>
                                            </tr>
                                        </table>';
                                        }
                                        ?>    

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!--/.nav-collapse -->
                </div>
            </div>
        </div>
        <div class="container">
            <!-------------------------------------inner-navbar----------------------------------------->
            <div class="row">
                <div class="span12">
                    <div class="subnav navbar2 vert-align">
                        <ul class="nav nav-pills">
                            <li><a href="index.php">Home</a></li>
                            <li><a href="index.php?page=topRecipe">Top Recipes</a></li>
                            <li><a href="index.php?page=browse">Browse</a></li>
                            <li><a href="index.php?page=searchByIngredients">Search by Ingredients</a></li>
                            <li><a href="index.php?page=uploadRecipe">Upload</a></li>
                            <li class="pull-right"><form class="form-search" method="get" action="index.php">
                                    <input type="text" name="key" placeholder="Type keywords to search recipes" class="span3 search-query">
                                    <input type="hidden" name="page" value="search">
                                    <input type="hidden" name="method" value="search">
                                    <button type="submit" class="btn" style="margin-right: 10px;">Search</button>
                                </form></li>

                        </ul>
                    </div>


                </div>
            </div>
            <!-------------------------------------left-sidebar----------------------------------------->
            <div class="row">
                <div class="span2">
                    <div class="main-content">
                        <h4>Category:</h4>
                        <ul class="browse-list">
                            <li><a href="index.php?page=search&method=cat&key=1">Pasta</a></li>
                            <li><a href="index.php?page=search&method=cat&key=2">Steak</a></li>
                            <li><a href="index.php?page=search&method=cat&key=3">Poultry</a></li>
                            <li><a href="index.php?page=search&method=cat&key=5">Fish</a></li>
                            <li><a href="index.php?page=search&method=cat&key=10">Dessert</a></li>
                        </ul>
                        <small class="pull-right"><a href="index.php?page=browse">see more&gt;&gt;</a></small>
                        <br>
                    </div>
                    <div class="main-content">
                        <h4>Difficulty:</h4>
                        <ul class="browse-list">
                            <li><a href="index.php?page=search&method=diff&key=Easy">Easy</a></li>
                            <li><a href="index.php?page=search&method=diff&key=Mild">Mild</a></li>
                            <li><a href="index.php?page=search&method=diff&key=Moderate">Moderate</a></li>
                            <li><a href="index.php?page=search&method=diff&key=Hard">Hard</a></li>
                            <li><a href="index.php?page=search&method=diff&key=Expert">Expert</a></li>
                        </ul>
                    </div>
                </div>

                <!-------------------------------------center-content--------------------------------------->
                <div class="span7">
                    <div class="main-content">

<?php
if (@$_GET["page"] == null) {
    @include '' . home . '.php';
} else {
    include( '' . $_GET["page"] . '.php');
}
?>
                    </div>
                    <!-------------------------------------recently-added---------------------------------------->
                    <div class="row">
                        <div class="span7">
                            <div class="main-content">
                                <h3 class="center">Recently added</h3>
                                <div class="row" style="margin-left: auto; margin-right: auto;">
<?php
//connect
$dbhost = 'sfsuswe.com';
$dbuser = 'f12g31';
$dbpass = 'group31';
$conn = mysql_connect($dbhost, $dbuser, $dbpass);
if (!$conn) {
    echo "Could not connect";
} else {
    //select database
    mysql_select_db('student_f12g31');
    //create sql statement
    $sql = "SELECT * FROM Recipe ORDER BY timestamp DESC";
    $result = mysql_query($sql, $conn);
    //initiate counter
    $i = 0;
    while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
        //create div
        echo "<div class='span2'>";
        //create link
        echo "<a href='index.php?page=showRecipe&id=" . $row['RecipeID'] . "'>";
        //get image data
        $img = mysql_query("SELECT ImageData FROM Photo WHERE RecipeID = " . $row['RecipeID'], $conn);
        //if image data exists...
        if ($imgData = mysql_fetch_row($img)) {
            echo '<img src="data:image/jpeg;base64,' . base64_encode($imgData[0]) .
            '" alt="' . $row['Title'] . '" title="' . $row['Title'] . '" class="thumbnail"/>';
        }
        echo "<h5>" . $row['Title'] . "</h5></a>";
        echo "<p>" . $row['Description'] . "</p></div>";
        //increment counter
        ++$i;
        if ($i == 3)
        //exit loop
            break;
    }
}
mysql_close($conn);
?>
                                </div>
                            </div>
                        </div>
                    </div> 

                </div>

                <!-------------------------------------right-sidebar---------------------------------------->
                <div class="span3">
                    <div class="main-content">
                        <h4>Recipe of the Day</h4>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse lobortis augue at leo bibendum suscipit. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.</p>
                        <p><a href="#">View comments/rating</a></p>
                    </div>
                    <div class="main-content">
                        <h4>Top Recipes</h4>
                        <ol class="top-recipes">
<?php
//connect
$dbhost = 'sfsuswe.com';
$dbuser = 'f12g31';
$dbpass = 'group31';
$conn = mysql_connect($dbhost, $dbuser, $dbpass);
if (!$conn) {
    echo "Could not connect";
} else {
    //select database
    mysql_select_db('student_f12g31');
    //create sql statement
    $sql = "SELECT * FROM Recipe ORDER BY Views DESC";
    $result = mysql_query($sql, $conn);
    //initiate counter
    $i = 0;
    while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
        //display recipe name
        echo "<li><a href='index.php?page=showRecipe&id=" . $row["RecipeID"] . "'>" .
        $row["Title"] . "</a></li>";
        ++$i;
        //if counter reaches 5
        if ($i == 5)
        //exit loop
            break;
    }
}
mysql_close($conn);
?>
                        </ol>
                    </div>
                </div>
            </div>
            <hr>

            <footer>
                <p class="footText">
                    &copy; AnyOneCanCook 2012
                    <a href="index.php?page=contactUS">Contact us</a> |
                    <a href="index.php?page=privacyPolicy">Privacy Policy</a>
                </p>
            </footer>
        </div>



    </div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap-transition.js"></script>
    <script src="assets/js/bootstrap-alert.js"></script>
    <script src="assets/js/bootstrap-modal.js"></script>
    <script src="assets/js/bootstrap-dropdown.js"></script>
    <script src="assets/js/bootstrap-scrollspy.js"></script>
    <script src="assets/js/bootstrap-tab.js"></script>
    <script src="assets/js/bootstrap-tooltip.js"></script>
    <script src="assets/js/bootstrap-popover.js"></script>
    <script src="assets/js/bootstrap-button.js"></script>
    <script src="assets/js/bootstrap-collapse.js"></script>
    <script src="assets/js/bootstrap-carousel.js"></script>
    <script src="assets/js/bootstrap-typeahead.js"></script>
    <script src="asssets/js/tommy.js"></script>

</body>
</html>
