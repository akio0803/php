<?php
class db
{
	public $data;
	public $last_id;
	public $sql;
	public $associate;
	private $connection;
	private $result;
	public $host;
	private $port;
	public $user;
	public $pass;
	public $name;
	private $charset;

	public function __construct()
	{
		$this->data = array();
		$this->last_id = 0;
		$this->sql = '';
		$this->associate = true;
		$this->connection = null;
		$this->result = null;
		$this->host = DB_HOST;
		$this->user = DB_USER;
		$this->pass = DB_PASS;
		$this->name = DB_NAME;
		$this->port = DB_PORT;
		$this->charset = 'utf8';
	}

	public function select()
	{
		$this->data = array();
		try
		{
			$this->connection = mysql_connect($this->host.':'.$this->port,$this->user, $this->pass);
			mysql_query("set names " . $this->charset);
			$this->result = mysql_db_query($this->name, $this->sql);
			mysql_close($this->connection);
			if($this->result){
				if($this->associate){
					while($row = mysql_fetch_assoc($this->result)){
						$this->data[] = $row;
					}
				}else{
					while($row = mysql_fetch_row($this->result)){
						$this->data[] = $row;
					}
				}
			}
			@mysql_free_result($this->result);
		}
		catch(Exception $e)
		{
		}
	}

	public function update()
	{
		try
		{
			$this->connection = mysql_connect($this->host.':'.$this->port,$this->user, $this->pass);
			mysql_query("set names " . $this->charset);
			$this->result = mysql_db_query($this->name, $this->sql);
			$this->last_id = mysql_insert_id();
			mysql_close($this->connection);
			return true;
		}
		catch(Exception $e)
		{
			return false;
		}
	}

}

?>