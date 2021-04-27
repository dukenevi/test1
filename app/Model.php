<?php


namespace TestWork;


use mysqli_result;

class Model {

	private array $config = [];

	private \mysqli $db;

	private string $table_name = 'visitor_info';

	/**
	 * Model constructor.
	 *
	 * @param array $config
	 */
	public function __construct( array $config ) {
		$this->config = $config;;
		if ( isset( $this->config['db'] ) && ! empty( $this->config['db'] ) && is_array( $this->config['db'] ) ) {
			$this->db = new \mysqli(
				$this->config['db']['host'],
				$this->config['db']['user'],
				$this->config['db']['pass'],
				$this->config['db']['name'] );
			$this->checkTable();
		}
	}

	/**
	 * @param array $user_info
	 */
	public function save( array $user_info ) {
		if ( $this->db instanceof \mysqli ) {
			$result = $this->get( $user_info );
			if ( $result && $result instanceof mysqli_result ) {
				[ $id, $count ] = $result->fetch_row();
				$this->update( $user_info, $id, $count );
			} else {
				$this->insert( $user_info );
			}
		}
	}

	/**
	 * @param array $user_info
	 *
	 * @return mysqli_result|boolean
	 */
	private function get( array $user_info ) {
		$sql = "SELECT id, views_count FROM {$this->table_name} WHERE 1=1";
		$sql .= " AND ip_address ='" . $this->db->escape_string( $user_info["ip_address"] ) . "'";
		$sql .= " AND user_agent ='" . $this->db->escape_string( $user_info["user_agent"] ) . "'";
		$sql .= " AND page_url = '" . $this->db->escape_string( $user_info["page_url"] ) . "'";
		$sql .= ";";

		return $this->db->query( $sql );
	}

	/**
	 * @param array $user_info
	 *
	 * @return mysqli_result|boolean
	 */
	private function update( array $user_info, int $id, int $count ) {
		$sql = "UPDATE {$this->table_name}";
		$sql .= " SET";
		$sql .= " view_date = '" . $this->db->escape_string( $user_info["view_date"] ) . "'";
		$sql .= ", views_count =" . ( $count + 1 );
		$sql .= " WHERE id={$id};";

		return $this->db->query( $sql );
	}

	/**
	 * @param array $user_info
	 *
	 * @return mysqli_result|boolean
	 */
	private function insert( array $user_info ) {
		$sql = "INSERT INTO {$this->table_name} (ip_address, user_agent, page_url, view_date, views_count)";
		$sql .= "VALUES (";
		$sql .= "'" . $this->db->escape_string( $user_info["ip_address"] ) . "'";
		$sql .= ", '" . $this->db->escape_string( $user_info["user_agent"] ) . "'";
		$sql .= ", '" . $this->db->escape_string( $user_info["page_url"] ) . "'";
		$sql .= ", '" . $this->db->escape_string( $user_info["view_date"] ) . "'";
		$sql .= ", 1";
		$sql .= ");";

		return $this->db->query( $sql );
	}

	/**
	 * create table
	 *
	 * @return mysqli_result|boolean
	 */
	private function checkTable(): void {
		$sql = <<<SQL
CREATE TABLE IF NOT EXISTS  $this->table_name (
    id INT NOT NULL AUTO_INCREMENT ,
    ip_address varchar(15) NOT NULL,
    user_agent varchar(255),
    view_date varchar(20),
    page_url varchar(255),
    views_count int NOT NULL,
    PRIMARY KEY (ID));
SQL;

		$this->db->query( $sql );

	}


}