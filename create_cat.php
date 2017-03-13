<?php
//create_cat.php
include 'code/connect.php';
include 'header.php';


 
if($_SERVER['REQUEST_METHOD'] != 'POST')
{
    //the form hasn't been posted yet, display it
    echo '<form method="post" action="">
        Category name: <input type="text" name="cat_name" class="form-control" minlength="4" maxlength="50"/><br>
        Category description: <textarea name="cat_description"  class="form-control"/></textarea><br>
        <input type="submit" value="Add Category" class="btn btn-primary" /><br>
     </form>';
}
else
{
    //the form has been posted, so save it
    if(isset($_POST['cat_name']) AND isset($_POST['cat_description']))
    {     

        $cat_name = mysql_real_escape_string($_POST['cat_name']);
        $cat_description = mysql_real_escape_string($_POST['cat_description']);

        $result = mysqli_query($dbc,"CALL new_cat_sp('$cat_name', '$cat_description')");
        if(!$result)
        {
            //something went wrong, display the error
            echo 'Error' . mysql_error();
        }
        else
        {
            echo '<h2>New category successfully added.</h2>';
        }
    }
}
include 'footer.php';
?>