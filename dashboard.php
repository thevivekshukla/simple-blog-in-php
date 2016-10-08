<?php
include('includes/session.php');

if (!isset($admin_username) && !isset($admin_id))
	header('location: admin_login.php');
?>


<!DOCTYPE>
<html>

<head>
<title>Blog Dashboard</title>


<?php include('includes/bootstrap.php'); ?>

</head>


<body class="fluid-container bottom">

<div class="row">

<div class="col-md-10">
<div class="page-header bottom">
<h1>Admin Dashboard</h1>
</div>
</div>
<div class="col-md-2">
<div class="btn-group">
  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Menu <span class="caret"></span>
  </button>
  <ul class="dropdown-menu">
  <li><a href="dashboard.php">Dashboard</a></li>
    <li><a href="add_post.php">Add new post</a></li>
    <li><a href="view_post.php">View post</a></li>
    <li><a href="index.php" target="_blank">View Blog</a></li>
    <li role="separator" class="divider"></li>
    <li><a href="logout.php">Logout</a></li>
  </ul>
</div>
</div>

</div>


<div class="well">

<div class="row">
<div class="col-lg-3 col-md-4 col-sm-6 col-xm-12">
<p><a href="add_post.php" class="btn btn-info" type="button">Add New Post</a></p>
<p><a href="view_post.php" class="btn btn-info" type="button">View all posts</a></p>
</div>

<div class="col-lg-3 col-md-4 col-sm-6 col-xm-12" style="float:right">



<!-- page views to be here -->

</div>
</div>

</div>


</body>


</html>