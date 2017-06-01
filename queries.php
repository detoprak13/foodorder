<?php
    function exec_query($query){
        $conn = new mysqli("istavrit.eng.ku.edu.tr", "Group_5", "wepkv", "Group_5_db");

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        if (!$conn->set_charset("utf8")) {
            //printf("Error loading character set utf8: %s\n", $conn->error);
        } else {
           // printf("Current character set: %s\n", $conn->character_set_name());
        }

        if ($result = $conn->query($query)) {
            $conn->close();
            return $result;
        } else {
            $conn->close();
            die("SQL ERROR " . $conn->error);
        }

        $conn->close();

        return null;
    }

    function exec_query_get_id($query){
        $conn = new mysqli("localhost", "root", "", "306_db");

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        if (!$conn->set_charset("utf8")) {
            //printf("Error loading character set utf8: %s\n", $conn->error);
        } else {
            // printf("Current character set: %s\n", $conn->character_set_name());
        }

        if ($result = $conn->query($query)) {
            $id = $conn->insert_id;
            $conn->close();
            return $id;
        } else {
            $conn->close();
            die("SQL ERROR " . $conn->error);
        }

        $conn->close();

        return null;
    }

    function check_credentials_query($username, $pw){
        $query = "SELECT count(*) AS u_count FROM user WHERE username='$username' AND password='$pw';";
        return exec_query($query);
    }

    function get_name_surname_query($username){
        $query = "SELECT name, surname FROM user WHERE username='$username';";
        return exec_query($query);
    }

    function signup_query($username, $password, $name, $surname, $region_id, $street, $door_number, $phone_number, $isOwner){
        $sql = "INSERT INTO user VALUES('$username','$password','$name','$surname',$region_id,'$street',$door_number,'$phone_number');";
        $result = exec_query($sql);
        if($result){
          if($isOwner){
            $sql2 = "INSERT INTO restaurant_owner VALUES('".$username."');";
            $result = exec_query($sql2);
          }else{
            $sql2 = "INSERT INTO customer VALUES('".$username."',0);";
            $result = exec_query($sql2);
          }
            if($result) return true;
        }
        return false;
    }

    function add_restaurant_query($rest_name, $o_name, $work_start, $work_end, $region_id, $street, $door_number){
        $sql = "INSERT INTO restaurant VALUES('$rest_name','$o_name','$work_start','$work_end',$region_id,'$street',$door_number);";
        $result = exec_query($sql);
    }

    function update_user_info_query($username, $name, $surname, $region_id, $street, $door_number, $phone_number){
        $sql = "UPDATE user SET name='$name', surname='$surname', region_id=$region_id, street='$street', door_number=$door_number, phonenumber='$phone_number' WHERE username='$username';";
        return exec_query($sql);
    }

    function get_user_info_query($username){
        $sql = "select user.name as u_name, city.name as c_name, surname, street, door_number, phonenumber, district, city.city_id as c_id  from user, region, city where user.region_id=region.re_id and region.city_id=city.city_id and username='$username'";
        return exec_query($sql);
    }

    function search_restaurant_query($username, $is_ordered){
        $region_sql = "SELECT region_id FROM user WHERE username='$username'";
        $region_result = exec_query($region_sql);
        $region = mysqli_fetch_array($region_result)['region_id'];
        $restaurant_sql = '';
        if($is_ordered){
          $restraurants_sql = "SELECT * FROM serves, restaurant WHERE re_id=$region AND serves.r_name=restaurant.name AND serves.o_name=restaurant.o_name ORDER BY service_time;";
        }else{
          $restraurants_sql = "SELECT * FROM serves, restaurant WHERE re_id=$region AND serves.r_name=restaurant.name AND serves.o_name=restaurant.o_name;";
        }


        return exec_query($restraurants_sql);
    }

    function place_order_query($uname,$payment_id,$date,$total_cost){
        $create_order_sql = "INSERT INTO order_t VALUES(NULL,'$uname',$total_cost,'$date',0,$payment_id);";
        exec_query($create_order_sql);
        $get_last_id = "SELECT MAX(o_id) as last_id FROM order_t;";
        $get_last_result = exec_query($get_last_id);
        $order_id = mysqli_fetch_array($get_last_result)['last_id'];
        $cart_items = get_cart_query($uname);
        while($row = mysqli_fetch_array($cart_items)){
            $order_contains_sql = "INSERT INTO order_contains VALUES($order_id, ".$row['i_id'].",".$row['amount'].");";
            echo $order_contains_sql;
            exec_query($order_contains_sql);
        }
        empty_cart_query($uname);
    }

    function get_restaurant_information($owner, $restaurant){
        $sql = "SELECT * FROM restaurant WHERE o_name='$owner' AND name='$restaurant'";
        return exec_query($sql);
    }

    function get_owned_restaurants($owner){
      $sql = "SELECT * FROM restaurant WHERE o_name='$owner'";
      return exec_query($sql);
    }

    function get_menu_items_query($owner, $restaurant){
        $sql = "SELECT i_id,menu_item.name,price,type,is_available FROM restaurant, menu_item WHERE restaurant.o_name='$owner' and restaurant.name='$restaurant' and restaurant.o_name=menu_item.o_name and restaurant.name=menu_item.r_name";
        return exec_query($sql);
    }

    function get_cart_total_cost($uname){
        $sql = "SELECT total_cost FROM cart WHERE username='$uname'";
        return exec_query($sql);
    }

    function get_cart_query($uname){
        $sql = "SELECT i_id, name, o_name, r_name, price, amount FROM customer NATURAL JOIN cart NATURAL JOIN cart_contains NATURAL JOIN menu_item WHERE customer.username='$uname';";
        return exec_query($sql);
    }

    function empty_cart_query($uname){
        $c_id = get_cart_id($uname);
        $sql = "DELETE FROM cart_contains WHERE c_id = $c_id";
        $sql_cost = "UPDATE cart SET total_cost=0 WHERE c_id=$c_id;";
        exec_query($sql);
        exec_query($sql_cost);
    }

    function get_cart_id($uname){
        $sql_get_cart_id = "SELECT c_id FROM cart WHERE username='$uname';";
        $result_cart_id = exec_query($sql_get_cart_id);
        return mysqli_fetch_array($result_cart_id)['c_id'];
    }

    function get_item_information($itemID){
      $sql = "SELECT * FROM menu_item WHERE i_id=$itemID;";
      return exec_query($sql);
    }

    function get_amount($c_id, $item_id){
      $sql = "SELECT amount FROM cart_contains WHERE c_id=$c_id AND i_id=$item_id;";
      return exec_query($sql);
    }

    function add_cart_query($uname, $itemID){
        $c_id = get_cart_id($uname);
        $price = getItemCost($itemID);
        $sql_add = "INSERT INTO cart_contains VALUES($c_id,$itemID,1)  ON DUPLICATE KEY UPDATE amount=amount+1";
        $sql_increment_price = "UPDATE cart SET total_cost = total_cost + $price WHERE c_id=$c_id;";
        exec_query($sql_add);
        exec_query($sql_increment_price);
    }

    function remove_item_from_cart_query($uname,$item_id){
        $c_id = get_cart_id($uname);
        $price = getItemCost($item_id);
        $amount = getItemAmountInCart($c_id, $item_id);
        if($amount == 1){
          $sql = "DELETE FROM cart_contains WHERE c_id=$c_id AND i_id=$item_id;";
          exec_query($sql);
        }else{
          $sql = "UPDATE cart_contains SET amount=amount-1 WHERE c_id=$c_id AND i_id=$item_id";
          exec_query($sql);
        }
        $sql_decrement_price = "UPDATE cart SET total_cost = total_cost - $price WHERE c_id=$c_id;";
        exec_query($sql_decrement_price);
    }

    function make_favorite($uname, $rest_name, $o_name){
        $sql = "INSERT INTO favorite VALUES('$uname','$rest_name', '$o_name');";
        return exec_query($sql);
    }

    function remove_favorite($uname, $rest_name, $o_name){
        $sql = "DELETE FROM favorite WHERE username='$uname' AND r_name='$rest_name' AND o_name='$o_name';";
        return exec_query($sql);
    }

    function getFavoritedCount($uname, $rest_name, $o_name){
        $sql = "SELECT count(*) as fav_count FROM favorite WHERE username='$uname' AND r_name='$rest_name' AND o_name='$o_name';";
        return exec_query($sql);
    }

    function get_cities_query(){
        $sql = "SELECT * FROM city ORDER BY name;";
        return exec_query($sql);
    }

    function get_districts_query(){
        $sql = "SELECT * FROM region ORDER BY district;";
        return exec_query($sql);
    }

    function get_region_id_query($city_id, $district){
        $sql = "SELECT re_id FROM region WHERE city_id=$city_id AND district='$district';";
        return exec_query($sql);
    }

    function get_most_ordered_query($rest_name,$owner_name){
        $sql = "select max(order_count), name, price, type, i_id from (select sum(amount) as order_count, name, price, type, i_id from order_contains NATURAL JOIN menu_item where r_name='$rest_name' and o_name='$owner_name' group by i_id) alias;";
        return exec_query($sql);
    }

    function get_payment_types_query($rest_name,$owner_name){
      $sql = "SELECT * FROM accepts NATURAL JOIN payment WHERE o_name='$owner_name' AND r_name='$rest_name';";
      return exec_query($sql);
    }

    function get_customer_count($uname){
      $sql = "SELECT count(*) as c_count FROM customer WHERE username='$uname';";
      return exec_query($sql);
    }

    function get_unprocessed_order_count($rest_name, $owner){
      $sql = "SELECT count(*) as o_count FROM menu_item NATURAL JOIN order_contains NATURAL JOIN order_t WHERE r_name='$rest_name' AND o_name='$owner' AND status=0;";
      return exec_query($sql);
    }

    function remove_restaurant($rest_name, $owner){
      $sql = "DELETE FROM restaurant WHERE name='$rest_name' AND o_name='$owner'";
      return exec_query($sql);
    }

    function remove_menu_item($rest_name, $owner, $item_id){
      $sql = "DELETE FROM menu_item WHERE r_name='$rest_name' AND o_name='$owner' AND i_id=$item_id;";
      echo $sql;
      return exec_query($sql);
    }

    function add_menu_item($rest_name, $owner, $name, $price, $type){
      $sql = "INSERT INTO menu_item VALUES(NULL, '$rest_name', '$owner', '$name', $price, '$type', 1);";
      echo $sql;
      return exec_query($sql);
    }

    function get_restaurant_rossible_regions($rest_name, $owner){
      $restaurant_city_id = "SELECT city_id FROM restaurant, region WHERE name='$rest_name' AND o_name='$owner' AND region.re_id=restaurant.region_id;";
      $city_id_result = exec_query($restaurant_city_id);
      $city_id = mysqli_fetch_array($city_id_result)['city_id'];
      $district_sql = "SELECT re_id, district FROM region WHERE city_id=$city_id;";
      return exec_query($district_sql);
    }

    function add_region_to_restaurant($rest_name, $owner, $re_id, $service_time, $minimum_cost){
      $sql = "INSERT INTO serves VALUES('$owner', '$rest_name', $re_id, '$service_time', $minimum_cost);";
      echo $sql;
      return exec_query($sql);
    }

    function get_restaurant_serving($rest_name, $owner){
      $sql = "SELECT * FROM serves NATURAL JOIN region WHERE r_name='$rest_name' AND o_name='$owner';";
      return exec_query($sql);
    }

    function get_recent_orders($uname){
      $sql = "SELECT distinct o_id, date, total_cost, r_name FROM order_t NATURAL JOIN order_contains NATURAL JOIN menu_item WHERE username='$uname' ORDER BY date DESC;";
      return exec_query($sql);
    }

    function get_possible_payments(){
      $sql = "SELECT * FROM payment";
      return exec_query($sql);
    }

    function add_payment_to_restaurant($owner, $restname, $pay_id){
      $sql = "INSERT INTO accepts VALUES ($pay_id, '$owner', '$restname');";
      return exec_query($sql);
    }

    function get_restaurant_orders($owner, $restname){
      $sql = "SELECT * FROM menu_item NATURAL JOIN order_contains NATURAL JOIN order_t WHERE o_name='$owner' AND r_name='$restname' ORDER BY date DESC;";
      return exec_query($sql);
    }

    function complete_order($order_id){
      $sql = "UPDATE order_t SET status=1 WHERE o_id=$order_id";
      return exec_query($sql);
    }

    function rank_order($order_id, $rank, $comment, $uname){
      $sql = "INSERT INTO rate VALUES(NULL, $order_id, '$uname', $rank, '$comment');";
      return exec_query($sql);
    }

    function is_comment_count($order_id, $uname){
      $sql = "SELECT count(*) as comment_count FROM rate WHERE o_id=$order_id AND username='$uname';";
      return exec_query($sql);
    }

?>
