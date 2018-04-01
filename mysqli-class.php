<?php
/*------------------------------------------------------------------------------
File:			class.db.php
Class:			Basic MySQLi
Description:	Basic PHP MySQLi class to handle common database queries and operations
Version:		1.0.1
Updated:		01-Apr-2018
Author:			Gio Bautista
Homepage:		www.giobautista.com
--------------------------------------------------------------------------------
The MIT License (MIT)

Copyright (c) 2014 Gio Bautista

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
-------------------------------------------------------------------------------- */
class MySQLiDB
{
	protected $db;

	public function __construct(){
		$this->db = new mysqli('localhost', 'username', 'password', 'database');

		if ($this->db->connect_errno) {
			echo "<pre>";
		    echo "Error MySQLi: (" . $this->db->connect_errno
		    . ") " . $this->db->connect_error;
			echo "</pre>";
		    exit();
		}
		$this->db->set_charset("utf8");
	}


	# $id = $run->sanitize($_POST['id']);
	#
	# $sqlQuery = "SELECT id, first_name, last_name FROM users WHERE id={$id}";
	# $result = $run->runQuery($sqlQuery);
	#
	# if ($result->num_rows > 0 ) {
	# 	while($row = $result->fetch_assoc()) {
	# 		echo "id: " . $row["id"]. " - Name: " . $row["first_name"]. " " . $row["last_name"]. "<br>";
	# 	}
	# } else {
	# 	echo "0 result";
	# }
	public function runQuery($sql) {
	    $result = $this->db->query($sql);
	    return $result;
	}


	# $cols = array('last_name', 'first_name');
	#
	# $results = $i->get('users', $cols, 'last_name', 'ASC');
	#
	# foreach ($results as $result){
	#		echo $result->last_name, ', ',$result->first_name,'<br>';
	# }
	public function get($table, $columns = '*', $order_by = 'id', $order = 'DESC'){

		if (empty($columns)) {
			$columns = '*';
		}

		$column = is_array($columns) ? implode(', ', $columns) : $columns;
		$get_sql = "SELECT {$column} FROM {$table}";

		$get_sql .= " ORDER BY {$order_by} {$order}";

		$runGet = $this->db->query($get_sql);

		while ($row = $runGet->fetch_object()) {
			$results[] = $row;
		}

		return $results;
	}

	# $column = array('id', 'title', 'content', 'dt');
	#
	# $where = array(
	# 			'id' => $id,
	# 			);
	#
	# $result = $new->select($column, 'blog', $where, $limit);
	#
	# if(!$result->num_rows > 0) {
	# 	header('location: index.php');
	# }
	public function select($column, $table, $where, $limit = '10') {

		foreach( $where as $field => $value ) {
			$value = $value;
			$clause[] = "$field = '$value'";
		}

		$column = implode(", ", $column);
		$where = implode(' AND ', $clause);

		$select_sql = "SELECT {$column} FROM {$table} WHERE {$where} LIMIT {$limit};";

		return $this->db->query($select_sql);
	}

	# $title = $new->sanitize($_POST['title']);
	# $content = $new->sanitize($_POST['content']);
	#
	# $data = array(
	# 				'title' => $title,
	# 				'content' => $content,
	# 				);
	#
	# $insert = $new->insert('blog', $data);
	public function insert($table, $data) {

		$fields = implode(",", array_keys($data));
		$values = "'".implode("','", $data)."'"; # this is a shortcut, find better ways!

		$insert_query = "INSERT {$table}({$fields}) VALUES ({$values})";

		return $this->db->query($insert_query);
	}


	# $title = $new->sanitize($_POST['title']);
	# $content = $new->sanitize($_POST['content']);
	#
	# $data = array(
	# 			'title' => $title,
	# 			'content' => $content,
	# 			);
	#
	# $where = array(
	# 			'id' => '22',
	# 			);
	#
	# $update = $new->update('blog', $data, $where);
	public function update($table, $data, $where) {

		foreach( $data as $field => $value ) {
			$updates[] = "`$field` = '$value'";
		}

		foreach( $where as $field => $value ) {
			# $value = $value;
			$clause[] = "$field = '$value'";
		}

		$updates = implode(', ', $updates);
		$where = implode(' AND ', $clause);

		$update_query = "UPDATE {$table} SET {$updates} WHERE {$where}";

		return $this->db->query($update_query);
	}


	# $where = array(
	# 			'id' => $id,
	# 			);
	#
	# $delete = $new->delete('blog', $where);
	public function delete($table, $where) {

		foreach( $where as $field => $value ) {
			$value = $value;
			$clause[] = "$field = '$value'";
		}

		$where = implode(' AND ', $clause);

		$delete_sql = "DELETE FROM {$table} WHERE {$where}";

		return $this->db->query($delete_sql);
	}


	# $check = array(
	# 			'first_name' => 'John',
	#			'last_name' => 'Doe'
	# 			);
	#
	# $column = array('id', 'first_name', 'last_name');
	#
	# $exists = $new->exists('table', $column, $check);
	public function exists($table, $column, $check) {

		foreach( $check as $field => $value ) {
			$value = $value;
			$check_val[] = "$field = '$value'";
		}

		$column = implode(", ", $column);
		$check = implode(' AND ', $check_val);

		$exists_sql = "SELECT {$column} FROM {$table} WHERE {$check}";

		$runCheck = $this->db->query($exists_sql);

		if ($runCheck->num_rows === 1) {
			return true;
		} else {
			return false;
		}
	}

	public function sanitize($str) {
		if(ini_get('magic_quotes_gpc'))
			$str = stripslashes($str);

		$str = strip_tags($str);
		$str = trim($str);
		$str = htmlspecialchars($str);

		return $str;
	}

	public function __deconstruct(){
		$this->db->close();
	}
}
?>
