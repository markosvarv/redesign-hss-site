<?php 
	include_once('_session.php');
	$action = $_GET['a'];


	if( !in_array($action, ['login', 'register', 'update', 'logout'])){
		echo 'Invalid Action!';
		return;
	}

	function login($conn, $email, $password){
		if($email==''||$password==''){
			$_SESSION['flush']['error'] = 'Παρακαλώ συμπληρώστε όλα τα πεδία!';
			return false;
		}
		$res = $conn->prepare("SELECT id FROM users WHERE email = :email AND password = :password LIMIT 1");
		$res->execute(array(':email' => $email, ':password' => hash('sha256', $password) ));
		if ($res->rowCount() == 1){
			$result =  $res->fetchAll(PDO::FETCH_ASSOC);
			$_SESSION["user_id"] = $result[0]['id'];
			return true;
		}else{
			return false;
		}
	}

	function register($conn, $firstName, $lastName, $email, $password, $passwordConfirmation, $birthday, $amka, $address, $phone){
		if($firstName==''||$lastName==''||$email==''||$password==''||$birthday==''||$passwordConfirmation==''||$amka==''){
			$_SESSION['flush']['error'] = 'Παρακαλώ συμπληρώστε όλα τα πεδία!';
			return false;
		}
		if($password!=$passwordConfirmation){
			$_SESSION['flush']['error'] = 'Οι κωδικοί δεν ταιριάζουν!';
			return false;
		}
		$res = $conn->prepare("SELECT id FROM users WHERE email = :email LIMIT 1");
		$res->execute(array(':email' => $email ));
		if ($res->rowCount() == 1){
			$_SESSION['flush']['error'] = 'Αυτό το email υπάρχει ήδη!';
			return false;
		}
		$res = $conn->prepare("SELECT id FROM users WHERE amka = :amka LIMIT 1");
		$res->execute(array(':amka' => $amka ));
		if ($res->rowCount() == 1){
			$_SESSION['flush']['error'] = 'Αυτό το ΑΜΚΑ υπάρχει ήδη!';
			return false;
		}

		$res = $conn->prepare("INSERT INTO users (firstName, lastName, email, password, birthday, amka, address, phone) VALUES (:fName, :lName, :email, :password, :birthday, :amka, :address, :phone)");
		$res->execute(array(':email' => $email, ':password' => hash('sha256', $password), ':fName' => $firstName, ':lName' => $lastName, ':amka' => $amka, ':address' => $address, ':phone' => $phone, ':birthday' => $birthday));
		if ($res->rowCount() == 1){
			return true;
		}else{
			return false;
		}
	}

	function update($conn, $firstName, $lastName, $email, $password, $passwordConfirmation, $birthday, $amka, $address, $phone){
		global $user;
		if($email==''||$address==''){
			$_SESSION['flush']['error'] = 'Παρακαλώ συμπληρώστε τα απαραίτητα πεδία!';
			return false;
		}
		if($password!='' and $password!=$passwordConfirmation){
			$_SESSION['flush']['error'] = 'Οι κωδικοί δεν ταιριάζουν!';
			return false;
		}
		if ($password!='') {
			$res = $conn->prepare("SELECT id FROM users WHERE id = :id AND password = :password LIMIT 1");
			$res->execute(array(':id' => $id, ':password' => hash('sha256', $password) ));
			if ($res->rowCount() == 0){
				$_SESSION['flush']['error'] = 'O υπάρχων κωδικός είναι λάθος!';
				return false;
			}	
		}

		if($user["email"] != $email){
			$res = $conn->prepare("SELECT id FROM users WHERE email = :email LIMIT 1");
			$res->execute(array(':email' => $email ));
			if ($res->rowCount() == 1){
				$_SESSION['flush']['error'] = 'Αυτό το email υπάρχει ήδη!';
				return false;
			}
		}

		if($password!=''){
			$res = $conn->prepare("UPDATE users  SET email = :email, password = :password, address = :address, phone = :phone WHERE id = :id");
			$res->execute(array(':id' => $user["id"], ':email' => $email, ':password' => hash('sha256', $password), ':address' => $address, ':phone' => $phone));
		}else{
			$res = $conn->prepare("UPDATE users  SET email = :email, address = :address, phone = :phone WHERE id = :id");
			$res->execute(array(':id' => $user["id"] ,':email' => $email, ':address' => $address, ':phone' => $phone));
		}
		if ($res->rowCount() == 1){
			return true;
		}else{
			return false;
		}
	}



	function logout(){
		unset($_SESSION["user_id"]);
		session_unset();
	}

	if($action == "login" && $_SERVER['REQUEST_METHOD'] == 'POST'){
		foreach($_POST as $p_key => $p_value){
			$_SESSION["login_".$p_key] = $p_value;
		}
		if (login($conn, $_POST['email'], $_POST['password'])){
			if(isset($_SESSION['last_page'])){
				header("Location: ".$_SESSION['last_page']);
			}else{
				header("Location: /home.php");
			}
			die();
		}else{
			$_SESSION['flush']['error'] = "Τα στοιχεία σύνδεσης είναι λάθος!";
			header("Location: /auth/login.php");
			die();
		}
	}elseif ($action == "register" && $_SERVER['REQUEST_METHOD'] == 'POST') {
		foreach($_POST as $p_key => $p_value){
			$_SESSION["register_".$p_key] = $p_value;
		}
		if (register($conn, $_POST['firstName'], $_POST['lastName'], $_POST['email'], $_POST['password'], $_POST['passwordConfirmation'], $_POST['birthday'], $_POST['amka'], $_POST['address'], $_POST['phone'])){
			$_SESSION['flush']['success'] = "Επιτυχής εγγραφή!Τώρα μπορείτε να συνδεθείτε!";
			header("Location: /auth/login.php");
			die();
		}else{
			header("Location: /auth/register.php");
			die();
		}
	}elseif ($action == "update" && $_SERVER['REQUEST_METHOD'] == 'POST') {
		if (isset($user)){
			if (update($conn, $_POST['firstName'], $_POST['lastName'], $_POST['email'], $_POST['password'], $_POST['passwordConfirmation'], $_POST['birthday'], $_POST['amka'], $_POST['address'], $_POST['phone'])){
				$_SESSION['flush']['success'] = "Επιτυχής αποθήκευση!";
			}
			header("Location: /auth/editprofile.php");
			die();
		}else{
			$_SESSION['flush']['error'] = "Παρακαλώ συνδεθείτε πρώτα!";
			header("Location: /auth/login.php");
			die();
		}
	}elseif ($action == "logout" && $_SERVER['REQUEST_METHOD'] == 'GET') {
		logout();
		header("Location: /");
		die();
	}
?>