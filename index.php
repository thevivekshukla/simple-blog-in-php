<?php

if (!isset($_GET['post']))
{
	echo '<!DOCTYPE>';
	echo '<html>';

	echo '<head>';

	echo '<title>MyBlog</title>';

	include('includes/bootstrap.php'); 
	include('includes/convars.php');

	echo '</head>';

	echo '<body class="fluid-container bottom">';

	echo '<div class="page-header">';
	echo '<h1>MyBlog</h1>';
	echo '</div>';

	echo '<div class="row">';
	echo '<div class="col-md-8">';

	$initial_count = 0;
	$num_posts = 4;

	if (isset($_GET['page']) && is_numeric($_GET['page']))
		$page = trim($_GET['page']);
	else
		$page = 1;

	$initial_count = ($page * $num_posts) - $num_posts;

	$dbc = mysqli_connect(HOST, USER, PASSWORD, DBNAME) or die(mysqli_error());
	$query = "SELECT * FROM blog_post ORDER BY post_date DESC LIMIT $initial_count, $num_posts";
	$result = mysqli_query($dbc, $query);

	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		echo '<div class="well">';
		echo '<h3><a href="index.php?post='. $row['post_id'] .'&amp;title='. $row['post_title'] .'">'. $row['post_title'] .'</a></h3>';
		echo '<br/>';
		echo '<p style="font-family:Georgia; font-size:16">'. substr($row['post_content'], 0, 300) .'....</p>';
		echo '<b>Tags:</b><span class="label label-default">'. $row['post_tag'] .'</span><br/>';
		echo $row['post_date'];
		echo '</div>';
	}

	//for pagination
	$query = "SELECT COUNT(post_id) AS num_rows FROM blog_post";
	$result = mysqli_query($dbc, $query);
	$row = mysqli_fetch_object($result);
	$count = $row->num_rows;

	$tabs = ceil($count / $num_posts);

	if ($tabs > 1)
	{
		echo '<ul class="pagination">';
		for ($i=1; $i<=$tabs; $i++)
		{
			echo '<li';
			if ($page == $i)
				echo ' class="active"';
			echo '><a href="index.php?page='. $i .'">'. $i .'</a></li>';
		}
		echo '</ul>';
	}
	mysqli_close($dbc);

}//showing all post part
else if (isset($_GET['post']) && is_numeric($_GET['post']))	//showing full post when clicked
{
	echo '<!DOCTYPE>';
	echo '<html>';

	echo '<head>';

	echo '<title>MyBlog</title>';

	include('includes/bootstrap.php'); 
	include('includes/convars.php');


	$dbc = mysqli_connect(HOST, USER, PASSWORD, DBNAME) or die(mysqli_error());
	$post_id = trim($_GET['post']);

	$query = "SELECT * FROM blog_post WHERE post_id=$post_id";
	$result = mysqli_query($dbc, $query) or die(mysqli_error());
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

	echo '<meta charset="UTF-8">';
	echo '<meta name="description" content="'. $row['post_description'] .'">';
	echo '<meta name="keywords" content="'. $row['post_tag'] .'">';

	echo '</head>';

	echo '<body class="fluid-container bottom">';

	echo '<div class="row">';

	echo '<div class="col-md-10">';
	echo '<div class="page-header">';
	echo '<h1>MyBlog</h1>';
	echo '</div>';
	echo '</div>';

	echo '<div class="col-md-2">';
	echo '<a href="index.php" role="button" class="btn btn-default">Home</a>';
	echo '</div>';

	echo '</div>';			//closing row division
	
	echo '<div class="row">';
	echo '<div class="col-md-10">';
	echo '<div class="well">';

	echo '<h2><p style="color:#1296c4">'. $row['post_title'] .'</p></h2>';
	echo '<span style="float:right">'. $row['post_date'] .'</span>';
	echo '<br/><br/>';
	echo '<p style="font-family:Georgia; font-size:16">'. $row['post_content'] .'</p>';
	echo '<br/>';
	echo '<p><b>Tags:</b>'. $row['post_tag'] .'</p>';

	echo '</div>';
	echo '</div>';
	echo '</div>';

	mysqli_close($dbc);

}

echo '</div>';
echo '</div>';

echo '</body>';

echo '</html>';

?>