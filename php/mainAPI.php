<?php

require_once 'API.class.php';

class mainAPI extends API
{

	// The database
	private $mysqli;
	private $config;

	public function __construct($request, $origin) {
		$this->config = include('config.php'); // change this to config.php for the Digital Ocean server.

		$this->initDB();

		$this->sanitizeHTTPParameters();

		parent::__construct($request);
	}

	private function sanitizeHTTPParameters() {
		foreach ($_GET as $key => $value) {
			$_GET[$key] = escapeshellcmd($this->mysqli->real_escape_string($value));
		}
		foreach ($_POST as $key => $value) {
			$_POST[$key] = escapeshellcmd($this->mysqli->real_escape_string($value));
		}
	}

	private function encryptPassword($password) {
		return $this->mysqli->real_escape_string(crypt($password, $this->config['salt']));
	}

	// Initializes and returns a mysqli object that represents our mysql database
	private function initDB() {
		$this->mysqli = new mysqli($this->config['hostname'],
			$this->config['username'],
			$this->config['password'],
			$this->config['databaseName']);

		if (mysqli_connect_errno()) {
			echo "<br><br>There seems to be a problem with the database. Reload the page or try again later.";
			exit();
		}
	}

	private function select($sql) {
		$res = mysqli_query($this->mysqli, $sql);
		if($res) return mysqli_fetch_array($res, MYSQLI_ASSOC);
		else return NULL;
		return $res;
	}

	private function selectMultiple($sql) {
		$res = mysqli_query($this->mysqli, $sql);
		$finalArray = array();

		while($temp = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
			array_push($finalArray, $temp);
		}

		return $finalArray;
	}

	private function insert($sql) {
		mysqli_query($this->mysqli, $sql);
	}

	// API Endpoints
	protected function ggrades() {
		if(isset($_GET['subject'])) {
			$subject = strtolower($_GET['subject']);
			return $this->selectMultiple("SELECT * FROM `grade` WHERE `subject` = '$subject' AND `student` = '{$_SESSION['student']}' ORDER BY `due` ASC");
		} else {
			return $this->selectMultiple("SELECT * FROM `grade` WHERE `student` = '{$_SESSION['student']}' ORDER BY `due` ASC");
		}
	}

	protected function pgrades() {
		if(!(isset($_POST['subject'])
		&& isset($_POST['title'])
		&& isset($_POST['type'])
		&& isset($_POST['grade'])
		&& isset($_POST['number'])
		&& isset($_POST['date']) )) {
			return -1;
		}
		$subject = strtolower($_POST['subject']);
		if ($this->select("SELECT * FROM `subjects` WHERE `id` = \"$subject\" AND `student` = \"{$_SESSION['student']}\"") == NULL) {
			return -2;
		}
		$td=date('Y-m-d',strtotime($_POST['date']));
		$this->insert("INSERT INTO `grade` (`title`, `type`, `grade`, `percent`, `due`, `subject`, `student`) VALUES (\"{$_POST['title']}\", \"{$_POST['type']}\", \"{$_POST['grade']}\", {$_POST['number']}, \"{$td}\", \"$subject\", '{$_SESSION['student']}')");
		return 1;
	}

	protected function user() {
		// for students to add parents
		if(isset($_POST['username'])
		&& isset($_POST['password'])
		&& ($_SESSION['username'] == $_SESSION['student']) ) { // can only be added by the student
			$password = encryptPassword($_POST['password']); // for hashing the password for server-side storage
			$username = strtolower($_POST['username']);
			$this->insert("INSERT INTO `users` (`id`, `username`, `password`, `student`) VALUES (NULL, \"{$username}\", \"{$password}\", \"{$_SESSION['student']}\")");
			return 1;
		}

		// for getting users
		if( isset( $_GET['username'] ) ) {
			$username = strtolower( $_GET['username'] );
			return $this->select("SELECT `id`, `username`, `student` FROM `users` WHERE `username` = \"{$username}\"");
		}
			return $this->select("SELECT `id`, `username`, `student` FROM `users` WHERE `username` = \"{$_SESSION['username']}\"");
	}

	protected function subject() {
		if( isset ( $_POST['subject'])) {
			$id = strtolower($_POST['subject']);
			$this->insert("INSERT INTO `subjects` (`name`, `id`, `student`) VALUES ('{$_POST['subject']}', '{$id}', '{$_SESSION['student']}')");
		}

		return $this->selectMultiple("SELECT `name`, `id` FROM `subjects` WHERE `student` = \"{$_SESSION['student']}\" ORDER BY `id` ASC");

	}


 }

 ?>
