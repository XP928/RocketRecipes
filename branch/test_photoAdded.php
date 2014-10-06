<!DOCTYPE html>
<!------------------------------------
--------------------------------------
--                                  --
--      THIS IS A TEST PAGE         --
--                                  --
--      USE THIS FOR NOW IF YOU     --
--      NEED TO UPLOAD A PHOTO      --
--                                  --
--------------------------------------
-------------------------------------->
<html>
    <head>

    </head>
    <body>
        <?php
        // Create MySQL login values and 
        // set them to your login information.
        $username = "f12g31";
        $password = "group31";
        $host = "sfsuswe.com";
        $database = "student_f12g31";

        // Make the connect to MySQL or die
        // and display an error.
        $link = mysql_connect($host, $username, $password);

        // Select your database
        mysql_select_db($database);

        // Make sure the user actually 
        // selected and uploaded a file
        if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {

            // Temporary file name stored on the server
            $tmpName = $_FILES['image']['tmp_name'];

            // Read the file 
            $fp = fopen($tmpName, 'r');
            $data = fread($fp, filesize($tmpName));
            $data = addslashes($data);
            fclose($fp);

            // Create the query and insert
            // into our database.
            $query = "INSERT INTO Photo ";
            $query .= "(ImageData) VALUES ('$data')";
            $results = mysql_query($query, $link);

            $id = mysql_insert_id();

            // Print results
            print "Thank you, your file has been uploaded.";
        } else {
            print "No image selected/uploaded";
        }

        // Close our MySQL Link
        mysql_close($link);

        //////////////////////////

        $username = "f12g31";
        $password = "group31";
        $host = "sfsuswe.com";
        $database = "student_f12g31";

        mysql_connect($host, $username, $password) or die("Can not connect to database: " . mysql_error());

        mysql_select_db($database) or die("Can not select the database: " . mysql_error());

        if (!isset($id) || empty($id) || !is_int($id)) {
            die("Please select your image!");
        } else {

            $query = mysql_query("SELECT * FROM Photo WHERE ImageID='" . $id . "'");
            $row = mysql_fetch_array($query);
            $content = $row['ImageData'];

            //header('Content-type: image/jpg');
            echo '<img src="data:image/jpeg;base64,' . base64_encode($row['ImageData']) . '" />';
        }
        ?>
    </body>
</html>