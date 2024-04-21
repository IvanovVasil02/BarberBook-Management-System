<?php
require_once '../db/connection.php';
$data = $_REQUEST['data'];
$conn = dbConnect();
$sql = "SELECT orario FROM `appuntamenti` WHERE `data` = '". strip_tags($data)."'";
$stm = $conn->query($sql);
if(!($stm->rowCount() > 0)){
    return json_encode([]);
}

$orari = array_map(function($item){ return $item["orario"];}, $stm->fetchAll(PDO::FETCH_ASSOC));

$ids = array_filter(array_map(function($orario){
    $ids = [
        "08:00:00" => 1,
        "09:00:00" => 2,
        "10:00:00" => 3,
        "11:00:00" => 4,
        "12:00:00" => 5,
        "13:00:00" => 6,
        "14:00:00" => 7,
        "15:00:00" => 8,
        "16:00:00" => 9,
        "17:00:00" => 10,
        "18:00:00" => 11,
        "19:00:00" => 12,
    ];
    return array_key_exists($orario, $ids)? $ids[$orario] : null;
}, $orari), function($id){
    return $id;
});

echo json_encode($ids);
?>