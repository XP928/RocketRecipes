<?php
//connect to database
$dbhost = 'sfsuswe.com';
$dbuser = 'f12g31';
$dbpass = 'group31';
$conn = mysql_connect($dbhost, $dbuser, $dbpass);
if(! $conn )
{
    echo "Could not connect";
}
else
{
//recipe
$title = mysql_real_escape_string($_POST["title"]);
$timetomake = $_POST["totaltime"];
$category = $_POST["category"];
$difficulty = $_POST["difficulty"];
$descrip = $_POST["descrip"];

//ingredients
$ingredName = $_POST["ingredName"];
$ingredQty = $_POST["ingredQty"];
$ingredUnit = $_POST["ingredUnit"];

//directions
$direction = $_POST["direction"];

mysql_select_db('student_f12g31');

//get user id
$sql = "SELECT UserID FROM Users WHERE Username = '" . $_SESSION['username'] . "'";
$getID = mysql_query($sql, $conn);
$userIDnum = mysql_fetch_array($getID, MYSQLI_ASSOC);

//create recipe in database
$sql = "INSERT INTO Recipe ".
       "(AuthorID, Title, TimeToMake, CatID, Difficulty, Description) ".
       "VALUES('".mysql_real_escape_string($userIDnum['UserID'])."', '".mysql_real_escape_string($title)."', '$timetomake', '$category', '$difficulty', '".mysql_real_escape_string($descrip)."')";
$retval = mysql_query( $sql, $conn );
//if query fails
if(! $retval )
{
    echo "Could not enter data!";
    return false;
}

//get id of recipe
$recID = mysql_insert_id();

for($i = 0; $i < count( $ingredName ); ++$i)
{
    $ingredID = 0;
    //get ingredient row from database
    $sql = "SELECT * FROM Ingredients WHERE Name = $ingredName[$i]";
    $result = mysql_query($sql, $conn);

    //add ingredient if it does not exist
    if(!$result)
    {
        $sql = "INSERT INTO Ingredients ".
       "( Name ) ".
       "VALUES('" . mysql_real_escape_string($ingredName[$i]) ."')";
        $result = mysql_query($sql, $conn);
        $ingredID = mysql_insert_id();
    }
    //get ingredient id if it does exist
    else
    {
        $resultArr = @mysql_fetch_array($result, MYSQL_ASSOC);
        $ingredID = $resultArr["IngredientID"];
    }
    //insert ingredient into ingredient list
    $sql = "INSERT INTO IngredientsList ".
            "( RecipeID, IngredientsID, IngredientAmount, IngredientMeasure ) ".
            "VALUES ( '$recID', '$ingredID', '$ingredQty[$i]', '$ingredUnit[$i]')";
    $result = mysql_query($sql, $conn);
}

//add directions to database
for($i = 0; $i < count( $direction ); ++$i)
{
    $sql = "INSERT INTO DescriptionSteps ".
            "( RecipeID, StepNumber, StepInfo ) ".
            "VALUES ( '$recID', '" . ($i + 1) . "', '". mysql_real_escape_string($direction[$i]) ."')";
    $result = mysql_query($sql, $conn);
}

//add image to database
if (isset($_FILES['image']) && $_FILES['image']['size'] > 0 && $_FILES['image']['size'] < 3000000) 
{ 
    // temporary file name stored on the server
    $tmpName = $_FILES['image']['tmp_name'];  

    // read the file 
    $fp = fopen($tmpName, 'r');
    $data = fread($fp, filesize($tmpName));
    $data = addslashes($data);
    fclose($fp);

    // create the query and insert
    // into our database.
    $query = "INSERT INTO Photo ";
    $query .= "(ImageData, ImageName, RecipeID) VALUES ('$data', '$title', '$recID')";
    $results = @mysql_query($query, $conn);


    // print results
    $msg = '<p class="center">Your image has been uploaded.</p>';
}
else 
{
    $msg = '<p class="center">No image selected/uploaded</p>';
}

mysql_close($conn);
$message = '<h2 class="center">Your recipe has been successfully added!</h2>'.
    '<h4 class="center">Your recipe is now available for everyone to see!</h4>';
echo $message;
echo $msg;
}
?>
