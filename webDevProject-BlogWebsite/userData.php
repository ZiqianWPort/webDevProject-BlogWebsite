<?php

	// get user name from database through user id
	function databaseGetUsername($id) {
		require 'database.php';
		$stmt = $mysqli->prepare("select username from users where id=?");
		if(!$stmt){
			printf("Query Prep Failed: %s\n", $mysqli->error);
			exit;
		}
		$stmt->bind_param('i', $id);
		$stmt->execute();
		$stmt->bind_result($username);
		$stmt->fetch();
		return $username;
	}

	// get user nickname from database through user id
	function databaseGetNickname($id) {
		require 'database.php';
		$stmt = $mysqli->prepare("select nickname from users where id=?");
		if(!$stmt){
			printf("Query Prep Failed: %s\n", $mysqli->error);
			exit;
		}
		$stmt->bind_param('i', $id);
		$stmt->execute();
		$stmt->bind_result($nickname);
		$stmt->fetch();
		return $nickname;
	}
	    // check if user is admin
		function isAdmin() {
			// start session if not started
			if (session_status() == PHP_SESSION_NONE) {
				session_start();
			}
			// if not logged in, return false
			if (!isLoggedIn()) {
				return 0;
			}
			require 'database.php';
			$id = getUserId();
			// check if id admin in database
			$stmt = $mysqli->prepare("select admin from users where id=?");
			if(!$stmt){
				printf("Query Prep Failed: %s\n", $mysqli->error);
				exit;
			}
			$stmt->bind_param('i', $id);
			$stmt->execute();
			$stmt->bind_result($admin);
			$stmt->fetch();
			return $admin;
		}
?>