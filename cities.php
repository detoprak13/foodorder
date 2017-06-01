<?php
//https://gist.githubusercontent.com/serong/9b25594a7b9d85d3c7f7/raw/9904724fdf669ad68c07ab79af84d3a881ff8859/iller.json
include 'queries.php';
$json = file_get_contents('city.json');
$json_1 = mb_convert_encoding($json, 'UTF-8',
    mb_detect_encoding($json, 'UTF-8, ISO-8859-1', true));
$datas = json_decode($json_1);
//print_r($data);
$curr_city = 'ADANA';
$final_data = array();
$final_data[$curr_city] = array();
foreach($datas as $data){
    $array_data = json_decode(json_encode($data),true);
    $city_name = $array_data['il'];
    $district_name = $array_data['ilce'];
    if ($city_name != $curr_city) {
        $curr_city = $city_name;
        $final_data[$curr_city] = array($district_name);
    } else {
        array_push($final_data[$curr_city],$district_name);
    }
}

foreach(array_keys($final_data) as $city_name){
    $q1 = "INSERT INTO city values(NULL,'$city_name');";
    echo $q1;
    echo "<br>";
    $city_id = exec_query_get_id($q1);
    $districts = $final_data[$city_name];
    foreach($districts as $district){
        exec_query("INSERT INTO region values(NULL, $city_id, '$district');");
    }
}

echo "DONE";
?>