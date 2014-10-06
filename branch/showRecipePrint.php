<!DOCTYPE html>
<html>
    <head>
        <title>Anyone Can Cook</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
    </head>
    <body>
        <?php 
        if(!isset($_GET['id']))
        {
            echo "<h3>Invalid recipe ID!</h3>";
        }
        else 
        {
            //connect to database
            $dbhost = 'sfsuswe.com';
            $dbuser = 'f12g31';
            $dbpass = 'group31';
            $conn = mysql_connect($dbhost, $dbuser, $dbpass);

            mysql_select_db('student_f12g31');

            //get recipe id
            $recID = $_GET['id'];

            //get recipe data from database
            $sql = "SELECT * FROM Recipe WHERE RecipeID = $recID";
            $result = mysql_query($sql, $conn);

            //if no result, then error
            if (!$result) 
            {
                echo "<h3>Invalid recipe ID!</h3>";
                return false;
            }
            //otherwise...
            else
            {
            //put recipe data into array
            $recipeArray = mysql_fetch_array($result, MYSQL_ASSOC);

            ?>
        <table>
            <tr>
                <td colspan="2">
                    <h2><?php 
                        //display recipe title
                        echo $recipeArray['Title']?>
                    </h2>
                    <?php
                    //get and display author name
                    $query = mysql_query("SELECT * FROM Users WHERE UserID = $recipeArray[AuthorID]");
                    $author = mysql_fetch_array($query, MYSQL_ASSOC);
                    echo "by: $author[Username]</p>";
                    ?>
                </td>
            </tr>
            <tr>
                <td style="padding-right: 1em; width: 200px; vertical-align: top;" rowspan="2">
                    <?php
                    //get image data
                    $query = mysql_query("SELECT * FROM Photo WHERE RecipeID='".$recID."'");
                    //if there is an image
                    if($row = mysql_fetch_array($query))
                    {
                        $content = $row['ImageData'];

                        //display image
                        echo '<div style="max-height: 300px; width: 200px">';
                        echo '<img src="data:image/jpeg;base64,' . base64_encode( $row['ImageData'] ) . '" 
                            alt="' . $recipeArray['Title'] . '" title="' . $recipeArray['Title'] . '" 
                                style="max-width: 100%; max-height: 100%; margin: auto; margin-bottom: 8px; display: block; filter: gray; -webkit-filter: grayscale(100%)"/>';
                        echo "</div>";
                    }
                    ?>

                    <label>Total time: <?php echo "$recipeArray[TimeToMake]"?></label><br>

                    <label>Category: <?php 
                        $result = mysql_query("SELECT CatName FROM Category WHERE CatID = $recipeArray[CatID]");
                        $cat = mysql_fetch_array($result, MYSQL_ASSOC);
                        echo $cat['CatName'] ?></label><br>

                    <label>Difficulty: <?php echo $recipeArray['Difficulty'] ?></label>

                </td>

                <td><h3>Ingredients list</h3>
                     <table>
                        <?php
                        //get ingrdient list from database
                        $sql = "SELECT * FROM IngredientsList WHERE RecipeID = $recID";
                        $result = mysql_query($sql, $conn);

                        //loop through the array of ingrdients
                         while($row = mysql_fetch_array($result, MYSQL_ASSOC))
                        {
                            //get ingredient names from database...
                            $sql = "SELECT * FROM Ingredients WHERE IngredientID = $row[IngredientsID]";
                            $retval = mysql_query($sql, $conn);
                            //...and place into array
                            $ingredients = mysql_fetch_array($retval, MYSQL_ASSOC);

                            //display ingredient amount, unit of measure, and name
                            echo "<tr><td>$row[IngredientAmount] $row[IngredientMeasure] $ingredients[Name] </td></tr>";
                        }
                        ?>
                     </table>
                    <hr>
                </td>
            </tr>
            <tr>
                <td style="width: 6in">
                    <h3>Description</h3>
                    <?php echo "$recipeArray[Description]" ?>
                    
                    <hr>
                    
                    <h3>Directions</h3>
                    <?php
                    //get directions from database
                    $sql = "SELECT * FROM DescriptionSteps WHERE RecipeID = $recID";
                    $result = mysql_query($sql, $conn);
                    //loop through array of descriptions
                     while($row = mysql_fetch_array($result, MYSQL_ASSOC))
                    {
                        //display directions
                        echo "<h4>Step $row[StepNumber]</h4>" .
                                "<p>$row[StepInfo]</p>";
                    }
                    ?>
                    </td>
                </tr>
            </tr>

            </table>
        <?php
            }
        }
        ?>
    </body>
</html>