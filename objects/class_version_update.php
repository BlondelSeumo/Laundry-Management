<?php
class laundry_version_update
{
	public $version = "2.0";
	public $conn;

	public function insert_option($option, $value)
	{
		$add_options = "INSERT INTO `ld_settings` (`id`, `option_name`, `option_value`,`postalcode`) VALUES (NULL, '" . $option . "', '" . $value . "','');";
		mysqli_query($this->conn, $add_options);
	}

	public function get_all_languages()
	{
		$query = "select * from `ld_languages`";
		$result = mysqli_query($this->conn, $query);
		return $result;
	}
	public function get_all_labelsbyid($lang)
	{
		$query = "select * from `ld_languages` where `language`='" . $lang . "'";
		$result = mysqli_query($this->conn, $query);
		$ress = @mysqli_fetch_assoc($result);
		return $ress;
	}

	public function update1_2()
	{
		$query = "update `ld_settings` set `option_value`='" . $this->version . "' where `option_name`='ld_version'";
		$result = mysqli_query($this->conn, $query);
		return $result;
	}
	public function update1_3()
	{
		$query = "update `ld_settings` set `option_value`='" . $this->version . "' where `option_name`='ld_version'";
		$result = mysqli_query($this->conn, $query);
		return $result;
	}
	public function update1_4()
	{
		$query = "update `ld_settings` set `option_value`='" . $this->version . "' where `option_name`='ld_version'";
		$result = mysqli_query($this->conn, $query);
		return $result;
	}
	public function update2_0()
	{
		$query = "update `ld_settings` set `option_value`='" . $this->version . "' where `option_name`='ld_version'";
		$result = mysqli_query($this->conn, $query);
		return $result;
	}
}
