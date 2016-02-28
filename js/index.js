$(function() {
	if (location.pathname != "/?#") { // check if its on the right url
		location = "/?#";
	}

	var currentTab = "starter" // implement currentTab

		setNav();

	$('#due').datetimepicker({format: "L"}); // start the calender picker

	$(".tabby").click(function() {changeTab(this.id)}) // for switching tabs

	function changeTab(identif) { // when you switch tabs
		if (identif == "home") {
			populateChart()
		} else {
			populateChart(identif)
		}
		$(currentTab).toggleClass("active", false)
		$("#"+identif).toggleClass("active", true)
		currentTab = "#"+identif
		$("h2").text(identif.capitalizeFirstLetter())
	}

	$("#submit").click(function() {
		// collect data
		try {
			data = "{"
			data += $('input').map(function(idx, elem) {
				value = $(elem).val()
				id = this.id
				if ( value == "") {
					throw "Empty field: \'" +this.id + "\'";
				}
				return ' "' +id +'" : "' + value + '" '
			}).get()
			data += ', "subject" : "' +$('select').val() +'" }'
			data = JSON.parse(data)
			console.log(data)
			submitGrades(data)

			if (currentTab == "#home") {
				populateChart()
			} else {
				populateChart(currentTab.substring(1))
			}

		} catch (e) {
			messageBox.error(e)
		}
	})

	$("#submitParent").click(function() {
		data = addUser( $('#parentName').val() , $('#parentPass').val())
		if (data == 1) messageBox.addedParent($('#parentName').val());
		else messageBox.failedParent($('#parentName').val());
	})

	$("#submitSubject").click(function() {
		addSubject($('#subjectName').val());
		setNav();
	})

	// set subjects
	function setNav() {
		$('.setNav').remove()
		data = getSubjects();
		if (data) {
			for (var i = 0; i < data.length; i++) {
				$('#nav').append('<li class="tab tabby setNav" id="' +data[i].id +'"><a href="#">' +data[i].name +'</a></li>') // tabby class!
				$('#subject').append('<option class="setNav">' +data[i].name +'</option>')
			}
		}

		currentUser = getUser()
		if (currentUser.student != currentUser.username) {
			$('.dropdown').hide()
		}

		$('#nav').append('<li class="tab active setNav"  type="button" data-toggle="collapse" data-target="#subjectForm" aria-expanded="false" aria-controls="subjectForm"><a href="#">Add Subject</a></li>')
		$('#logoutArea').prepend('<p class="navbar-text setNav">Signed in as ' +currentUser.username +'</p>')
}


	changeTab("home");
});
