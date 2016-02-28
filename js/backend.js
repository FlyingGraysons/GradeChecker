var url = "/php/"

String.prototype.capitalizeFirstLetter = function() {
		return this.charAt(0).toUpperCase() + this.slice(1);
}

var messageBox = {
	$messageBox: $("#messageBox"),
	submitted: function() {
		this.$messageBox.empty()
		this.$messageBox.append($("<div class='alert alert-success alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><strong>Grade Submitted.</strong>&nbsp;&nbsp;The database has been updated.</div>"))
	},
	failedToSubmit: function() {
		this.$messageBox.empty()
		this.$messageBox.append($("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><strong>Submission failure.</strong>&nbsp;&nbsp;There was a problem submitting your input. Check your input and try again.</div>"))
	},
	missingField: function() {
		this.$messageBox.empty()
		this.$messageBox.append($("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><strong>Missing Field.</strong>&nbsp;&nbsp;Please check your input. You are missing at least one field.</div>"))
	},
	error: function(e) {
		this.$messageBox.empty()
		this.$messageBox.append($("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><strong>Error:</strong>&nbsp;&nbsp;" +e +"</div>"))
	},
	noSubject: function() {
		this.$messageBox.empty()
		this.$messageBox.append($("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><strong>No such subject.</strong>&nbsp;&nbsp;The subject you are trying to does not exist in our database.</div>"))
	},
	failedToReload: function() {
		this.$messageBox.empty()
		this.$messageBox.append($("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><strong>Database connection problem.</strong>&nbsp;&nbsp;There was a problem connecting to the database. Please check your connection and try again.</div>"))
	}
}

function populateChart(subject) {
	gradeTable = getGrades(subject)
	// console.log(gradeTable)
	$("#gradeChart").empty()
	if (gradeTable.length == 0) {
		messageBox.failedToReload();
	}
	for(var a = 0; a < gradeTable.length; a++) {
		var domAddition = "<tr><td>"+gradeTable[a].title +"</td>"
		domAddition += "<td>" + gradeTable[a].type +"</td>"
		domAddition += "<td>" + gradeTable[a].due.substring(0,10) +"</td>"
		domAddition += "<td>" + gradeTable[a].grade +"</td>"
		domAddition += "<td>" + gradeTable[a].percent +"%</td>"
		domAddition += "<td>" + gradeTable[a].subject.capitalizeFirstLetter() +"</td>"
		domAddition += "</tr>"

		$("#gradeChart").append(domAddition)
	}
}

function getGrades(subject) {
	var result = $.ajax({
		method: "GET",
		url: url + "ggrades",
		async: false,
		data: {subject: subject}
	});
	return result.responseJSON;
}


function submitGrades(formData) {
	var result = $.ajax({
		method: "POST",
		url: url + "pgrades",
		async: false,
		data: formData
	});
	switch (result.responseJSON) {
		case -1:
			messageBox.missingField()
			break;
		case -2:
			messageBox.noSubject()
			break;
		case 1:
			messageBox.submitted()
			break;
		default:
			messageBox.failedToSubmit()
			break;
	}
}

// can only be done by admin
function addUser(username, password) {
	data = {username: username, password: password}
	var result = $.ajax({
		method: "POST",
		url: url + "user",
		async: false,
		data: data
	});
	if (result.responseJSON == 1) console.log("Succesfully added user: " + username);
	else console.log("Failed to add user: " +username);
}

function getUser(username) {
	var result = $.ajax({
		method: "GET",
		url: url + "user",
		async: false,
		data: {username: username}
	});
	return result.responseJSON;
}

function getSubjects() {
	var result = $.ajax({
		method: "GET",
		url: url + "subject",
		async: false
	});
	return result.responseJSON;
}

function addSubject(subject) {
	var result = $.ajax({
		method: "POST",
		url: url + "subject",
		async: false,
		data: {subject: subject}
	});
	return result.responseJSON;
}
