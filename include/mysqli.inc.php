<?php
/*
  Version: 7.7.4
  Purpose: Database class for mysql functions
  Future:
*/

class sql {
	// #######################################################################
	// Connect to the database
	// #######################################################################
	//
	// @param string The database hostname.					$config['DATABASE_SERVER']
	// @param string The database username.					$config['DATABASE_USER']
	// @param string The database user's password.			$config['DATABASE_PASSWORD']
	// @param string The database name.						$config['DATABASE_NAME']
	// @return resource The database connection resource.
	//
	function connect() {
		global $config, $debug, $querycount;

		$querycount = 0;

		if (!isset($this->dbh)) {
			$this->debug_output = "";

			if (!isset($config['PERSISTENT_DB_CONNECTION']) || !$config['PERSISTENT_DB_CONNECTION']) {
				$this->dbh = mysqli_connect($config['DATABASE_SERVER'], $config['DATABASE_USER'], $config['DATABASE_PASSWORD'], $config['DATABASE_NAME']) or die("Problem occurred in connection");
			} else {
				$this->dbh = mysqli_connect("p:" . $config['DATABASE_SERVER'], $config['DATABASE_USER'], $config['DATABASE_PASSWORD'], $config['DATABASE_NAME']) or die("Problem occurred in connection");
			}
//			if ($config['UTF8']) {
//				mysqli_set_charset($this->dbh, "utf8mb4");
//			}
		}

		if (!$this->dbh) {
			$this->not_right("Unable to connect to the database (as " . $config['DATABASE_USER'] . " to " . $config['DATABASE_SERVER'] . ", database " . $config['DATABASE_NAME'] . ").");
		}

		if (!mysqli_select_db($this->dbh, $config['DATABASE_NAME'])) {
			$this->not_right("Unable to select database: " . $config['DATABASE_NAME']);
		}
	}

	// #######################################################################
	// Grab the error descriptor
	// #######################################################################
	function graberrordesc() {
		return mysqli_error($this->dbh);
	}

	// Determine if the parameter is an integer
	function is_int($x) {
		return false;
		# return preg_match("#^\d+$#", $x);
	}

	// #######################################################################
	// Grab the error number
	// #######################################################################
	function graberrornum() {
		return mysqli_errno($this->dbh);
	}

	// #######################################################################
	// Throw an error (Wrapper Function to reduce code)
	// #######################################################################
	function throw_error($errstr, $is_bare = false) {

		echo "Err: $errstr<br>";
		exit;
	}

	// #######################################################################
	// Do a placeholder query
	// #######################################################################
	function do_placeholder_query($query = "", $subst = array(), $line = "", $file = "") {

		if (!is_array($subst)) {
			$doom = debug_backtrace();
			$this->throw_error("BUG: do_placeholder_query was called without the replacement array. Caller: {$doom[0]['file']}:{$doom[0]['line']}");
		}

		$kaboom = explode("?", $query);
		$places = sizeof($kaboom) - 1;
		$replaces = sizeof($subst);
		if ($places > $replaces) {
			// Fewer places than replaces. Pad the replace array with blanks.
			$subst = array_pad($subst, $places, "");
			$this->throw_error("Tried to replace $places placeholders with $replaces replaces. That's bad. Here's the query: $query");
		} else if ($replaces > $places) {
			// More replaces than places? That's even worse. Fatal, in fact.
			// FIXME: Need to cover this up a bit better...
			$this->throw_error("Tried to replace $places placeholders with $replaces replaces. That's too many. Here's the query: $query");
		}

		// Good, we can actually run now.
		$query = "";
		for ($i = 0; $i < $places; $i++) {
			$query .= array_shift($kaboom);

			// Escape and add quotes to the string if we need to
			$string = array_shift($subst);

			if (is_array($string)) {
				// If this is an array, join it with commas after escaping
				// Primary use: IN(?) and INSERT INTO tablename(COL, COL, ...) VALUES(?)
				$new_ary = array();


				foreach ($string as $str) {
					$new_ary[] = $this->is_int($str) ? $str : "'" . mysqli_real_escape_string($this->dbh, $str) . "'";
				}

				$string = implode(", ", $new_ary);
			} else if (!$this->is_int($string) || $string[0] == '0') {
				// Escape the string only if it isn't a plain number or NULL
				$string = "'" . mysqli_real_escape_string($this->dbh, $string) . "'";
			}
			$query .= $string;
		}
		$query .= $kaboom[0]; // last piece after the last substitution
		return $this->do_query($query, $line, $file);
	}

	// #######################################################################
	// Calls MySQL's escape function to prepend backslashes where needed. Using
	// the data provider's escape function instead of addslashes() takes into
	// account the character set used by the current connection to the database
	// #######################################################################
	function escape_string($sth) {
		// Escape and add quotes to the string only if it isn't a plain number or NULL
		if (!$this->is_int($sth) || $sth[0] == '0') {
			$sth = "'" . mysqli_real_escape_string($this->dbh, $sth) . "'";
		}
		return $sth;
	}

	// #######################################################################
	// Do the query
	// #######################################################################
	function do_query($query, $line = "", $file = "") {
		global $querycount, $debug, $mysqltime,$config;
		$querycount++;

		$now = time();
		$script_name = $_SERVER['SCRIPT_NAME'];

		if (preg_match('%[^\\\\/:*?"<>|\x00-\x1F]+$%i', $script_name, $regs)) {
			$script_name_path = $regs[0];
		} else {
			$script_name_path = "Unavailable";
		}
		

		$log_dir = $config['LOG_SQL_PATH'];
		if ($log_dir) {
			$date = date('Ymd', $now);              // example: '20021018'
			$time = date('D, M d Y H:i:s O', $now); // example: 'Fri Oct 18 21:50:13 2002 +0200'
			$log_file = "$log_dir/{$date}_{$script_name_path}_mysql.log";
			$log = "[QUERY][$time] [$script_name] Script: $file - Line: $line\n$query\n\n";
			file_put_contents($log_file, $log, FILE_APPEND | LOCK_EX);
		}
		// this line line grabs the query in to $sth
		$sth = mysqli_query($this->dbh, $query);

		if (!$sth) {
			{
				define('IS_SQL_ERROR', 1);
				$this->not_right($query, $line, $file);
			}
		}
		return $sth;
	}

	// #######################################################################
	// Fetch the next row in an array
	// #######################################################################
	function fetch_array($sth, $type = MYSQLI_BOTH) {
		if ($sth instanceof mysqli_result) {
			return mysqli_fetch_array($sth, $type);
		}
		return false;
	}

	// #######################################################################
	// Fetch the next assoc row in an array
	// #######################################################################
	function fetch_assoc($sth) {
		if ($sth instanceof mysqli_result) {
			return mysqli_fetch_assoc($sth);
		}
		return false;
	}


	// #######################################################################
	// Get a result row as an enumerated array
	// #######################################################################
	function mysqli_fetch_row($sth) {
		return mysqli_fetch_row($sth);
	}

	// #######################################################################
	// Finish the statement handler
	// #######################################################################
	function finish_sth($sth) {
		if (is_resource($sth)) {
			return mysqli_free_result($sth);
		}
	}

	// #######################################################################
	// Grab the total rows
	// #######################################################################
	function total_rows($sth) {
		return mysqli_num_rows($sth);
	}

	function affected_rows() {
		return mysqli_affected_rows($this->dbh);
	}

	function last_insert_id($line, $file) {
		$sth = $this->do_query("SELECT last_insert_id()", $line, $file);
		list($id) = $this->fetch_array($sth, MYSQLI_BOTH);
		return $id;
	}

	// #######################################################################
	// Grab the number of fields
	// #######################################################################
	function num_fields($sth) {
		return mysqli_num_fields($sth);
	}

	// #######################################################################
	// Grab the field name
	// #######################################################################
	function field_name($sth, $i) {
		return mysqli_fetch_field_direct($sth, $i)->name;
	}

	// #######################################################################
	// Die
	// #######################################################################
	function not_right($error, $line = "", $file = "") {
		global $user, $user_ip, $config, $html;

		echo "Error\n";

		// IF YOU SET THE VARIABLE BELOW TO 1 IT WILL SHOW THE SQL ERRORS TO ALL
		// USERS. USEFUL IF YOU CANNOT LOG IN AND NEED TO SEE THE SQL ERRORS
		$showerror = 1;
		if (defined('INSTALL')) {
			$showerror = 1;
		}

		$mysqli_error = mysqli_error($this->dbh);

		$now = time();
		$time = '';

		if ($config['LOG_SQL_ERRORS']) {
			$log_dir = $config['LOG_SQL_ERRORS_PATH'];
			if ($log_dir) {
				$date = date('Ymd', $now);              // example: '20021018'
				$time = date('D, M d Y H:i:s O', $now); // example: 'Fri Oct 18 21:50:13 2002 +0200'
				$log_file = "$log_dir/{$date}_{$script_name_path}_mysql.log";
				$log = "[ERROR][$time] [$script_name] Script: $file - Line: $line\n$error - $mysqli_error\n\n";
				file_put_contents($log_file, $log, FILE_APPEND | LOCK_EX);
				// @error_log("[ERROR][$time] [$script_name] Script: $file - Line: $line $error - $mysqli_error\n", 3, $log_file);
			}
		}

		$connect_array = array(2001, 2002, 2003, 2004, 2005, 2006, 2013, 2016, 2017, 2018, 2019);

		if ($showerror || defined('SHOW_SQL_LOGS')) {
			$show_error = "<b>Script:</b> $file\n";
			$show_error .= "<b>Line:</b> $line\n";
			if (in_array(mysqli_errno($this->dbh), $connect_array)) {
				$show_error .= "<b>SQL Error:</b> " . mysqli_error($this->dbh) . "\n<b>Please verify that your MySQL server is running</b>\n";
			} else {
				$show_error .= "<b>SQL Error:</b> " . mysqli_error($this->dbh) . "\n";
			}
			$show_error .= "<b>SQL Error:</b> " . mysqli_errno($this->dbh) . "\n";
			$show_error .= "\n<b>Query:</b><code>$error</code>";
		} else {
			if (in_array(mysqli_errno($this->dbh), $connect_array)) {
				$show_error = "Unable to connect to database server, please try again in a few minutes.";
			} else {
				$show_error = 'Database error only visible to forum administrators';
			}
		}
		$show_error = str_replace("\n", "<br>\n", $show_error);
		$this->throw_error($show_error, true);
	}
}

class querybuilder {
	var $fields = array();
	var $values = array();

	// veld+value toevoegen aan de query
	function add($field,$value) {
		$this->fields[] = $field;
		$this->values[] = $value;
	}

	// geeft comma seperated velden terug die allemaal toegevoegd zijn.
	function getfields() {
		return implode(",",$this->fields);
	}

	function getfields_forupdate() {
		return implode(" = ?,",$this->fields)." = ?";
	}

	// geeft de array terug met de waarden.
	function getvalues() {
		return $this->values;
	}
}


?>