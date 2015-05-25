<?php

if(!function_exists('encrypt_pass')){
	function encrypt_pass($pass){
		$pass = sha1(md5($pass.'wV4@5Ysb&'));
		return $pass;
	}
}

?>