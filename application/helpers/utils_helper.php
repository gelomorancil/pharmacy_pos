<?php 
function select_active($value1, $value2)
{
    return ($value1 == $value2) ? "selected='selected'" : "";
}

function disable_field($id)
{
    if ($id > 0)
    {
        return "readonly='readonly'";
    }
}

function user_module($user_modules, $module_ID, $permission)
{
    foreach($user_modules as $item)
    {
        if($item->Module_ID == $module_ID)
        {
            if ($item->$permission == 1)
            {
                return "checked='checked'";
            }
        }
    }
}

function format_date($date)
{
    $date = explode("-", $date);
    $month = $date[1];
    switch($date[1])
    {
        case "01":
            $month = "January";
            break;
        case "02":
            $month = "February";
            break;
        case "03":
            $month = "March";
            break;
        case "04":
            $month = "April";
            break;
        case "05":
            $month = "May";
            break;
        case "06":
            $month = "June";
            break;
        case "07":
            $month = "July";
            break;
        case "08":
            $month = "August";
            break;
        case "09":
            $month = "September";
            break;
        case "10":
            $month = "October";
            break;
        case "11":
            $month = "November";
            break;
        case "12":
            $month = "December";
            break;
    }

    return $month." ".$date[2].", ".$date[0];
}

function is_empty_object($obj){
    return $obj == new stdClass();
}

function socket_url()
{
    $ci =& get_instance();
    return $ci->config->item('socket_url');
}

function generate_random_integer(){
    return bin2hex(random_bytes(4));
}

function sidebar($sidebar=null, $realSidebar=null){
    //--NOTE--
    // Array values are key sensitive.
    $countSidebar = count($sidebar);
    $countrealSidebar = count($realSidebar);
    $flag = true;
    $counter = 0;
    $result = [];   
    
    if(empty($sidebar) || empty($realSidebar)){
        return false;
    }
    if($countrealSidebar==1 && @$sidebar[0] == @$realSidebar[0]){
        return true;
    }
    if($countrealSidebar==2 && @$sidebar[1] == @$realSidebar[1]){
        return true;
    }

    do{
        if ( ! isset($sidebar[$counter]) || ! isset($realSidebar[$counter]) ) {
            $sidebar[$counter] = null;
            $realSidebar[$counter] = null;
         }
        if($sidebar[$counter] == $realSidebar[$counter]){
            array_push($result, true);
        }else{
            array_push($result, false);
        }
        $counter++;
        if($counter == $countSidebar){
            $flag = false;
        }
    }while($flag);

    return count(array_keys($result, true)) == count($result);
}

/** user logs */ 
function user_logs($dataValue){    
        
    $CI =& get_instance();
    $secret_key = $CI->config->item('encryption_key');
    $table = 'ctc_user_logs';           

    $non_encrypt_data = array(
        'origin_id' => $dataValue['originID'], 
        'receiver_id' => $dataValue['receiverID'],
        'field_value' =>  str_replace('"', "'", serialize($dataValue['field_value'])),
        'date_created' => date('Y-m-d H:i:s')
    );

    $encrypt_data = array(
        'table_origin' => $dataValue['tableOrigin'],
        'origin_name' => $dataValue['originName'],
        'table_receiver' => $dataValue['tableReceiver'],
        'receiver_name' => $dataValue['receiverName'],
        'description' => $dataValue['description']       
    );    

    insert_encryted_data($table, $encrypt_data, $non_encrypt_data);   
}
