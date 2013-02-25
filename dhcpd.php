<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

function p($txt){
    echo '<pre>';
    print_r($txt);
    echo '</pre>';
}

$content = file_get_contents('/var/lib/dhcp/dhcpd.leases');
$content = explode("\n",$content);
unset($content[0]);
unset($content[1]);
unset($content[2]);
$content = implode("\n",$content);
//p($content);

preg_match_all('#lease (.*)}#Umsi',$content,$result);

$data = $result[1];

//p($result);
//p($data);

$leases = array();
foreach($data as $key=>$line){

    $tmp = explode('{',$line);
    $ip = $tmp[0];
    $leases[$ip]['ip'] = $ip;
    
    $line = $tmp[1];
    $lease = explode(';',$line);
    foreach($lease as $l){
        $l = trim($l);
        if(substr($l,0,6) == 'starts'){
            $l = substr($l,9);
            $leases[$ip]['starts'] = date("Y-m-d H:i:s",strtotime($l));
        }
        if(substr($l,0,4) == 'ends'){
            $l = substr($l,7);
            $leases[$ip]['ends'] = date("Y-m-d H:i:s",strtotime($l));
        }
        if(substr($l,0,7) == 'binding'){
            $l = substr($l,7);
            $leases[$ip]['state'] = substr($l,7);
        }
        if(substr($l,0,15) == 'client-hostname'){
            $l = substr($l,7);
            preg_match('#"(.*)"#Umsi',$l,$res);
            $leases[$ip]['hostname'] = $res[1];
        }
        if(substr($l,0,8) == 'hardware'){
            $leases[$ip]['mac'] = substr($l,18);
        }
    }

}



echo json_encode($leases);

?>
