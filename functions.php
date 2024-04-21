<?php 
function isValidToken($token){
    return $token === $_SESSION['csrf']; 
}

function isUserLoggedIn() {
    return $_SESSION['userloggedin'] ?? 0;
} 

function AdminLoggedIn() {
    return $_SESSION['adminloggedin'] ?? 0;
}

function getUserEmail(){
    return $_SESSION['email'] ?? '';
}

function getUserId() {
    return $_SESSION['id'] ?? 0;
}


function getbookingTpl(array $appointment){

    $orario = $appointment['orario'];
    $datetime = new DateTime($orario);
    $orario =  $datetime->format('H:i');
    
    $htmlAppointment ='
    <tr>
        <td>'. $appointment['nome'] .'</td>
        <td>'. date('d-m-Y', strtotime($appointment['data'])) .'</td>
        <td>'. $orario .'</td>
    </tr>';

    return $htmlAppointment; 
    
}

function getAllbookings(array $appointment){

    $orario = $appointment['orario'];
    $datetime = new DateTime($orario);
    $orario =  $datetime->format('H:i');
    
    $htmlAppointment = '
    <tr>
        <td>'. $appointment['nome'] .'</th>
        <td>'. $appointment['numero'] .'</th>
        <td>'. date('d-m-Y', strtotime($appointment['data'])) .'</td>
        <td>'. $orario .'</td>
    </tr>';

    return $htmlAppointment; 
    
}

function getTimeBtnTpl(array $timeClass){

    $btnClass = $timeClass['class']?'danger':'primary';

    return $btnClass; 
}

?>
