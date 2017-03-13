<?php
//create_cat.php
include 'code/connect.php';
include 'header.php';
 
$result = mysqli_query($dbc,"CALL categories_sp()");         
$row_count = $result->num_rows; 
if(!$result)
{
    echo 'The categories could not be displayed, please try again later.';
}
else
{
    if($row_count == 0)
    {
        echo 'No categories defined yet.';
    }
    else
    {
        //prepare the table
        echo '<table class="table">
        		<thead>
	              <tr>
	                <th>Category</th>
	                <th>Last topic</th>
	              </tr>
	            </thead>
	            <tbody>'; 
             
        while($row = mysqli_fetch_array($result))
        {               
            echo '<tr>';
                echo '<td class="leftpart">';
                    echo '<h3><a href="category.php?id=' . $row['cat_id'] .' ">' . $row['cat_name'] . '</a></h3>' . $row['cat_description'];
                echo '</td>';
                echo '<td class="rightpart">';
                            echo '<a href="topic.php?id=">Topic subject</a> at 10-10';
                echo '</td>';
            echo '</tr>';
        }
        echo "</tbody>
        </table>";
    }
}
include 'footer.php';
?>