<?php
//signin.php
include 'code/connect.php';
include 'header.php';

$topic_id = 0;
if(isset($_GET['id']))
{
	$topic_id = mysql_real_escape_string($_GET['id']);
}
if($topic_id > 0)
{
	echo "Topic ID: " .$topic_id;
	$result = mysqli_query($dbc,"CALL get_topic_sp('$topic_id')");
	if(!$result)
	{
		echo "There was a Problem, Please Try Again Later!";
	}
	else
	{
		$row_count = $result->num_rows; 
		if($row_count > 0)
		{
			echo '<table class="table">
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
				$topic_subject = $row['topic_subject'];	
				$topic_date = $row['topic_date'];	
				$topic_cat = $row['topic_cat'];	
				$topic_by = $row['topic_by'];
				echo '<tr>
						<td>' . $row['topic_subject'] . '</td>
						<td>' . $row['user_name'] . '</td>
						<td>' . $row['topic_date'] . '</td>
					</tr>';	
			}
			echo '</tbody>
		</table>';
		echo '<a class="btn btn-danger" href="create_topic.php?cat_id=' . $topic_cat . '">Create New Topic in this Category</a><br>';	
		}
	}

	
	$dbc->next_result();
	$result = mysqli_query($dbc,"CALL get_posts_sp('$topic_id')");
	if(!$result)
	{
		echo "There was a Problem, Please Try Again Later!";
	}
	else
	{
		$row_count = $result->num_rows; 
		if($row_count > 0)
		{
			echo "<h2>Chat Posts</h2>";
			echo '<table class="table">
					<thead>
						<tr>
							<th>Topic Name</th>
							<th>Post Content</th>
							<th>Post By</th>
							<th>Post Date</th>
						</tr>
					</thead>
				<tbody>';
			while($row = mysqli_fetch_array($result))
			{
				
				echo '<tr>
						<td>' . $row['post_topic'] . '</td>
						<td>' . $row['post_content'] . '</td>
						<td>' . $row['user_name'] . '</td>
						<td>' . date('d-m-Y', strtotime($row['post_date'])) . '</td>
					</tr>';	
			}
			echo '</tbody>
		</table>';

		echo '<a class="btn btn-danger" href="create_topic.php?cat_id=' . $topic_cat . '">Create New Topic in this Category</a>';	
		}
	}	
	
		echo '<a class="btn btn-primary btn-large" data-toggle="modal" data-target="#enquiry-modal">Make an Comment About this Post</a>';
}	
else
{
	echo "No Topic ID";
}
?>
<div class="modal fade" id="enquiry-modal" tabindex="-1" role="dialog" aria-labelledby="enquiry-form-modal" aria-hidden="true">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h3>Make Comments</h3>
        </div>
        <div class="modal-body">
          
          <form method="post" action="reply.php?id=<?php echo $topic_id ?>">
    		<textarea name="reply-content" rows="10" class="form-control"></textarea>
        </div>
        <div class="modal-footer">
        <input type="submit" class="btn btn-success" value="Submit Comments">
          <button type="submit" class="btn btn-default btn-default pull-left" data-dismiss="modal">Cancel</button>
          </form>
        </div>
      </div>
    </div>
  </div> 
  


<?php
include 'footer.php'
?>