<?php include "include/lib/simple_html_dom.php" ?>
<?php
    $from ="2019-08-01";
    $to ="2019-11-07";
    $product_name = "Samsung Galaxy A30s";
    // $test = new ProductAnalysisB();
    // $return_list = $test->GetRelevantLinks($product_name);
    // $test->BuildUpDataset($product_name, $return_list);
    // $test->UpdateViewOfProduct(1);
    // $test->GetView(1, $from, $to);
    $type = "class";
    $rule = "price";
    $raw = "19.990.000 ₫ Trả góp 0%";
    $test_price = 19000000;
    // $link = "https://www.thegioididong.com/dtdd/iphone-x-64gb";
    $link = "https://fptshop.com.vn/dien-thoai/iphone-x";

    // $test->SearchCompetitivePrice($product_name);
    // $test->GetPrice($raw);
    // $test->CheckRuleMatchLink($link, $type, $rule);
    // $test->TrainRule($product_name);
    // $test->GetUnfriendlyLinks($product_name);
    // echo $test->CheckPrice($test_price);

	class ProductAnalysisB{
        private $high_view = 2;
        private $google_link = "https://www.google.com/search?q=";

        public function GetRelevantLinks($product_name){
            //1. Build search string
            $search = $this->BuildSearchString($product_name);
            $url = $this->google_link . $search;

            //2. Send search string and get result 
            $html = file_get_html($url);
            // echo $html;
            //3. Analyze search result and get link  
            $return_list = array();
            foreach($html->find('a') as $element){      
                $pos = stripos($element->plaintext,$product_name);
                if ($pos !== false){
                    $link = $this->StandarizeLink($element->href);
                    if ($link != -1)
                        $return_list["{$element->plaintext}"] = "{$link}";
                }      
            }
            return $return_list;
        }

        public function GetType($type) {
            $temp;
            if (stripos($type,"class") !== false) {
                $temp = 1;
            }
            else if (stripos($type,"ID") !== false) {
                $temp = 2;
            }
            else {
                $temp = 3;
            }
            return $temp;
        }

        public function CheckPrice($check_price) {
            //Get later by product_id
            $base_price = 6500000;
            $num = $base_price - $check_price;
            if ($num < 0) 
                $num = -1 * $num;
            $p = (float) $num / $base_price;
            if ($p > 0.2)
                return -1;
            return 1;   
        }
        public function GetPrice($raw_string) {     
            $pt1 = implode("", explode(" ", $raw_string));
            $end = stripos($pt1,"₫");
            if ($end == false)
                $end = stripos($pt1,"đ");

            $start = $end - 1;
            $price = 0;
            $base = 1;
            while($start >= 0) {
                // $link = substr($pt1, $start, $end-$start);
                // if(is_numeric($link) || ($link == ".")) {
                //     if($link != ".") {
                //         $price = $price + $base * intval($link);
                //         $base = $base * 10;
                //     }
                //     echo $link . '<br>';
                // }
                // else {
                //     $start = -1;
                // }
                // $end = $start;
                // $start = $end - 1;

                $link = substr($pt1, $start, 1);
                if(is_numeric($link) || ($link == ".")){
                    if($link != ".") {
                        $price = $price + $base * intval($link);
                        $base = $base * 10;
                    }
                    // echo $link . '<br>';
                }
                else {
                    $start = -1;
                }
                $start--;
            }
            // echo $price . '<br>';
            return $price;
        }

        public function UpdatePriceInDataset($link, $price) {
            $LINK = "'" . $link . "'";
            $sql = "UPDATE `dataset` SET `price`={$price} 
            WHERE `link_name`={$LINK}";
            $db = new Database();
            $db->update($sql);
        }

        public function CompareClassRule($element, $rule, $link) {
            $class = 'Class: ' . $element->class.'<br>';
            if (stripos($class, $rule) !== false){
                // Do something with the element here
                //echo count($element->find("*")).'<br>';
                //echo $element->find("*")[0]->tag.'<br>';
                // echo $element->tag.'<br>';
                //echo $element->outertext.'<br>';   
                // echo $class;  
                $pt1 = $element->plaintext.'<br>';
                echo $pt1 . '<br>';
                
                $check_price = $this->GetPrice($pt1);
                $flag = $this->CheckPrice($check_price);
                if ($flag == 1) {
                    //update database
                    echo $check_price . '<br>';
                    $this->UpdatePriceInDataset($link, $check_price);
                    return $check_price;
                }

                return 1;
            }
            return 0;
        }

        public function CompareIDRule($element, $rule, $link) {
            $id = 'ID: ' . $element->id.'<br>';
            if (stripos($id, $rule) !== false){
                // Do something with the element here
                //echo count($element->find("*")).'<br>';
                //echo $element->find("*")[0]->tag.'<br>';
                echo $element->tag.'<br>';
                //echo $element->outertext.'<br>';   
                echo $id;  
                $pt1 = $element->plaintext.'<br>';
                echo $pt1 . '<br>';

                $check_price = $this->GetPrice($pt1);
                $flag = $this->CheckPrice($check_price);
                if ($flag == 1) {
                    //update database
                    echo $check_price . '<br>';
                    $this->UpdatePriceInDataset($link, $check_price);
                    return $check_price;
                }

                echo '<br>';
                return 1;
            }
            return 0;
        }

        public function CheckRuleMatchLink($link, $type, $rule) {
            $html = file_get_html($link);
            echo $link . '<br>';
            
            $all = $html->find("*");
            $matched_num = 0;

            for ($i = 0, $max=count($all); $i < $max; $i++) {
                $temp = $this->GetType($type);
                //Class
                if ($temp == 1) {
                    $matched_num += $this->CompareClassRule($all[$i], $rule, $link);
                }
                else if ($temp == 2) {
                    $matched_num += $this->CompareIDRule($all[$i], $rule, $link);  
                }
                else {
                    $matched_num += $this->CompareClassRule($all[$i], $rule, $link);
                    $matched_num += $this->CompareIDRule($all[$i], $rule, $link);  
                }
                if ($matched_num > 0)
                    return $matched_num;
            }
            return $matched_num;
        }

        public function TestLink($link){
            $html = file_get_html($link);
            if ($html == false)
                return -1;
            return 1;
        }

        public function GetAllLinks($product_name) {
            $PROD = "'" . $product_name . "'";
            $sql = "SELECT * FROM `dataset` WHERE product_name={$PROD}";
			$db = new Database();
            $result = $db->select($sql);
            $return_list = array();
            while ($row = mysqli_fetch_array($result)) {
                $link_ID = $row['link_id'];
                $link_name = $row['link_name'];
                $return_list["{$link_ID}"] = "{$link_name}";
            }
            
            return $return_list;
        }

        public function IsLearned($rule_id, $link_id){
            $sql = "SELECT count(*) as num FROM `rule_and_dataset` 
            WHERE rule_id={$rule_id} AND link_id={$link_id}";
			$db = new Database();
            $result = $db->select($sql);
            $row = mysqli_fetch_array($result);
            return $row['num'];
        }

        public function GetMinPrice($product_name){
            $PROD = "'" . $product_name . "'";
            $sql = "SELECT min(price) as PRICE FROM 
            (SELECT * FROM `dataset` WHERE `price`>0 AND `product_name`={$PROD}) as Alias";
			$db = new Database();
            $result = $db->select($sql);            
            $row = mysqli_fetch_array($result);
            echo $row['PRICE'];
            return $row['PRICE'];
        }

        public function SearchCompetitivePrice($product_name){
            $price = 0;
            //1. Look at dataset and get min price
            $price = $this->GetMinPrice($product_name);
            if($price > 0) 
                return 0.95 * $price;
            
            //2. Generate links 
            $return_list = $this->GetRelevantLinks($product_name);
            $this->BuildUpDataset($product_name, $return_list);
            $return_list1 = $this->GetAllLinks($product_name);
            $min_price = -1;
            foreach($return_list1 as $x => $x_value) {
                //3. Look at rule
                $sql = "SELECT * FROM `rules` ORDER BY matching_ratio DESC";
                $db = new Database();
                $result = $db->select($sql);
                $flag = 1;
                while (($flag == 1) && ($row = mysqli_fetch_array($result))) {
                    $rule_name = $row['name'];
                    $type = $row['class_or_id'];
                    $num = $this->CheckRuleMatchLink($x_value, $type, $rule_name);
                    if($num > 1) {
                        if ($min_price == -1 || $min_price > $num) {
                            $min_price = $num;
                            $flag = -1;
                        }
                    }
                }
                echo "MIN_PRICE" . $min_price . '<br>';
                return 0.95 * $price;
            }

        }

        public function TrainRule($product_name){
            //1. Get dataset
            $return_list = $this->GetAllLinks($product_name);

            //2. Get rules and train 
            $sql = "SELECT * FROM `rules`";
			$db = new Database();
            $result = $db->select($sql);
            while ($row = mysqli_fetch_array($result)) {
                $rule_name = $row['name'];
                $type = $row['class_or_id'];
                $rule_id = $row['rule_id'];
                $count = 0;
                $is_price = -1;
                foreach($return_list as $x => $x_value) {
                    $is_price = 0;
                    $num = $this->CheckRuleMatchLink($x_value, $type, $rule_name);
                    if($num > 0) {
                        $count++;
                        $is_price = 1;
                    }
                    if($this->IsLearned($rule_id, $x) == 0) {
                        //Update relationship table
                        $this->UpdateRelationshipTable($rule_id, $x, 1, $is_price);
                    }
                }
                //Update matching ratio
                $ratio = (float)$count/count($return_list);
                $this->UpdateMatchingRatio($rule_id, $ratio);

			}
        }

        public function GetUnfriendlyLinks($product_name){
            //1. Get dataset
            $link_list = $this->GetAllLinks($product_name);

            //2. Get all rules
            $rule_list = $this->GetAllRules();

            //3. Check every link in relationship table
            $return_list = array();
            foreach($link_list as $link_id => $link_name) {
                $flag = 1;
                foreach($rule_list as $rule_id => $rule_name) {
                    //Check link match rule
                    $num = $this->CheckLinkMatchRule($link_id, $rule_id);
                    if($num == 1){
                        $flag = 0;
                    }
                }
                if($flag == 1){
                    $return_list["{$link_id}"] = "{$link_name}";
                }
            }
            foreach($return_list as $x => $y) {
                echo $x . '<br>';
                echo $y . '<br>';
            }
            return $return_list;
        }

        public function CheckLinkMatchRule($link_id, $rule_id){
            $sql = "SELECT `is_identified_price` FROM `rule_and_dataset` 
            WHERE `link_id`={$link_id} AND `rule_id`={$rule_id}";
			$db = new Database();
            $result = $db->select($sql);
            $row = mysqli_fetch_array($result);
            return $row['is_identified_price'];
        }

        public function GetAllRules(){
            $sql = "SELECT * FROM `rules`";
			$db = new Database();
            $result = $db->select($sql);
            while ($row = mysqli_fetch_array($result)) {
                $rule_ID = $row['rule_id'];
                $rule_name = $row['name'];
                $return_list["{$rule_ID}"] = "{$rule_name}";
            }
            
            return $return_list;
        }

        public function UpdateRelationshipTable($rule_id, $link_id, $is_visited, $is_price){
            $sql = "INSERT INTO `rule_and_dataset`(`rule_id`, `link_id`, `is_visited`, `is_identified_price`) 
            VALUES ({$rule_id}, {$link_id}, {$is_visited}, {$is_price})";
            $db = new Database();
            $db->insert($sql);
        }

        public function UpdateMatchingRatio($rule_id, $ratio){
            $sql = "UPDATE `rules` SET `matching_ratio`={$ratio} WHERE `rule_id`={$rule_id}";
            $db = new Database();
            $db->update($sql);
        }

        public function BuildUpDataset($product_name, $return_list){
            foreach($return_list as $x => $x_value) {
                //1. Get link is not in dataset
                $test = $this->CheckLinkInDataset($x_value);
                set_error_handler(function() {/* ignore errors */});
                $test1 = $this->TestLink($x_value);
                restore_error_handler();
                //2. Insert
                if ($test == 0 && $test1 == 1) {
                    $PROD = "'" . $product_name . "'";
                    $LINK = "'" . $x_value . "'";
                    $sql = "INSERT INTO `dataset`(`product_name`, `link_name`) 
                    VALUES ({$PROD},{$LINK})";
                    $db = new Database();
                    $db->insert($sql);
                }
            }
        }

        public function CheckLinkInDataset($link){
            $LINK = "'" . $link . "'";
            $sql = "SELECT COUNT(*) as NUM FROM `dataset` 
            WHERE `link_name`={$LINK}";
            $db = new Database();
            $result = $db->select($sql);
            $row = mysqli_fetch_array($result);
            // echo $row['NUM'];
            return $row['NUM'];
        }

        public function StandarizeLink($raw_link){
            $start = stripos($raw_link,"http");
            if ($start !== false){
                $end = stripos($raw_link,"&");
                $link = substr($raw_link,$start,$end-$start);
                return $link;
            }
            return -1;
        }

        //standardize search string
        public function BuildSearchString($search){
            $list = explode(" ",$search);
            $result = "";
            for ($i = 0; $i < count($list)-1; $i ++)
                $result = $result . $list[$i] . "+";
            $result = $result . $list[$i];
            return $result;
        }

        public function GetView($product_id, $from, $to) {
            $FROM = "'" . $from . "'";
            $TO = "'" . $to . "'";
            $sql = "SELECT COUNT(*) as NUM FROM `product_analysis` 
            WHERE `product_id`={$product_id} AND `visited_date`>{$FROM} AND `visited_date`<{$TO}";
            $db = new Database();
            $result = $db->select($sql);
            $row = mysqli_fetch_array($result);
            echo $row['NUM'];
            // return $result;
        }

		public function UpdateViewOfProduct($product_id) {
            $now = date("Y-m-d H:i:s");
            $NOW = "'" . $now . "'";
            $sql = "INSERT INTO `product_analysis`(`product_id`, `visited_date`) 
            VALUES ({$product_id},{$NOW})";
            $db = new Database();
            $db->insert($sql);
		}
	}
?>