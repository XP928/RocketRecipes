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
        <form enctype="multipart/form-data" action="test_photoAdded.php" method="post" name="changer">
            <input name="MAX_FILE_SIZE" value="102400" type="hidden">
            <input name="image" accept="image/jpeg" type="file">
            <input value="Submit" type="submit">
        </form>
    </body>
</html>