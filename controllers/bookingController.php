<?php
function bookDate()
{
    $result = [
        'success' => 1,
        'msg' => ''
    ];

    try {
        $conn = dbConnect();
        $sql = 'INSERT INTO appuntamenti (id_utente, data, orario) VALUES (?, ?, ?)';
        $stm = $conn->prepare($sql);
        $res = $stm->execute([getUserId(), $_POST['data'], $_POST['orario']]);

        if ($res) {
            $result['success'] = 1;
            $result['msg'] = 'Appointment booked!';
        } else {
            $result['msg'] = "There was an error in the booking";
            $result['success'] = 0;
        }
    } catch (Exception $e) {
        $result['success'] = 0;
        $result['msg'] = $e->getMessage();
    }

    return $result;
}
