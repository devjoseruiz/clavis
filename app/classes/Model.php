<?php

class Model extends Db
{


	/**
	 * Lists records from the database or a single record
	 *
	 * @param string $table
	 * @param array $params
	 * @param integer $limit
	 * @return void
	 */
	public static function list($table, $params = [], $limit = null)
	{
		// It creates the col names and values to bind
		$cols_values = "";
		$limits = "";
		if (!empty($params)) {
			$cols_values .= "WHERE";
			foreach ($params as $key => $value) {
				$cols_values .= " {$key} = :{$key} AND";
			}
			$cols_values = substr($cols_values, 0, -3);
		}

		// If $limit is set, set a limit of data read
		if ($limit !== null) {
			$limits = " LIMIT {$limit}";
		}

		// Query creation
		$stmt = "SELECT * FROM $table {$cols_values}{$limits}";

		// Calling DB and querying
		if (!$rows = parent::query($stmt, $params)) {
			return false;
		}

		return $limit === 1 ? $rows[0] : $rows;
	}

	/**
	 * Add a new record to DB
	 * @access public
	 * @var string | array
	 * @return bool
	 **/
	public static function add($table, $params)
	{
		$cols = "";
		$placeholders = "";
		foreach ($params as $key => $value) {
			$cols .= "{$key} ,";
			$placeholders .= ":{$key} ,";
		}
		$cols = substr($cols, 0, -1);
		$placeholders = substr($placeholders, 0, -1);
		$stmt =
			"INSERT INTO {$table}
		({$cols})
		VALUES
		({$placeholders})
		";

		// Send statement to query()
		if ($id = parent::query($stmt, $params)) {
			return $id;
		} else {
			return false;
		}
	}

	/**
	 * Add a new record to DB
	 * @access public
	 * @var string | array
	 * @return bool
	 **/
	public static function update($table, $haystack = [], $params = [])
	{
		$placeholders = "";
		$col = "";

		foreach ($params as $key => $value) {
			$placeholders .= " {$key} = :{$key} ,";
		}
		$placeholders = substr($placeholders, 0, -1);

		if (count($haystack) > 1) {
			foreach ($haystack as $key => $value) {
				$col .= " $key = :$key AND";
			}
			$col = substr($col, 0, -3);
		} else {
			foreach ($haystack as $key => $value) {
				$col .= " $key = :$key";
			}
		}

		$stmt =
			"UPDATE $table
		SET
		$placeholders
		WHERE
		$col
		";

		// Send statement to query()
		if (!parent::query($stmt, array_merge($params, $haystack))) {
			return false;
		}

		return true;
	}

	/**
	 * Deletes a record from the database
	 * Changed $limit = 1 default to $limit = null because it was causing issues
	 * when deleting multiple records, as it required setting a finite number
	 * for more than 1 record to be deleted simultaneously.
	 *
	 * @param string $table
	 * @param array $params
	 * @param integer $limit
	 * @return void
	 */
	public static function remove($table, $params = [], $limit = null)
	{
		// It creates the col names and values to bind
		$cols_values = "";
		$limits = "";
		if (!empty($params)) {
			$cols_values .= "WHERE";
			foreach ($params as $key => $value) {
				$cols_values .= " {$key} = :{$key} AND";
			}
			$cols_values = substr($cols_values, 0, -3);
		}

		// If $limit is set, set a limit of data read
		if ($limit !== null && is_integer($limit)) {
			$limits = " LIMIT {$limit}";
		}

		// Query creation
		$stmt = "DELETE FROM $table {$cols_values}{$limits}";

		// Calling DB and querying
		if (!$row = parent::query($stmt, $params)) {
			return false;
		}

		return $row;
	}
}