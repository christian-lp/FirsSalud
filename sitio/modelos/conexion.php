<?php 
class Conexion {
	static public function conectar(){
		// PDO("nombre del servidor; nombre de la DB","usuario","contaseña");
		$link = new PDO("mysql:host=".getenv("SQL_SERVER")."; dbname=".getenv("MEDIC_DB"), getenv("MEDIC_DB_USER"), getenv("MEDIC_DB_PASS"));
		$link->exec("set names utf8");
		return $link;
	}
}