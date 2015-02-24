<?php

function redirect_to($new_location) {
	header("Location: " . $new_location);
	exit;
}

function datetime_to_text($datetime = "") {
	$unixdatetime = strtotime($datetime);
	return strftime("%B %d, %Y at %I:%M %p", $unixdatetime);
}

function mysql_prep($string) {
	global $connection;
	$escaped_string = mysqli_real_escape_string($connection, $string);
	return $escaped_string;
}

function confirm_query($result_set) {
	if(!$result_set) {
		die("Database query failed.");
	}
}

function form_errors($errors = array()) {
	$output = "";
	if(!empty($errors)) {
		$output = "<div class=\"alert alert-info alert-dismissible\" role=\"alert\">";
		$output .= "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">";
		$output .= "<span aria-hidden=\"true\">&times;</span>";
		$output .= "<span class=\"sr-only\"></span>";
		$output .= "</button>";
		$output .= "</ul>";
		foreach($errors as $key => $error) {
			$output .= "<li>";
			$output .= htmlentities($error);
			$output .= "</li>";
		}
		$output .= "</ul>";
		$output .= "</div>";
	}
	return $output;
}

function find_all_patients() {
	global $connection;
	$query = "SELECT * ";
	$query .= " FROM Patients ";
	$query .= " ORDER BY firstname ASC";
	$patient_set = mysqli_query($connection, $query);
	confirm_query($patient_set);
	return $patient_set;
}

function find_patient_by_id($user_id) {
	global $connection;
	$safe_user_id = mysqli_real_escape_string($connection, $user_id);
	$query        = "SELECT * ";
	$query .= " FROM Patients ";
	$query .= " WHERE id = {$safe_user_id} ";
	$query .= " LIMIT 1";
	$user_set = mysqli_query($connection, $query);
	confirm_query($user_set);
	if($user = mysqli_fetch_assoc($user_set)) {
		return $user;
	} else {
		return NULL;
	}
}

function find_user_by_username($username) {
	global $connection;
	$safe_username = mysqli_real_escape_string($connection, $username);
	$query         = "SELECT * ";
	$query .= " FROM Patients ";
	$query .= " WHERE username = '{$safe_username}' ";
	$query .= " LIMIT 1";
	$user_set = mysqli_query($connection, $query);
	confirm_query($user_set);
	if($user = mysqli_fetch_assoc($user_set)) {
		return $user;
	} else {
		return NULL;
	}
}

function find_health_by_id($health_id) {
	global $connection;
	$safe_health_id = mysqli_real_escape_string($connection, $health_id);
	$query          = "SELECT * ";
	$query .= " FROM Health ";
	$query .= " WHERE id = {$safe_health_id} ";
	$query .= " LIMIT 1";
	$health_set = mysqli_query($connection, $query);
	confirm_query($health_set);
	if($health = mysqli_fetch_assoc($health_set)) {
		return $health;
	} else {
		return NULL;
	}
}

function find_patients_for_doctor($doctor_id) {
	global $connection;
	$query = "SELECT * ";
	$query .= " FROM Patients ";
	$query .= " WHERE doctor_id = {$doctor_id}";
	$patient_set = mysqli_query($connection, $query);
	confirm_query($patient_set);
	return $patient_set;
}

function find_health_by_user_id($id) {
	global $connection;
	$query = "SELECT * ";
	$query .= "FROM Health ";
	$query .= "WHERE patient_id = {$id} ";
	$query .= "ORDER BY date DESC";
	$user_set = mysqli_query($connection, $query);
	confirm_query($user_set);
	return $user_set;
}

function doctor_authenticate($username, $password) {
	global $connection;
	$safe_username = mysqli_real_escape_string($connection, $username);
	$safe_password = mysqli_real_escape_string($connection, $password);
	$query         = "SELECT * ";
	$query .= " FROM Doctors ";
	$query .= " WHERE username = '{$safe_username}' ";
	$query .= " AND password = '{$safe_password}' ";
	$query .= " LIMIT 1";
	$user_set = mysqli_query($connection, $query);
	confirm_query($user_set);
	if($user = mysqli_fetch_assoc($user_set)) {
		if($user["username"] === $username && $user["password"] === $password) {
			return $user;
		} else {
			return FALSE;
		}
	} else {
		return NULL;
	}
}

function patient_signned_in() {
	return isset($_SESSION['patient_id']);
}

function confirm_patient_signned_in() {
	if(!patient_signned_in()) {
		redirect_to("index.php");
	}
}

function doctor_signned_in() {
	return isset($_SESSION['doctor_id']);
}

function confirm_doctor_signned_in() {
	if(!doctor_signned_in()) {
		redirect_to("index.php");
	}
}

function calculate_women($age, $ldl_c, $cholesterol, $hdl_c, $systolic, $diastolic, $db, $smoker) {
	$total_point = 0;
	if($age > 30 && $age < 34) {
		$total_points += -9;
	}
	if($age > 35 && $age < 39) {
		$total_points += -4;
	}
	if($age > 40 && $age < 44) {
		$total_points += 0;
	}
	if($age > 45 && $age < 49) {
		$total_points += 3;
	}
	if($age > 50 && $age < 54) {
		$total_points += 6;
	}
	if($age > 55 && $age < 59) {
		$total_points += 7;
	}
	if($age > 60 && $age < 64) {
		$total_points += 8;
	}
	if($age > 65 && $age < 69) {
		$total_points += 8;
	}
	if($age > 70 && $age < 74) {
		$total_points += 8;
	}
	if($ldl_c < 100) {
		$total_points += -2;
	}
	if($ldl_c > 100 && $age < 159) {
		$total_points += 0;
	}
	if($ldl_c > 160 && $age < 190) {
		$total_points += 2;
	}
	if($ldl_c >= 190) {
		$total_points += 2;
	}
	if($cholesterol < 160) {
		$total_points += -2;
	}
	if($cholesterol > 160 && $cholesterol < 199) {
		$total_points += 0;
	}
	if($cholesterol > 200 && $cholesterol < 239) {
		$total_points += 1;
	}
	if($cholesterol > 240 && $cholesterol < 279) {
		$total_points += 1;
	}
	if($cholesterol >= 280) {
		$total_points += 3;
	}
	if($hdl_c < 35) {
		$total_points += 5;
	}
	if($hdl_c > 35 && $hdl_c < 44) {
		$total_points += 2;
	}
	if($hdl_c > 45 && $hdl_c < 49) {
		$total_points += 1;
	}
	if($hdl_c >= 60) {
		$total_points += -2;
	}
	if($systolic > 130 && $systolic < 139 && $diastolic > 85 && $diastolic < 89) {
		$total_points += -3;
	}
	if($systolic > 140 && $systolic < 159 && $diastolic > 90 && $diastolic < 99) {
		$total_points += 2;
	}
	if($systolic >= 160 && $diastolic >= 100) {
		$total_points += 3;
	}
	if($db == 1) {
		$total_points += 4;
	}
	if($smoker == 1) {
		$total_points += 2;
	}
	return $total_points;
}

function calculate_men($age, $ldl_c, $cholesterol, $hdl_c, $systolic, $diastolic, $db, $smoker) {
	$total_point = 0;
	if($age > 30 && $age < 34) {
		$total_points += -1;
	}
	if($age > 35 && $age < 39) {
		$total_points += 0;
	}
	if($age > 40 && $age < 44) {
		$total_points += 1;
	}
	if($age > 45 && $age < 49) {
		$total_points += 2;
	}
	if($age > 50 && $age < 54) {
		$total_points += 3;
	}
	if($age > 55 && $age < 59) {
		$total_points += 4;
	}
	if($age > 60 && $age < 64) {
		$total_points += 5;
	}
	if($age > 65 && $age < 69) {
		$total_points += 6;
	}
	if($age > 70 && $age < 74) {
		$total_points += 7;
	}
	if($ldl_c < 100) {
		$total_points += -3;
	}
	if($ldl_c > 100 && $age < 159) {
		$total_points += 0;
	}
	if($ldl_c > 160 && $age < 190) {
		$total_points += 1;
	}
	if($ldl_c >= 190) {
		$total_points += 2;
	}
	if($cholesterol < 160) {
		$total_points += -3;
	}
	if($cholesterol > 160 && $cholesterol < 199) {
		$total_points += 0;
	}
	if($cholesterol > 200 && $cholesterol < 239) {
		$total_points += 1;
	}
	if($cholesterol > 240 && $cholesterol < 279) {
		$total_points += 2;
	}
	if($cholesterol >= 280) {
		$total_points += 3;
	}
	if($hdl_c < 35) {
		$total_points += 2;
	}
	if($hdl_c > 35 && $hdl_c < 44) {
		$total_points += 1;
	}
	if($hdl_c > 45 && $hdl_c < 59) {
		$total_points += 0;
	}
	if($hdl_c >= 60) {
		$total_points += -2;
	}
	if($systolic > 130 && $systolic < 139 && $diastolic > 85 && $diastolic < 89) {
		$total_points += 1;
	}
	if($systolic > 140 && $systolic < 159 && $diastolic > 90 && $diastolic < 99) {
		$total_points += 2;
	}
	if($systolic >= 160 && $diastolic >= 100) {
		$total_points += 3;
	}
	if($db) {
		$total_points += 2;
	}
	if($smoker) {
		$total_points += 2;
	}
	return $total_points;
}

function result($point) {
	$value = 0;
	if($point < -3) {
		$value = 1;
	}
	if($point == -2 || $point == -1) {
		$value = 2;
	}
	if($point == 0) {
		$value = 3;
	}
	if($point == 1 || $point == 2) {
		$value = 4;
	}
	if($point == 3) {
		$value = 6;
	}
	if($point == 4) {
		$value = 7;
	}
	if($point == 5) {
		$value = 9;
	}
	if($point == 6) {
		$value = 11;
	}
	if($point == 7) {
		$value = 14;
	}
	if($point == 8) {
		$value = 18;
	}
	if($point == 9) {
		$value = 22;
	}
	if($point == 10) {
		$value = 27;
	}
	if($point == 11) {
		$value = 33;
	}
	if($point == 12) {
		$value = 40;
	}
	if($point == 13) {
		$value = 47;
	}
	if($point >= 14) {
		$value = 56;
	}
	return $value;
}

function password_encrypt($password) {
	$hash_format = "$2y$10$";   // Tells PHP to use Blowfish with a "cost" of 10
	$salt_length = 22;   // Blowfish salts should be 22-characters or more
	$salt = generate_salt($salt_length);
	$format_and_salt = $hash_format . $salt;
	$hash = crypt($password, $format_and_salt);
	return $hash;
}

function generate_salt($length) {
	// Not 100% unique, not 100% random, but good enough for a salt
	// MD5 returns 32 characters
	$unique_random_string = md5(uniqid(mt_rand(), true));

	// Valid characters for a salt are [a-zA-Z0-9./]
	$base64_string = base64_encode($unique_random_string);

	// But not '+' which is valid in base64 encoding
	$modified_base64_string = str_replace('+', '.', $base64_string);

	// Truncate string to the correct length
	$salt = substr($modified_base64_string, 0, $length);

	return $salt;
}

function password_check($password, $existing_hash) {
	// existing hash contains format and salt at start
	$hash = crypt($password, $existing_hash);
	if ($hash === $existing_hash) {
		return true;
	} else {
		return false;
	}
}

function patient_authenticate($username, $password) {
	$user = find_user_by_username($username);
	if ($user) {
		// found admin, now check password
		if (password_check($password, $user["password"])) {
			// password matches
			return $user;
		} else {
			// password does not match
			return false;
		}
	} else {
		// admin not found
		return false;
	}
}

function reset_token() {
	return md5(uniqid(rand()));
}

function set_user_reset_token($username, $token_value) {
	global $connection;
	$user = find_user_by_username($username);
	if($user) {
		$id     = $user["id"];
		$query  = "UPDATE Patients SET token = '{$token_value}' WHERE id = {$id} LIMIT 1";
		$result = mysqli_query($connection, $query);
		if($result && mysqli_affected_rows($connection) == 1) {
			return TRUE;
		} else {
			return FALSE;
		}
	} else {
		return FALSE;
	}
}

function create_reset_token($username) {
	$token = reset_token();
	return set_user_reset_token($username, $token);
}

function delete_reset_token($username) {
	$token = NULL;
	return set_user_reset_token($username, $token);
}

function find_by_token($token = "") {
	global $connection;
	$query    = "SELECT * FROM Patients WHERE token = '{$token}' LIMIT 1";
	$user_set = mysqli_query($connection, $query);
	confirm_query($user_set);
	if($user = mysqli_fetch_assoc($user_set)) {
		return $user;
	} else {
		return NULL;
	}
}

function email_reset_token($username) {
	$user = find_user_by_username($username);
	if($user && isset($user["token"])) {
		$message = 'Hi ' . $user["firstname"] . ',

Please click on the link below to reset your password. Alternatively, copy the link below and paste it in your browser\'s address bar.

--------------------------------------------------------------------------------------------------------------------------------------
Password Reset Link: http://teamdelta.alishaikh.eu/reset_password.php?token=' . $user["token"] . '
--------------------------------------------------------------------------------------------------------------------------------------

If you did not make this request, you do not need to take any action. Your password cannot be changed without clicking the above link to verify the request.


Thank you
CVD Website';
		return mail($user["email"], 'Your Password', $message);
	} else {
		return FALSE;
	}
}

