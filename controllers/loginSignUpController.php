<?php
function verifyDataSignUp()
{

    $result = [
        'success' => 1,
        'msg' => ''
    ];



    $nome = strip_tags($_POST['nome']);
    $email = strip_tags($_POST['email']);
    $numero = strip_tags($_POST['numero']);
    $password = strip_tags($_POST['password']);


    if (!$nome) {
        $result['success'] = 0;
        $result['msg'] .= 'Missing name field.';
    }

    if (!$email) {
        $result['success'] = 0;
        $result['msg'] .= 'Missing email field.';
    } else {

        $email = filter_var($email, FILTER_VALIDATE_EMAIL);
        if (!$email) {
            $result['success'] = 0;
            $result['msg'] .= 'Invalid email address.';
        }
    }



    if (!$password || strlen($password) < 8) {
        $result['success'] = 0;
        $result['msg'] .= 'The password must contain at least 8 characters';
    }

    if (!$numero && strlen($numero) < 10) {
        $result['success'] = 0;
        $result['msg'] .= 'The telephone number entered is invalid.';
    }

    $result['nome'] = $nome;
    $result['email'] = $email;
    $result['numero'] = $numero;
    $result['password'] = $password;

    return $result;
}

function verifyDataLogin()
{

    $result = [
        'success' => 1,
        'msg' => ''
    ];

    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($email)) {
        $result['success'] = 0;
        $result['msg'] .= 'An email address is required.';
        return $result;
    }
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);

    if (!$email) {
        $result['success'] = 0;
        $result['msg'] .= 'Invalid email address.';
        return $result;
    }


    if (!$password || strlen($password) < 8) {
        $result['success'] = 0;
        $result['msg'] .= 'The password must contain at least 8 characters';
    }


    $result['email'] = $email;
    $result['password'] = $password;

    return $result;
}

function signUp()
{
    $result = verifyDataSignUp();

    if ($result['success']) {

        $res = insertUser($result['nome'], $result['email'], $result['numero'], $result['password']);
        if ($res['success']) {
            $_SESSION['userloggedin'] = 1;
            $_SESSION['email'] = $result['email'];
        }
        return $res;
    } else {
        return $result;
    }
}

function insertUser($nome, $email, $numero, $password)
{
    $result = [
        'success' => 1,
        'msg' => ''
    ];


    try {
        $conn = dbConnect();
        $sql2 = 'SELECT email FROM utenti WHERE email=:email';
        $stm = $conn->prepare($sql2);
        $res = $stm->execute([':email' => $email]);

        if ($res) {
            if ($stm->rowCount() > 0) {
                $result['msg'] = 'There is already a registered user with this email.';
                $result['success'] = 0;
                return $result;
            }
        } else {
            $result['msg'] = 'Error reading users table';
            $result['success'] = 0;
            return $result;
        }

        $sql = 'INSERT INTO utenti (nome, email, numero, password) VALUES (:nome, :email, :numero, :password)';
        $stm = $conn->prepare($sql);
        $password = password_hash($password, PASSWORD_DEFAULT);
        $res = $stm->execute([':nome' => $nome, ':email' => $email, ':numero' => $numero, ':password' => $password]);
        if ($res && $stm->rowCount()) {
            $result['msg'] = 'User Registered Successfully!';
            return $result;
        } else {
            $result['msg'] = 'There was a problem registering';
            $result['success'] = 0;
        }
    } catch (Exception $e) {
        $result['success'] = 0;
        $result['msg'] = $e->getMessage();
    }

    return $result;
}

function login()
{
    $result = verifyDataLogin();

    if ($result['success']) {
        $res = verifyUserLogin($result['email'], $result['password']);

        if ($res['success']) {
            $_SESSION['userloggedin'] = 1;
            $_SESSION['email'] = $result['email'];
            $_SESSION['id'] = $res['data']['id'];
        }

        return $res;
    } else {
        return $result;
    }
}

function verifyUserLogin($email, $password)
{
    $result = [
        'success' => 1,
        'msg' => 'Login successful',
        'data' => ''
    ];

    try {
        $conn = dbConnect();
        $sql = "SELECT * FROM utenti WHERE email= :email";
        $stm = $conn->prepare($sql);
        $res = $stm->execute([':email' => $email]);

        if ($res && $stm->rowCount() > 0) {
            $row = $stm->fetch(PDO::FETCH_ASSOC);
            $result['data'] = $row;
            if (!password_verify($password, $row['password'])) {
                $result['success'] = 0;
                $result['msg'] = "The data entered does not match.";
            }
        } else {
            $result['success'] = 0;
            $result['msg'] = ' dati inseriti non combaciano';
        }

        return $result;
    } catch (Exception $e) {
        $result['success'] = 0;
        $result['msg'] = $e->getMessage();
    }

    return $result;
}

function adminAccess()
{
    $result = verifyDataLogin();

<<<<<<< HEAD

    if ($result['success']) {
        $res = verifyAdminLogin($result['email'], $result['password']);



        if ($res['success'] && $res['admin']) {
=======
    if ($result['success']) {
        $res = verifyAdminLogin($result['email'], $result['password']);

        if ($res['admin']) {
>>>>>>> BarberBook-A-Barber-Appointment-Management-System
            $_SESSION['adminloggedin'] = 1;
            $_SESSION['email'] = $result['email'];
            $_SESSION['id'] = $res['data']['id'];
        }

        return $res;
    } else {
        return $result;
    }
}


function verifyAdminLogin($email, $password)
{
    $result = [
        'admin' => 1,
<<<<<<< HEAD
        'msg' => 'Login successful',
        'data' => '',
        'success' => 1
=======
        'msg' => 'Login effetuato con successo',
        'data' => ''
>>>>>>> BarberBook-A-Barber-Appointment-Management-System
    ];

    try {
        $conn = dbConnect();
        $sql = "SELECT * FROM utentiadmin WHERE email= :email";
        $stm = $conn->prepare($sql);
        $res = $stm->execute([':email' => $email]);

        if ($res && $stm->rowCount() > 0) {
            $row = $stm->fetch(PDO::FETCH_ASSOC);
            $result['data'] = $row;
            if (!password_verify($password, $row['password'])) {
                $result['success'] = 0;
<<<<<<< HEAD
                $result['admin'] = 0;
                $result['msg'] = 'Data no fight';
            }
        } else {
            $result['success'] = 0;
            $result['admin'] = 0;
            $result['msg'] = 'Data no fight';
=======
                $result['msg'] = "I dati inseriti non combaciano.";
            }
        } else {
            $result['success'] = 0;
            $result['msg'] = ' dati inseriti non combaciano';
>>>>>>> BarberBook-A-Barber-Appointment-Management-System
        }

        return $result;
    } catch (Exception $e) {
        $result['success'] = 0;
<<<<<<< HEAD
        $result['admin'] = 0;
=======
>>>>>>> BarberBook-A-Barber-Appointment-Management-System
        $result['msg'] = $e->getMessage();
    }

    return $result;
}


function logout()
{
    session_destroy();
    return 1;
}
