<?php include "data/database.php" ?>
<?php
	// $test = new CategoryB();
	// $cat = 2;
	// echo $test->GetAmountOfProductInCategory($cat) . '<br>';
	// $test->CalculateNumberOfLinks($cat) . '<br>';
	// $test->GetProductsInGroup($cat, 1);
	class CategoryB{
		private $cat_list = null;
		private $MAX_PRODUCT = 3;

		public function GetAllCategories() {
			if($this->cat_list == null) {
				$sql = "SELECT * FROM `category`";
				$db = new Database();
				$this->cat_list = $db->select($sql);
			}
			return $this->cat_list;
		}

		public function GetAmountOfProductInCategory($cat_id) {
			$sql = "SELECT COUNT(*) as NUM FROM `product` 
			WHERE `cat_id` = {$cat_id}";
			$db = new Database();
			$result = $db->select($sql);
			$row = mysqli_fetch_array($result);
			$num = $row['NUM'];
			return $num;
		}

		public function CalculateNumberOfLinks($cat_id) {
			$result;
			$session_name = "numPages_" . $cat_id;
			if (isset($_SESSION["{$session_name}"])){
				$result = $_SESSION["{$session_name}"];
				return $result;
			}
			$num = $this->GetAmountOfProductInCategory($cat_id);
			$max = $this->MAX_PRODUCT;
			$result = (float)$num / $max;
			$result = ceil($result);
			$_SESSION["{$session_name}"] = $result;
			return $result;
		}

		//In presentation tier
		public function GetProductsInGroup($cat_id, $link_num) {
			$offset = ($link_num - 1) * $this->MAX_PRODUCT;
			$sql = "SELECT * FROM `product` 
			WHERE `cat_id` = {$cat_id} LIMIT {$offset}, {$this->MAX_PRODUCT}";
			$db = new Database();
			$result = $db->select($sql);
			return $result;
		}
	}
?>