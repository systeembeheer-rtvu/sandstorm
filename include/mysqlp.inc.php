<?php
/*
  Version: 7.7.5
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
        global $config;
    
        $dsn = "mysql:host=" . $config['DATABASE_SERVER'] . ";dbname=" . $config['DATABASE_NAME'] . ";charset=utf8mb4";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
    
        try {
            $this->dbh = new PDO($dsn, $config['DATABASE_USER'], $config['DATABASE_PASSWORD'], $options);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
    }
	
	// #######################################################################
	// Throw an error (Wrapper Function to reduce code)
	// #######################################################################
	function throw_error($errstr) {
		echo "Err: $errstr";

		$to = "hans.siemons@rtvutrecht.nl";
		$subject = "SQL Error";
		$message = "Err: $errstr";
		$headers = 'From: noreply@rtvutrecht.nl';
		echo mail($to, $subject, $message, $headers);
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
        $values = array();
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
                $values = array_merge($values,$string); // expanding the values
                $string = implode(',', array_fill(0, sizeof($string), '?')); // count elements
			} else {
				// Escape the string only if it isn't a plain number or NULL
                array_push($values,$string); // add value to array.
                $string = "?";
			}
			$query .= $string;
		}
		$query .= $kaboom[0]; // last piece after the last substitution
        // echo "$query\n";
        // var_dump($values);

        try {
            $stmt = $this->dbh->prepare($query);
            $stmt->execute($values);
            return $stmt;
        } catch (PDOException $e) {
            // Handle error or throw exception
            $this->throw_error("Query Error in $file on line $line: " . $e->getMessage());
        }
	}

    function do_named_query($query, $params = [], $line = '', $file = '') {
        try {
            $stmt = $this->dbh->prepare($query);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            // Optionally use $line and $file for detailed error reporting
            $this->throw_error("Query Error in $file on line $line: " . $e->getMessage());
        }
    }
	// #######################################################################
	// Do the query
	// #######################################################################
	function do_query($query, $line = "", $file = "") {
        return $this->do_placeholder_query($query,array(),$line, $file);
	}

	// #######################################################################
	// Fetch the next row in an array
	// #######################################################################
	function fetch_array($stmt, $fetchStyle = PDO::FETCH_BOTH) {
        return $stmt->fetch($fetchStyle);
    }
    
	// #######################################################################
	// Fetch the next assoc row in an array
	// #######################################################################
    function fetch_assoc($stmt) {
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

	function fetch_all_assoc($stmt) {
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	// #######################################################################
	// Get a result row as an enumerated array
	// #######################################################################
    function pdo_fetch_row($stmt) {
        return $stmt->fetch(PDO::FETCH_NUM);
    }
    
	// #######################################################################
	// Finish the statement handler
	// #######################################################################
	function finish_sth($sth) {
        // nothing to do, keeping function juts in case someone calls it.
	}

	function affected_rows() {
		// return mysqli_affected_rows($this->dbh);
	}

    function last_insert_id() {
        return $this->dbh->lastInsertId();
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