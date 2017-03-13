<?php
//signin.php
include 'code/connect.php';
include 'header.php';

$cat_id = 0;
if(isset($_GET['id']))
{
	$cat_id=mysql_real_escape_string($_GET['id']);
}
if($cat_id > 0)
{
	$result = mysqli_query($dbc,"CALL cat_by_id_sp('$cat_id')");
	if(!$result)
	{
		echo "There was a problem, please try again later";
	}

	else
	{
		$num_rows = $result->num_rows;

		if($num_rows > 0)
		{
			while($row = mysqli_fetch_array($result))
			{
				$cat_name = $row['cat_name'];
				$cat_description = $row['cat_description'];
			}
		}
	}
	echo '<div class="col-md-8">';
	echo "<h2>" . $cat_name . "</h2>";
	echo "<h3>" . $cat_description . "</h3>";
	echo '</div>';
	echo '<div class="col-md-4">';
	echo '<a class="btn btn-danger" href="create_cat.php">Create New category</a><br>';
	echo '</div>';
	echo "<br><br>";
	$dbc->next_result();
	$result = mysqli_query($dbc,"CALL topics_for_cat_sp('$cat_id')");
	$num_rows = $result->num_rows;
	if($num_rows > 0)
	{
		echo '<br><table class="table">
				<thead>
					<tr>
						<th>Topic Name</th>
						<th>By</th>
						<th>Date</th>
					</tr>
				</thead>
				<tbody>';
		while($row = mysqli_fetch_array($result))
		{
			echo '<tr>
					<td><a href="topic.php?id='. $row['topic_id'] . '">' . $row['topic_subject'] . '</td>
					<td>' . $row['user_name'] . '</td>
					<td>' . date('d-m-Y', strtotime($row['topic_date'])) . '</td>
				</tr>';
		}

		echo '</tbody>
		</table>';
		
	}
	else
	{
		echo "No Topics for this Category";
	}
	echo '<br><br><a class="btn btn-danger" href="create_topic.php?cat_id=' . $cat_id . '">Create New Topic in this Category</a><br>';	
	
}	
else
{
	echo "No Category ID";
}

include 'footer.php'
?>