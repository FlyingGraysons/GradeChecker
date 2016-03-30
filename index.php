<?php
	include('php/protect_page.php');
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>GradeChecker</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="general.css">
</head>
<body>

	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<a class="navbar-brand" href="#">HMW Grades</a>
			</div>
			<div>
				<ul class="nav navbar-nav" id="nav">
					<li class="active tab tabby" id="home"><a href="#">Home</a></li>
				</ul>
				<ul class="nav navbar-nav navbar-right" id=logoutArea>
					<li class="dropdown">
						<a class="dropdown-toggle" href="#" data-toggle="dropdown">Add Parent<strong class="caret"></strong></a>
						<ul id="addParent" class="dropdown-menu" style="padding: 10px; padding-bottom: 0px;">
							<div class="form-group label-floating is-empty">
								<label for="parentName" class="control-label">Parent Name</label>
								<input type="text" class="form-control" id="parentName">
								<input type="submit" style="display: none;">
							</div>

							<div class="form-group label-floating is-empty">
								<label for="parentPass" class="control-label">Password</label>
								<input id="parentPass" class="form-control" type="password" size="30" >
								<span class="input"></span>
							</div>
							<div class="form-group label-floating is-empty">
								<input id="submitParent" class="btn btn-primary" style="clear: left; width: 100%; height: 32px; font-size: 13px; margin-bottom:0px" type="submit" name="commit" value="Go" />
							</div>
						</ul>
					</li>
					<li class="active tab" id="logOut"><a href="logout.php">Logout</a></li>
				</ul>
			</div>
		</div>
	</nav>

<div class="container-fluid">

	<div id="messageBox">
	</div>

	<div class="collapse well" id="subjectForm">
		<form class="row form">
			<div class="form-group col-md-8 center-block">
				<label for="assignment">Subject Name</label>
				<input type="text" class="form-control" id="subjectName" placeholder="History">
			</div>
			<div class="form-group col-md-4 center-block">
				<label for="type">Submit</label>
				<button id="submitSubject" class="btn btn-default btn-block">Add Subject</button>
			</div>
		</form>
	</div>

	<button class="btn btn-primary btn-block" type="button" data-toggle="collapse" data-target="#formWell" aria-expanded="false" aria-controls="formWell">
		Add Grade
	</button>
<div class="collapse well" id="formWell">
	<form id="gradeForm" class="form">
		<div class="row">
			<div class="form-group col-md-4 center-block">
				<label for="assignment">Assignment Title</label>
				<input type="text" class="form-control to-be-submitted" id="title" placeholder="Spectography Lab">
			</div>
			<div class="form-group col-md-4 center-block">
				<label for="type">Type</label>
				<input type="text" class="form-control to-be-submitted" id="type" placeholder="Lab, essay, project, etc">
			</div>
			<div class="form-group col-md-4 center-block">
				<label for="due">Date</label>
				<div class='input-group date' id='due'>
					<input type='text' class="form-control to-be-submitted" id="date" placeholder="01/01/2016"/>
					<span class="input-group-addon">
							<span class="glyphicon glyphicon-calendar"></span>
					</span>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-3 center-block">
				<label for="grade">Grade</label>
				<input type="text" class="form-control to-be-submitted" id="grade" placeholder="A+">
			</div>
			<div class="form-group col-md-3 center-block">
				<label for="number">Percent</label>
				<input type="number" class="form-control to-be-submitted" id="number" placeholder="93">
			</div>
			<div class="form-group col-md-3 center-block">
				<label for="type">Subject</label>
				<select class="form-control to-be-submitted" id="subject">

				</select>
			</div>
			<div class="form-group col-md-3 center-block">
				<label for="type">Submit</label>
				<button id="submit" class="btn btn-default btn-block">Submit grade</button>
			</div>
		</div>
	</form>
</div>
	<h2 class="text-center">Home</h2>
	<table class="table table-striped">
		<thead>
			<tr>
				<th>Assignment</th>
				<th>Type</th>
				<th>Date</th>
				<th>Grade</th>
				<th>Percent</th>
				<th>Subject</th>
			</tr>
		</thead>
		<tbody id="gradeChart">
		</tbody>
	</table>

<?php include('about.php') ?>

</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
<script src="/js/index.js"></script>
<script src="/js/backend.js"></script>

</body>
</html>
