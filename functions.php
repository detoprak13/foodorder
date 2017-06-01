<?php
    include('queries.php');
    function check_credentials($username, $pw){
        $result = check_credentials_query($username, $pw);
        if($result){
            if($row = mysqli_fetch_array($result)){
                if($row['u_count'] == 1) return true;
            }
        }
      return false;
    }

    function isPasswordValid($pw){
      if(strlen($pw)<6){
        return false;
      }
      if (!ctype_alpha($pw[0])){
        return false;
      }
      return true;
    }

    function signup_func($username, $password, $name, $surname, $district, $city, $street, $door_number, $phone_number, $isOwner){
        $region_id = getRegionID($city,$district);
        $result = signup_query($username, $password, $name, $surname, $region_id, $street, $door_number, $phone_number, $isOwner);
        return $result;
    }

    function addRestaurant($rest_name, $o_name, $work_start, $work_end, $district, $city, $street, $door_number){
      $region_id = getRegionID($city,$district);
      $result = add_restaurant_query($rest_name, $o_name, $work_start, $work_end, $region_id, $street, $door_number);
      return $result;
    }

    function getNameSurname($username){
        $result = get_name_surname_query($username);
        $row = mysqli_fetch_array($result);
        return $row;
    }

    function getUserInfo($username){
        $result = get_user_info_query($username);
        $row = mysqli_fetch_array($result);
        return $row;
    }

    function updateUserInfo($username, $name, $surname, $district, $city_id, $street, $door_number, $phone_number){
        $region_id = getRegionID($city_id,$district);
        $result = update_user_info_query($username, $name, $surname, $region_id, $street, $door_number, $phone_number);
        return $result;
    }

    function searchRestaurant($username, $is_ordered){
        $result = search_restaurant_query($username, $is_ordered);
        return $result;
    }

    function getCart($uname){
        $result = get_cart_query($uname);
        return $result;
    }

    function getCartCost($uname){
        return mysqli_fetch_array(get_cart_total_cost($uname))['total_cost'];
    }

    function placeOrder($uname,$payment_id,$date_time,$total_cost){
        place_order_query($uname,$payment_id,$date_time,$total_cost);
    }

    function getRestaurantInformation($owner,$rest){
        $result = get_restaurant_information($owner, $rest);
        return $result;
    }

    function getRestaurantMenu($owner,$rest){
        $result = get_menu_items_query($owner, $rest);
        return $result;
    }

    function addCart($uname, $itemID){
        $result = add_cart_query($uname, $itemID);
        return $result;
    }

    function empty_cart($uname){
        return empty_cart_query($uname);
    }

    function removeItemFromCart($uname,$item_id){
        return remove_item_from_cart_query($uname,$item_id);
    }

    function addToFavorites($uname, $rest_name, $o_name){
        return make_favorite($uname, $rest_name, $o_name);
    }

    function isAlreadyFavored($uname, $rest_name, $o_name){
        $count = mysqli_fetch_array(getFavoritedCount($uname, $rest_name, $o_name))['fav_count'];
        return $count == 1;
    }

    function removeFromFavorites($uname, $rest_name, $o_name){
        return remove_favorite($uname, $rest_name, $o_name);
    }

    function getCities(){
        return get_cities_query();
    }

    function getDistricts(){
        return get_districts_query();
    }

    function getRegionID($city_id, $district){
        $result = get_region_id_query($city_id,$district);
        $row = mysqli_fetch_array($result);
        return $row['re_id'];
    }

    function getMostOrdered($rest_name, $owner_name){
        $result = get_most_ordered_query($rest_name,$owner_name);
        $row = mysqli_fetch_array($result);
        return $row;
    }

    function getItemCost($itemID){
      $result = get_item_information($itemID);
      return mysqli_fetch_array($result)['price'];
    }

    function getItemAmountInCart($c_id, $itemID){
      $result = get_amount($c_id, $itemID);
      return mysqli_fetch_array($result)['amount'];
    }

    function getPaymentTypes($rest_name, $owner_name){
      $result = get_payment_types_query($rest_name, $owner_name);
      return $result;
    }

    function getOwnedRestaurants($owner){
      $result = get_owned_restaurants($owner);
      return $result;
    }

    function isCustomer($uname){
      $result = get_customer_count($uname);
      $count = mysqli_fetch_array($result)['c_count'];
      if($count == 1) return true;
      return false;
    }

    function getUnprocessedOrderCount($rest_name, $owner){
      $result = get_unprocessed_order_count($rest_name, $owner);
      return mysqli_fetch_array($result)['o_count'];
    }

    function removeRestaurant($rest_name, $owner){
      $result = remove_restaurant($rest_name, $owner);
      return $result;
    }

    function removeMenuItem($rest_name, $owner, $item_id){
      $result = remove_menu_item($rest_name, $owner, $item_id);
      return $result;
    }

    function addMenuItem($rest_name, $owner, $name, $price, $type){
      $result = add_menu_item($rest_name, $owner, $name, $price, $type);
      return $result;
    }

    function getPossibleDistricts($rest_name, $owner){
      $result = get_restaurant_rossible_regions($rest_name, $owner);
      return $result;
    }

    function getRestaurantServing($rest_name, $owner){
      $result = get_restaurant_serving($rest_name, $owner);
      return $result;
    }

    function addRegionToRestaurant($rest_name, $owner, $re_id, $service_time, $minimum_cost){
       $result = add_region_to_restaurant($rest_name, $owner, $re_id, $service_time, $minimum_cost);
       return $result;
    }

    function getRecentOrders($uname){
      $result = get_recent_orders($uname);
      return $result;
    }

    function getPossiblePayments(){
      $result = get_possible_payments();
      return $result;
    }

    function addPaymentToRestaurant($owner, $restname, $pay_id){
      $result = add_payment_to_restaurant($owner, $restname, $pay_id);
      return $result;
    }

    function getRestaurantOrders($owner, $rest_name){
      $result = get_restaurant_orders($owner, $rest_name);
      return $result;
    }

    function completeOrder($order_id){
      $result = complete_order($order_id);
      return $result;
    }

    function canComment($order_id, $username){
      $oder_count_result = is_comment_count($order_id, $username);
      $count = mysqli_fetch_array($oder_count_result)['comment_count'];
      if($count == 0) return true;
      else return false;
    }

    function rankOrder($order_id, $rank, $comment, $uname){
      $result = rank_order($order_id, $rank, $comment, $uname);
      return $result;
    }
?>
