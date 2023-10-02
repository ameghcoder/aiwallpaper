<?php
include_once '../SDC.php';

if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])){
    $from_where = $_GET["id"];
    $till_where = $_GET["number"];
    if($from_where == 1){
        $from_where = 0;
    } else{
        $from_where = $from_where + 1;
    }
    $query = "SELECT * FROM wallpaperaccess ORDER BY 1 DESC LIMIT $till_where OFFSET $from_where";
    $res = mysqli_query($connection, $query);
    $num = mysqli_num_rows($res);
    $res_row = mysqli_fetch_all($res);
    $html = "";
    for($i = 0; $i < $num; $i++){
        $SNo = $i + $from_where;
        $Id = $res_row[$i][0];
        $ping_status_html = "";

        $_query_bingping = "SELECT status FROM bingpingid WHERE wall_id=$Id";
        $URL = $res_row[$i][2];
        $Name = explode('/', $res_row[$i][3])[2];
        $Name = str_replace('-', ' ', $Name);
        $html .= '<tr class="table-data-row" data-serial-number="'.$SNo.'">
            <td>'.$SNo.'</td>
            <td style="font-family: monospace;">'.$Id.'</td>
            <td class="wall-name">'.$Name.'</td>
            <td data-id="'.$Id.'" class="edit-wall-btn"><i data-id="'.$Id.'" class="icon-nes icon-settings edit-wall"></i></td>
            <td data-id="'.$Id.'" class="delete-wall-btn"><i data-id="'.$Id.'" class="icon-nes icon-settings delete"></i></td>
            <td class="image-path" hidden>'.$URL.'</td>
        </tr>';
    }
    echo $html;
}else if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["specific_id"])){
    $_id = $_GET["specific_id"];
    $query = "SELECT * FROM wallpaperaccess WHERE id=$_id";
    $res = mysqli_query($connection, $query);    
    $res_row = mysqli_fetch_all($res);
    $data_in_json = json_encode($res_row[0]);
    print_r($data_in_json);
}else if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["specific_id_desc"])){
    $_id = $_GET["specific_id_desc"];
    $_query = "SELECT wall_desc FROM wallpaperaccessdesc WHERE wall_id=$_id";
    $_res = mysqli_query($connection, $_query);
    $_res = mysqli_fetch_row($_res);
    if($_res || $_res != null){
        $data_in_json = json_encode($_res[0]);
        print_r($data_in_json);
    }
}

?>