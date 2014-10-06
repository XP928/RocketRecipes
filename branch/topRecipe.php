<!--
Group: 31
Edited by: Tommy
last date edited: 11-15-2012
Description:
Shows the top recipes
-->

<table>
<?php
$dbhost = 'sfsuswe.com';
$dbuser = 'f12g31';
$dbpass = 'group31';
$conn = mysql_connect($dbhost, $dbuser, $dbpass);

//select database
mysql_select_db('student_f12g31');

//create sql statement
$sql = "SELECT * FROM Recipe ORDER BY Views DESC";
$result = mysql_query($sql, $conn);
//initiate counter
$i = 0;
while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) 
{
    $img = mysql_query("SELECT ImageData FROM Photo WHERE RecipeID = " . $row['RecipeID'], $conn);
    //display recipe name
    echo "<tr>
            <td rowspan='3' width='125px'>";
            if($imgData = mysql_fetch_row($img))
            {
                echo "<img src='data:image/jpeg;base64," . base64_encode($imgData[0]) .
                "' alt='" . $row['Title'] . "' title='" . $row['Title'] . "' class='thumbnail'/>";
            }
            echo "</td>
            <td width='10px'></td>
            <td><h3><a href='index.php?page=showRecipe&id=" . $row['RecipeID'] . "'>" . $row['Title'] . "</a></h3></td>
          </tr>
          <tr>
            <td></td>";
            //get and display author name
            $query = mysql_query("SELECT * FROM Users WHERE UserID = " . $row['AuthorID']);
            $author = mysql_fetch_array($query, MYSQL_ASSOC);
            echo "<td>by: <a href='index.php?page=search&method=user&key=" . $row['AuthorID'] . "'>" . $author['Username'] . "</a></td>
          </tr>
          <tr>
          <td></td>
            <td colspan='2'>" . $row['Description'] . "</td>
          </tr>
          <tr>
            <td colspan='3'><hr></td>
          </tr>";
    ++$i;
    //if counter reaches 10
    if ($i == 10)
    //exit loop
        break;
}
?>
</table>