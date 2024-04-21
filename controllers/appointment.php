<?php
    require_once 'db/connection.php';

    function myAppointments(int $id_utente){
        if(!$id_utente){
            $id_utente = getUserId();
        }

        $res = [
            'data' => [],
            'msg' => ''
        ];


        try { 

            $conn = dbConnect();
            
            $sql = 'SELECT nome, data, orario FROM appuntamenti as a INNER JOIN';
            $sql .=' utenti as u on a.id_utente = u.id WHERE u.id = ?';
            $sql .=' ORDER by data AND orario desc';

                $stm = $conn->prepare($sql);
                $stm->execute([getUserId()]);
           
            $res['data'] = $stm->fetchAll(PDO::FETCH_ASSOC);
          
    
        }catch(Exception $e){
            $res['msg'] = $e->getMessage();
           
        }
    
        return $res; 
    }

    function adminAppointments(){

        $res = [
            'data' => [],
            'msg' => ''
        ];


        try { 

            $conn = dbConnect();
            
            $sql = 'SELECT nome, numero, data, orario FROM appuntamenti AS a INNER JOIN utenti as u';
            $sql .=' ORDER by data AND orario desc';

                $stm = $conn->query($sql);
           
            $res['data'] = $stm->fetchAll(PDO::FETCH_ASSOC);
          
    
        }catch(Exception $e){
            $res['msg'] = $e->getMessage();
           
        }
    
        return $res; 
    }

    
    function checkTime ($orario){

        $result = [
            'success' => 1,
            'msg' => '', 
            'class' => ''
        ];

        try { 

            $conn = dbConnect();
            
            $sql = 'SELECT orario FROM appuntamenti WHERE orario = $orario';

            $stm = $conn->query($sql);
            $count = $stm->fetchColumn();

            if($count > 0){
                $result['class'] = 1;
            }else{
                $result['class'] = 0;
            }
    
        }catch(Exception $e){
            $result['success'] = 0;
            $result['msg'] = $e->getMessage();
           

        }


        return $result; 
    }



?>