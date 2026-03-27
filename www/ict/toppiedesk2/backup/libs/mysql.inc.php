<?php
class sql {
	// #######################################################################
	// Connect to the database
	// #######################################################################
	function connect() {
		global $config;
		if (!isset($this->dbh)) {
			if (!isset($config['PERSISTENT_DB_CONNECTION']) || !$config['PERSISTENT_DB_CONNECTION']) {
				$this->dbh = mysql_connect($config['DATABASE_SERVER'],$config['DATABASE_USER'],$config['DATABASE_PASSWORD'],1);
			}
			else {
				$this->dbh = mysql_pconnect($config['DATABASE_SERVER'],$config['DATABASE_USER'],$config['DATABASE_PASSWORD']);
			}
		}
		if (!$this->dbh) {
			$this->not_right("Unable to connect to the database!");
		}
		mysql_select_db($config['DATABASE_NAME'],$this->dbh);
	}
	
	function connect2($server, $user, $password, $database) {
		
		global $config;
		
		if (!isset($this->dbh)) {
			if (!isset($config['PERSISTENT_DB_CONNECTION']) || !$config['PERSISTENT_DB_CONNECTION']) {
				$this->dbh = mysql_connect($server,$user,$password,1);
			}
			else {
				$this->dbh = mysql_pconnect($server,$user,$password);
			}
		}
		
		if (!$this->dbh) {
			$this->not_right("Unable to connect to the database!");
		}
		mysql_select_db($database,$this->dbh);
	}
	// #######################################################################
	// Grab the error descriptor
	// #######################################################################
	function graberrordesc() {
		$this->error=mysql_error();
		return $this->error;
	}
	
	// #######################################################################
	// Grab the error number
	// #######################################################################
	function graberrornum() {
		$this->errornum=mysql_errno();
		return $this->errornum;
	}
	// #######################################################################
	// Do a placeholder query
	// #######################################################################
	function do_placeholder_query($query="",$subst=array(),$line="",$file="",$nonfatal="") {
		
		if(!is_array($subst)) {
			$doom = debug_backtrace();
			$errstr = "BUG: do_placeholder_query was called without the replacement array.  Caller: {$doom[0]['file']}:{$doom[0]['line']}";
		
			echo $errstr;
			exit;
		} // end if		
		$kaboom = explode("?", $query);
		$places = sizeof($kaboom) - 1;
		$replaces = sizeof($subst);
		if($places > $replaces)
		{
			// Fewer places than replaces.  Pad the replace array with blanks.
			$subst = array_pad($subst, $places, "");
			echo ("Tried to replace $places placeholders with $replaces replaces.  That's bad.  Here's the query: $query");
			die;	
		}
		else if ( $replaces > $places )
		{
			// More replaces than places?  That's even worse.  Fatal, in fact.
			// FIXME: Need to cover this up a bit better...
			echo ("Tried to replace $places placeholders with $replaces replaces.  That's too many.  Here's the query: $query");
			die;
		} // end if
		
		// Good, we can actually run now.
		$query = "";
		for($i = 0; $i < $places; $i++) {
			$query .= array_shift($kaboom);
			
			// Escape and add quotes to the string if we need to
			$string = array_shift($subst);
			
			if(is_array($string)) {
				// If this is an array, join it with commas after escaping
				// Primary use: IN(?) and INSERT INTO tablename(COL, COL, ...) VALUES(?)
				$new_ary = array();
				foreach($string as $str) {
					$new_ary[] = ($str == 'NULL') ? $str : "'" . mysql_real_escape_string($str) . "'";
				} // end foreach
				$string = join(", ", $new_ary);
			} else if($string != 'NULL' ) {
				// Escape the string only if it isn't a plain number or NULL
				$string = "'" . mysql_real_escape_string($string) . "'";
			} # end if
			$query .= $string;
		} // end for
		
		$query .= array_shift($kaboom); // last piece after the last substitution
		return $this->do_query($query,$line,$file,$nonfatal);
		exit;
		
	}
	// #######################################################################
	// Do the query
	// #######################################################################
	function do_query($query,$line="",$file="",$nonfatal="") {
		global $debug;
		//$querycount++;
		
		// If we are in debug mode then we are going to EXPLAIN each
		// query but only to admins
		if (isset($user['USER_MEMBERSHIP_LEVEL'])) {
			if ($user['USER_MEMBERSHIP_LEVEL'] == "Administrator") {
				if ($debug) {
					$query = str_replace(","," , ",$query);
					$this ->sth =  mysql_query("EXPLAIN $query",$this->dbh);
					$numFields = "";
					if ($this -> sth) {
						$numFields = $this -> num_fields($this -> sth);
					}
					echo "<table border=\"1\" width=\"100%\"><tr bgcolor=\"BCBCBC\"><td colspan=\"$numFields\"><b>Query:</b> $query</td></tr>";
					if ($numFields) {
						echo "<tr bgcolor=\"#EcEcEc\">";
						for ( $i=0; $i<$numFields; $i++) {
							echo "<td>" . $this -> field_name($this -> sth, $i) ."</td>";
						}
						echo "</tr>";
						while($results = $this -> fetch_array($this -> sth)) {
							echo "<tr>";
							for ($i=0;$i<=sizeof($results);$i++) {
								$printer = "";
								if (isset($results[$i])) {
									$printer = $results[$i];
								}
								echo "<td>$printer</td>";
							}
							echo "</tr>";
						}
					}
				}
			}
		}
		
		$this->sth = mysql_query($query,$this->dbh);
		
		if (!$this->sth && (defined('IS_UPGRADE') || defined('IMPORT') && ($nonfatal)) ) {
			echo mysql_error();
		}
		elseif (!$this->sth && (!$nonfatal)) {
			echo ("$query<br><br>" . mysql_error());
			exit;
		}
		else {
			return $this->sth;
		}
	}
	// #######################################################################
	// Fetch the next row in an array
	// #######################################################################
	function fetch_array($sth) {
		$this->row = mysql_fetch_array($sth);
		return $this->row;
	}
	// #######################################################################
	// Get a result row as an enumerated array
	// #######################################################################
	function mysql_fetch_row($sth) {
		$this->row = mysql_fetch_row($sth);
		return $this->row;	}
	
	// #######################################################################
	// Finish the statement handler
	// #######################################################################
	function finish_sth($sth) {
		return @mysql_free_result($this->sth);
	}
	// #######################################################################
	// Grab the total rows
	// #######################################################################
	function total_rows( $sth ) {
		return mysql_num_rows( $sth );
	}
	function affected_rows() {
		return mysql_affected_rows();
	}
	function last_insert_id($line, $file) {
		$sth = $this->do_query("SELECT last_insert_id()", $line, $file);
		list($id) = $this->fetch_array($sth, MYSQL_BOTH);
		return $id;
	}
	// #######################################################################
	// Grab the number of fields
	// #######################################################################
	function num_fields($sth) {
		return mysql_num_fields($this->sth);
	}
	// #######################################################################
	// Grab the field name
	// #######################################################################
	function field_name($sth,$i) {
		return mysql_field_name($this->sth,$i);
	}
	// #######################################################################
	// Die
	// #######################################################################
	function not_right($error,$line="",$file="") {
		global $config;
		// IF YOU SET THE VARIABLE BELOW TO 1 IT WILL SHOW THE SQL ERRORS TO ALL
		// USERS.  USEFUL IF YOU CANNOT LOG IN AND NEED TO SEE THE SQL ERRORS
		$showerror = 0;
		$script_name = find_environmental('PHP_SELF');
		if (!$script_name) {
			$script_name = find_environmental('SCRIPT_NAME');
		}
		$mysql_error = mysql_error();
		$now  = time();
		$time = '';
		
		$connect_array = array(2001,2002,2003,2004,2005,2006,2013);
		$show_error = "<b>Script:</b> $file<br />";
		$show_error .= "<b>Line#:</b> $line<br />";
		if (in_array(mysql_errno(),$connect_array)) {
			$show_error .= "<b>SQL Error:</b> " . mysql_error() . "<br /><b>Please verify that your MySQL server is running</b><br />";
		} else {
			$show_error .= "<b>SQL Error:</b> " . mysql_error() . "<br />";
		} // end if
		$show_error .= "<b>SQL Error #:</b> " . mysql_errno() . "<br />";
		$show_error .= "<b>Query:</b> $error";
		echo ($show_error);		
	}
}
?>