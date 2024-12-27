<?php
	include('dbconnection.php');

    function getRoomPrice_bytype($id){
        global $dbh;
        $response=array();
        $sql2 = "SELECT * from   tblcategory  where id='$id' ";
        $query2 = $dbh->query($sql2);
        // $query2->execute();
        // $result2=$query2->fetchAll(PDO::FETCH_ASSOC);
        if($query2->rowCount() >0){  //num rows
            $result2=$query2->fetch(PDO::FETCH_ASSOC);
            // print_r($result2);
            return $result2['Price'];
        }else{
            return '';
        }    
    }

    function checkRoomNoAbility($room_no,$id=''){
        global $dbh;
        if(!empty($id)){
            $ssql=" AND `ID`!='$id' ";
        }else{
            $ssql='';
        }
        $sql="SELECT `ID` from `tblroom` where `RoomNo`='$room_no' $ssql ";
        $query=$dbh->prepare($sql);
        $query->bindParam(':room_no',$room_no,PDO::PARAM_STR);
		$query->execute();
        // $result2=$query->fetch(PDO::FETCH_ASSOC);
        if($query->rowCount() >0){  //num rows
            return 1;
        }else{
            return 0;
        }    
    }
    function getCompanyDetails(){
        global $dbh;
        $response=array();
        $sql="SELECT * from `tbladmin` where 1 limit 1";
        $query=$dbh->prepare($sql);
        $query->execute();
        $res=$query->fetch(PDO::FETCH_ASSOC);
        // print_r($res);
        $response['CompanyName']=$res['CompanyName'];
        $response['AdminName']=$res['AdminName'];
        
        $response['MobileNumber']=$res['MobileNumber'];
        $response['Email']=$res['Email'];
        $response['Address']=$res['Address'];
        $response['Pin']=$res['Pin'];
        $response['State']=$res['State'];
        $response['Logo']=$res['Logo'];
        $response['Logo_path']=!empty($res['Logo']) ? 'images/admin/'.$res['Logo'] : '';
        $response['Address']=$res['Address'];

        if($query->rowCount() >0){  //num rows
            return $response;
        }else{
            return $response;
        }    
    }
    function getCategory($id){
        global $dbh;
        $response=array();
        $sql="SELECT * from `tblcategory` where `ID`='$id' ";
        $query=$dbh->prepare($sql);
        $query->execute();
        $res=$query->fetch(PDO::FETCH_ASSOC);
        
            $response['Price']=$res['Price'];
            $response['CategoryName']=$res['CategoryName'];
       

        if($query->rowCount() >0){  //num rows
            return $response;
        }else{
            return $response;
        }    
    }
    // echo getCategory(4)['Price'];
    function getPricebyRoomId($id){
        global $dbh;
        $roomprice=array();
        $sql="SELECT `RoomType` from `tblroom` where ID IN ($id)";
        $query=$dbh->prepare($sql);
        $query->execute();
        $res=$query->fetchAll(PDO::FETCH_OBJ);
        // print_r($res);
              foreach($res as $r){
            $roomprice[]=getCategory($r->RoomType)['Price'];
        }
        if($query->rowCount() >0){  //num rows
            return array_sum($roomprice);
        }else{
            return '';
        }    
    }