<?php
  require_once('../connect.php');
  require_once('../../fb.php');

  function get_user($user_id) {
    global $db;
    $query = "SELECT * FROM Users WHERE id=" . $user_id;

    $sql_result = $db->query($query);
    $row = mysqli_fetch_row($sql_result);
    if (!is_null($row)) {
      $result = array();
      $result["id"] = $row[0];
      $result["first_name"] = $row[1];
      $result["last_name"] = $row[2];
      $result["email"] = $row[3];
      $result["role"] = $row[5];
      $result["score"] = $row[6];
      $result["created_at"] = $row[7];
      $result["updated_at"] = $row[8];

      return $result;
    } else {
      return false;
    }
  }

  // function authenticate_user($email, $password) {
  //   global $db;
  //   $query = "SELECT password FROM Users WHERE email='" . $email . "'";
  //
  //   $sql_result = $db->query($query);
  //   $row = mysqli_fetch_row($sql_result);
  //   if (!is_null($row)) {
  //     $saved_password = $row[0];
  //     return password_verify($password, $saved_password);
  //   } else {
  //     return false;
  //   }
  // }

  function authenticate_user($id, $token) {
    global $fb;

    try {
      // Returns a `Facebook\FacebookResponse` object
      $response = $fb->get('/me?fields=first_name,last_name,email', $token);
      session_start();
    } catch(Exception $e) {
      return null;
    }
  }


    function get_all_users() {
      global $db;
      $query = "SELECT * FROM Users";

      $sql_result = $db->query($query);
      $result = array();
      while (($row = mysqli_fetch_row($sql_result)) != null) {
        $user = array();
        $user["id"] = $row[0];
        $user["first_name"] = $row[1];
        $user["last_name"] = $row[2];
        $user["email"] = $row[3];
        $user["role"] = $row[5];
        $user["score"] = $row[6];
        $user["created_at"] = $row[7];
        $user["updated_at"] = $row[8];
        // Push user into array
        $result[] = $user;
      }
      return $result;
    }

    function get_users_for_search_results() {
      global $db;
      $query = "SELECT id, first_name, last_name FROM Users";

      $sql_result = $db->query($query);
      $result = array();
      while (($user_details = mysqli_fetch_assoc($sql_result)) != null) {
        $result[] = $user_details;
      }
      return $result;
    }

    function create_user($id, $token) {
      global $db;
      global $fb;

      try {
        // Returns a `Facebook\FacebookResponse` object
        $response = $fb->get('/me?fields=first_name,last_name,email', $token);
        session_start();
      } catch(Exception $e) {
        return null;
      }
      $user = $response->getGraphUser();
      $first_name = $user['first_name'];
      $last_name = $user['last_name'];
      $email = $user['email'];

      $query = "INSERT INTO Users (id, first_name, last_name, email, role, score)
                VALUES (" . intval($id) . ", '$first_name', '$last_name',
                '$email', 0, 0)";
      $db->query($query);

      $result = array();
      $result['id'] = $id;
      $result['first_name'] = $first_name;
      $result['last_name'] = $last_name;
      $result['email'] = $email;
      $result['role'] = 0;
      $result['score'] = 0;

      return $result;
    }
 ?>
