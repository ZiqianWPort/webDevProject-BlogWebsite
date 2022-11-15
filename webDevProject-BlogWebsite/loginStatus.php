<?php
    // function to login user, takes in username
    function login($username) {
        // start session if not started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        // get user id from database
        require 'database.php';
        $stmt = $mysqli->prepare("select id from users where username=?");
        if(!$stmt){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->bind_result($id);
        $stmt->fetch();
        // set session variable
        $_SESSION['id'] = $id;
    }

    // function to check if user is logged in
    function isLoggedIn() {
        // start session if not started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        // check if session variable is set
        if (isset($_SESSION['id'])) {
            return true;
        } else {
            return false;
        }
    }

    // function to get user id
    function getUserId() {
        // start session if not started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        // check if session variable is set
        if (isset($_SESSION['id'])) {
            return $_SESSION['id'];
        } else {
            return false;
        }
    }

    // function to get username
    function getUsername() {
        // start session if not started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        require 'database.php';
        // check if session variable is set
        if (isset($_SESSION['id'])) {
            // get user id from database
            $stmt = $mysqli->prepare("select username from users where id=?");
            if(!$stmt){
                printf("Query Prep Failed: %s\n", $mysqli->error);
                exit;
            }
            $stmt->bind_param('i', $_SESSION['id']);
            $stmt->execute();
            $stmt->bind_result($username);
            $stmt->fetch();
            return $username;
        } else {
            return false;
        }
    }

    // function to get user nickname
    function getNickname() {
        // start session if not started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        require 'database.php';
        // check if session variable is set
        if (isset($_SESSION['id'])) {
            // get user id from database
            $stmt = $mysqli->prepare("select nickname from users where id=?");
            if(!$stmt){
                printf("Query Prep Failed: %s\n", $mysqli->error);
                exit;
            }
            $stmt->bind_param('i', $_SESSION['id']);
            $stmt->execute();
            $stmt->bind_result($nickname);
            $stmt->fetch();
            return $nickname;
        } else {
            return false;
        }
    }





?>