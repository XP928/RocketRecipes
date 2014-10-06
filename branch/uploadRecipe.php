<script type="text/javascript">
//variables for row creation
var ingredCtr = 1;
var descripCtr = 1;

//adds a row for ingredients
function addRowToTable()
{
    //if max number of fields not reached
    if(ingredCtr < 15)
    {
        document.getElementById('rmving').style.display = "inline";
        
        //get table object
        var tbl = document.getElementById('ingredTable');
        // get length of table
        var lastRow = tbl.rows.length;
        // if there's no header row in the table, then iteration = lastRow + 1
        var iteration = lastRow;
        //  var iteration = lastRow + 1;
        var row = tbl.insertRow(lastRow);

        //insert field for ingredient name
        var cell0 = row.insertCell(0);
        var el = document.createElement('input');
        el.type = 'text';
        el.name = 'ingredName[]';
        el.className = "span2";
        el.setAttribute('placeholder', "Enter name");
        cell0.appendChild(el); 

        //insert field for ingredient quantity
        var cell1 = row.insertCell(1);
        var el = document.createElement('input');
        el.type = 'text';
        el.name = 'ingredQty[]';
        el.className = "span1";
        el.setAttribute('placeholder', "Qty");
        cell1.appendChild(el);

        //insert field for ingredient unit of measure
        var cell2 = row.insertCell(2);
        var el = document.createElement('input');
        el.type = 'text';
        el.name = 'ingredUnit[]';
        el.className = "span1";
        el.setAttribute('placeholder', "unit");
        cell2.appendChild(el);
        
        //increase row counter
        ingredCtr++;
    }
    else
    {
        alert("Maximum number of ingredients reached!");
    }
}

//adds a row for directions
function addRowToTable2()
{
    //if maximum number of fields not reached
    if(descripCtr < 15)
    {
        document.getElementById('rmvdir').style.display = "inline";
        
        //get table object
        var tbl = document.getElementById('direcTable');
        var lastRow = tbl.rows.length;
        // if there's no header row in the table, then iteration = lastRow + 1
        var iteration = lastRow;
        //  var iteration = lastRow + 1;
        var row = tbl.insertRow(lastRow);

        //insert field
        var cell0 = row.insertCell(0);
        var el = document.createElement('textarea');
        el.name = 'direction[]';
        el.className = "span3";
        el.setAttribute('placeholder', "Enter step");
        el.setAttribute('rows', "4");
        cell0.appendChild(el);
        
        //increase row counter
        descripCtr++;
    }
    else
    {
        alert("Maximum number of steps reached!");
    }
}

//removes last row from ingredients table
function removeRowFromTable()
{
    if(ingredCtr > 1)
    {
        var tbl = document.getElementById('ingredTable');
        var lastRow = tbl.rows.length;
        //  var iteration = lastRow + 1;
        tbl.deleteRow(-1);
        ingredCtr--;
    }
    //hide remove button if one field left
    if(ingredCtr === 1)
    {
        document.getElementById('rmving').style.display = "none";
    }
}

//removes last row from directions table
function removeRowFromTable2()
{
    if(descripCtr > 1)
    {
        var tbl = document.getElementById('direcTable');
        var lastRow = tbl.rows.length;
        //  var iteration = lastRow + 1;
        tbl.deleteRow(-1);
        descripCtr--;
    }
    //hide remove button if one field left
    if(descripCtr === 1)
    {
        document.getElementById('rmvdir').style.display = "none";
    }
}

//handles errors from the form
function checkForm()
{
    //clear error text, if any
    document.getElementById("errorText").innerHTML = "";
    //set 'error' to false
    error = false;
    //declare variables for form fields
    var title = document.forms["upload"]["title"].value;
    var totaltime = document.forms["upload"]["totaltime"].value;
    var descrip = document.forms["upload"]["descrip"].value;
    var cat = document.forms["upload"]["category"].value;
    var diff = document.forms["upload"]["difficulty"].value;
    var ingredName = document.getElementsByName("ingredName[]");
    var direction = document.getElementsByName("direction[]");
    
    //if title is blank
    if(title == null || title == "")
        error = true;
    //if description is blank
    if(descrip == null || descrip == "")
        error = true;
    //if time to make is blank
    if(totaltime == null || totaltime == "")
        error = true;
    //if a category is not selected
    if(cat == "0")
        error = true;
    //if difficulty is not selected
    if(diff == "0")
        error = true;
    //loop through ingredients
    for(var i = 0; i < ingredName.length; i++)
    {
        //if any ingredient name is blank
        if(ingredName[i].value == "" || ingredName[i].value == null)
            error = true;
        //ingredient unit of measure can be left out
        //for instances of items like a whole onion 
        //or eggs that do not have a unit of measure
    }
    //loop through directions
    for(var i = 0; i < direction.length; i++)
    {
        //if any direction is blank
        if(direction[i].value == "" || direction[i].value == null)
            error = true;
    }
    //prepare message for error field
    if(error)
        var msg = "All form fields need to be filled in and a category and difficulty must be selected.";
    else
        var msg = "";
    
    //validate file type
    var fup = document.getElementById('imgUpload');
    var fileName = fup.value;
    //get file extension
    var ext = fileName.substring(fileName.lastIndexOf('.') + 1);
    //check file extension
    if(!(fileName == "" || ext == "gif" || ext == "GIF" || ext == "JPEG" || ext == "jpeg" || ext == "jpg" || ext == "JPG" || ext == "png" || ext == "PNG"))
    {
        alert("Upload GIF , PNG or JPG images only");
        fup.focus();
        error = true;
    }

    //if any error is returned...
    if(error)
    {
        //display message and do not post data
        errorText.innerHTML = msg;
        return false;
    }   
}
</script>
<style>.addform-js { vertical-align: top; }</style>

<?php

if ( isset($_SESSION['signedin']) && $_SESSION['signedin'] == '1' ) 
{
    echo '
    <form action="index.php?page=addRecipe" method="post" name="upload" onsubmit="return checkForm()" enctype="multipart/form-data">
    <table>
        <tr>
            <td colspan="5"><h3>Upload a recipe!</h3></td>
        </tr>
        <tr>
            <td colspan="5"><span id="errorText" style="color: red"></span></td>
        </tr>
        <tr>
            <td><label>Recipe name:</label></td>
            <td><input type="text" class="span3" name="title" id="title"/></td>
        </tr>
        <tr>
            <td><label>Description:</label></td>
            <td>
                <textarea rows="4" class="span3" name="descrip" id="descrip" placeholder="Enter a description of the dish"></textarea>
            </td>
        </tr>
        <tr>
            <td><label>Total Time:</label></td>
            <td><input type="text" class="span2" name="totaltime" id="totaltime"/></td>
        </tr>
        <tr>
            <td>
                <label>Category:</label>
            </td>
            <td>
                <select name="category">
                    <option value="0" selected>-------------------------</option>
                    <option value="1">Pasta</option>
                    <option value="2">Steak</option>
                    <option value="3">Poultry</option>
                    <option value="4">Vegetarian</option>
                    <option value="5">Fish</option>
                    <option value="6">Pork</option>
                    <option value="7">Salad</option>
                    <option value="8">Sandwich</option>
                    <option value="9">Soup</option>
                    <option value="10">Dessert</option>
                    <option value="11">Other</option>
                </select>
            </td>
        </tr>
        <tr>
            <td><label>Difficulty:</label></td>
            <td>
                <select name="difficulty">
                    <option value="0" selected>-------------------------</option>
                    <option value="Easy">Easy</option>
                    <option value="Mild">Mild</option>
                    <option value="Moderate">Moderate</option>
                    <option value="Hard">Hard</option>
                    <option value="Expert">Expert</option>
                </select>
            </td>
        </tr>
        <tr>
            <td class="addform-js"><label>Add ingredients:</label></td>
            <td>
            <table id="ingredTable">
                <tr>
                    <td><input name="ingredName[]" type="text" class="span2" placeholder="Enter name"/></td>
                    <td><input name="ingredQty[]" type="text" class="span1" placeholder="Qty"/></td>
                    <td><input name="ingredUnit[]" type="text" class="span1" placeholder="unit"/></td>
                </tr>
            </table>
            </td>
            <td class="addform-js">
                <input type="button" class="btn btn-primary" onclick="addRowToTable()" value="Add">
                <input type="button" id="rmving" class="btn btn-danger" onclick="removeRowFromTable()" style="display: none;" value="Remove">
            </td>
        </tr>
        <tr>
            <td class="addform-js"><label>Directions:</label></td>
            <td>
                <table id="direcTable">
                    <tr>
                        <td>
                        <textarea name="direction[]" rows="4" class="span3" placeholder="Enter step"/></textarea>
                        </td>
                    </tr>
                </table>
            </td>
            <td class="addform-js">
                <input type="button" class="btn btn-primary" onclick="addRowToTable2()" value="Add">
                <input type="button" id="rmvdir" class="btn btn-danger" onclick="removeRowFromTable2()" style="display: none;" value="Remove">
            </td>
        </tr>
        <tr>
            <td><label>Upload Image</label></td>
            <td>
                <input type="hidden" name="MAX_FILE_SIZE" value="2000000" />
                <input name="image" type="file" id="imgUpload" class="span3" />
            </td>
        </tr>
        <tr>
            <td colspan="3"><hr/></td>

        </tr>
        <tr>
            <td>
                <input type="reset" class="btn btn-danger" value="Reset All">
            </td>
            <td colspan="4" class="tdright">
                <input type="submit" class="btn btn-primary" value="Upload">
            </td>
        </tr>
    </table>          
    </form>';
} 
else 
{
  echo '<h3>You need to be logged in to upload a recipe!</h3>';
  echo '<h4>Please log in, or <a href="index.php?page=signup">click here</a> to become a user!</h4>';
}
?>