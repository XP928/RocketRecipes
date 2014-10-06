<?php 
//if information  not passed by POST (search by ingredient)
if(isset($_POST['method']) && $_POST['method'] != "searchIngredient")
{
    //and if incorrect information in GET
    if(!isset($_GET['method']) || !isset($_GET['key']))
    {
        //display error
        echo "<h3>Invalid search!</h3>";
    }
}
else 
{
    //connect to database
    $dbhost = 'sfsuswe.com';
    $dbuser = 'f12g31';
    $dbpass = 'group31';
    $conn = mysql_connect($dbhost, $dbuser, $dbpass);

    //select database
    mysql_select_db('student_f12g31');

    //if information passed by GET
    if(isset($_GET['method']) || isset($_GET['key']))
    {
        //values from GET, passed through search
        $method = $_GET['method'];
        $key = $_GET['key'];

        //execute if regular search
        if($method === "search")
        {
            if($key === "")
            {
                echo "<h3>Invalid search!</h3>";
                return false;
            }
            //deliminate search key
            $search = explode(" ", $key);
            //begin sql query
            $sql = "SELECT * FROM Recipe WHERE Title";
            //cycle through array
            for($i = 0; $i < count( $search ); ++$i)
            {
                //if first value...
                if($i == 0)
                    $sql .= " LIKE '%" . $search[$i] . "%'";
                //otherwise
                else
                    $sql .= " OR Title LIKE '%" . $search[$i] . "%'";
            }
        }
        //execute if search by category
        else if($method === "cat")
        {
            $sql = "SELECT * FROM Recipe WHERE CatID = $key";
        }
        //execute if search by difficulty
        else if($method === "diff")
        {
            $sql = "SELECT * FROM Recipe WHERE Difficulty = '$key'";
        }
        //execute if search by user
        else if($method === "user")
        {
            $sql = "SELECT * FROM Recipe WHERE AuthorID = '$key'";
        }
    }
    //else if information passed by POST (search by ingredient)
    else if($_POST['method'] === "searchIngredient")
    {
        
        //values from POST, passed through search
        $key = $_POST['key'];
        
        //Get IngredID from Ingredients list
        $sql = 'SELECT IngredientID FROM Ingredients WHERE';
        for($i = 0; $i < count($key); ++$i)
        {
            if($i == 0) 
            {
                $sql .= " Name = '$key[$i]'";                
            }
            else
            {
                $sql .= " OR Name = '$key[$i]'";                
            }
        }
        
        //Use sql query to get ingredID in array
        $result = mysql_query($sql, $conn);
        while($row = mysql_fetch_row($result))
        {
            $ingredID[] = $row[0];
        }

        //Get recipeID from Ingredients useing ingredID array
        $sql='SELECT RecipeID FROM IngredientsList WHERE';
        for($i=0;$i < @count($ingredID);++$i)
        {
            if($i==0)
            {
                $sql.=" IngredientsID = '$ingredID[$i]'";
            }
            else
            {
                $sql .= " OR IngredientsID = '$ingredID[$i]'";                
            }
        }
        
        
        
        
        //Finally, use recipeID to get recipes
        $result = mysql_query($sql, $conn);
        while($row = @mysql_fetch_row($result))
        {
            $recipeID[] = $row[0];
        }
        //Set up select statement
        $sql='SELECT * FROM Recipe WHERE';
        for($i=0;$i <@count($recipeID);++$i)
        {
            if($i==0)
            {
                $sql.=" RecipeID = '$recipeID[$i]'";
            }
            else
            {
                $sql .= " OR RecipeID = '$recipeID[$i]'";                
            }
        }
        //get image
        
    }
    
    //else error
    else
    {
        echo "<h3>Invalid search!</h3>";
        return false;
    }
    
    $result = mysql_query($sql, $conn);
    
    $searchSuccess = false;
       
    while($disp = @mysql_fetch_array($result, MYSQL_ASSOC))
    {
        $searchSuccess = true;
        $img = mysql_query("SELECT ImageData FROM Photo WHERE RecipeID =" .$disp['RecipeID'], $conn);        //display image
echo "<table><tr>
            <td rowspan='5' width='125px'>";
        if($imgData = mysql_fetch_row($img))
            {
                echo "<img src='data:image/jpeg;base64," . base64_encode($imgData[0]) .
                "' alt='" . $disp['Title'] . "' title='" . $disp['Title'] . "' class='thumbnail'/>";
            }
        echo "</td>
            <td width='10px'></td> ";
        //display title
        echo "<td><div style='padding-bottom: 0px; padding-top: 0px;'><p><span style='font-size: 2em; font-weight=900;'><a href='index.php?page=showRecipe&id=$disp[RecipeID]'>$disp[Title]</a></span></td>";
        echo "</tr>
                <td></td>";
        
        //get author name
        $query = mysql_query("SELECT * FROM Users WHERE UserID = $disp[AuthorID]");
        $author = mysql_fetch_array($query, MYSQL_ASSOC);
        echo " <td>by: <a href='index.php?page=search&method=user&key=$disp[AuthorID]'>$author[Username]</a></td>
                </tr>";
        
        //display description
        echo "<tr>
            <td></td>
            <td colspan='2'>$disp[Description]</td>";
        
        //get category name
        $cat = mysql_query("SELECT * FROM Category WHERE CatID = $disp[CatID]");
        $catArr = mysql_fetch_array($cat, MYSQL_ASSOC);
        //display category and difficulty
        echo "<tr>
                <td></td>
                <td>Category: <a href='index.php?page=search&method=cat&key=$catArr[CatID]'>$catArr[CatName]</a></td>
              </tr>
              <td></td>
                <td>Difficulty: <a href='index.php?page=search&method=diff&key=$disp[Difficulty]'>$disp[Difficulty]</a></div></td>
                    <tr>
            </tr>
            <tr>
            <td colspan='3'><hr></td>
          </tr>
        </table>";
    }
    
    if(!$searchSuccess)
    {
        echo "<h3>Search returned no results. Please try again.</h3>";
    }
    
    mysql_close($conn);
}
?>