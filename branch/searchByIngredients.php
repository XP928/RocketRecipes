<script type="text/javascript">
var ingredMAX= 1;

//add Rows of ingredients, like inn uploadRecipe
function addRowToTable()
{
    //if max number of fields not reached
    if(ingredMAX< 15)
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
        el.name = 'key[]';
        el.className = "span3";
        el.setAttribute('placeholder', "Enter name");
        cell0.appendChild(el);         
        //increase row counter
        ingredMAX++;
    }
    else
    {
        alert("Maximum number of ingredients reached!");
    }
}

//removes last ingredient that was added
function removeRowFromTable()
{
    if(ingredMAX > 1)
    {
        var tbl = document.getElementById('ingredTable');
        var lastRow = tbl.rows.length;
        //  var iteration = lastRow + 1;
        tbl.deleteRow(-1);
        ingredMAX--;
    }
    //hide remove button if one field left
    if(ingredMAX === 1)
    {
        document.getElementById('rmving').style.display = "none";
    }
}

function checkForm()
{
    //clear error text, if any
    document.getElementById("errorText").innerHTML = "";
    //set 'error' to false
    error = false;
    var ingredName = document.getElementsByName("key[]");
    
    for(var i = 0; i < ingredName.length; i++)
    {
        //if any ingredient name is blank
        if(ingredName[i].value == "" || ingredName[i].value == null)
            error = true;
        //ingredient unit of measure can be left out
        //for instances of items like a whole onion 
        //or eggs that do not have a unit of measure
    }
 
    if(error)
        var msg="Ingredient field(s) cannot be empty!"
    else
        var msg="";
    
    
    if(error)
    {
        //display message and do not post data
        errorText.innerHTML = msg;
        return false;
    } 
}

</script>
<style>.addform-js { vertical-align: top; }</style>
<form action="index.php?page=search" method="post" name="searchByIngred" onsubmit="return checkForm()">
<table>
    <tr>
        <td class="tdmiddle"><h3>Search By Ingredients</h3></td>
        <td></td>
    </tr>
    <tr>
        <td class="addform-js"><label>Ingredients to be included: </label></td>
        <td></td>
    </tr>
    <tr>
        <td>
            <input type="hidden" name="page" value="search">
            <input type="hidden" name="method" value="searchIngredient">
            <table id="ingredTable">
                <tr>
                    <td><input name="key[]" type="text" class="span3" placeholder="Enter Name"/></td>
                </tr>
            </table>
        </td>
        <td class="addform-js">
            <input type="button" class="btn btn-primary" onclick="addRowToTable()" value="Add">
            <input type="button" id="rmving" class="btn btn-danger" onclick="removeRowFromTable()" style="display: none;" value="Remove">
        </td>
    </tr>         
    <tr>
        <td class="tdmiddle"><button type="submit" class="btn btn-primary span2">Search</button></td>
        <td></td>
    </tr>   
</table>
</form> 