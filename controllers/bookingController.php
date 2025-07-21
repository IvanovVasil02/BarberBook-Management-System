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


function editBooking()
{
    $result = [
        'success' => 0,
        'msg' => ''
    ];

    try {
        if (!isset($_POST['id'], $_POST['data'], $_POST['orario'])) {
            throw new Exception("Missing booking data");
        }

        $conn = dbConnect();
        $sql = 'UPDATE appuntamenti SET data = ?, orario = ? WHERE id = ? AND id_utente = ?';
        $stm = $conn->prepare($sql);

        $res = $stm->execute([
            $_POST['data'],
            $_POST['orario'],
            $_POST['id'],
            getUserId()
        ]);

        if ($res) {
            $result['success'] = 1;
            $result['msg'] = 'Booking updated successfully!';
        } else {
            $result['msg'] = 'Failed to update the booking.';
        }
    } catch (Exception $e) {
        $result['msg'] = $e->getMessage();
    }

    return $result;
}

function deleteBooking()
{
    $result = [
        'success' => 0,
        'msg' => ''
    ];

    try {
        if (!isset($_POST['id'])) {
            throw new Exception("Missing booking ID");
        }

        $conn = dbConnect();
        $sql = 'DELETE FROM appuntamenti WHERE id = ?';
        $stm = $conn->prepare($sql);

        $res = $stm->execute([
            $_POST['id']
        ]);

        if ($res) {
            $result['success'] = 1;
            $result['msg'] = 'Booking deleted successfully!';
        } else {
            $result['msg'] = 'Failed to delete the booking.';
        }
    } catch (Exception $e) {
        $result['msg'] = $e->getMessage();
    }

    return $result;
}
