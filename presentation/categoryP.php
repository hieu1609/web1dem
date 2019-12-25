<?php include "business/categoryB.php" ?>
<?php
	class CategoryP{
		public function ShowAllCategories() {
			$cb = new CategoryB();
			$result = $cb->GetAllCategories();
			$count = 1;
			while ($row = mysqli_fetch_array($result)) {
				$category = <<<DELIMITER
				<li class="list-group-item">
					<a href="index.php?category={$count}&page=1" 
					{$this->SetStyleForCurrentCategory($count)}>
						{$row['cat_name']}
					</a>
				</li>
				DELIMITER;

				echo $category;
				$count++;
			}
		}

		public function GetSearch() {
			$search="";
			if (isset($_REQUEST['ok'])) 
				$search = addslashes($_GET['search']);
			return $search;
		}

		public function GetCategory() {
			$cat_id;
			if (!isset($_GET['category']))
				$cat_id = 0;
			else 
				$cat_id = $_GET['category'];
			return $cat_id;
		}

		public function SetStyleForCurrentCategory($count) {
			$cat_id = $this->GetCategory();
			$style = "";
			if($count == $cat_id) 
				$style = "style='color:black'";
			return $style;
		}

		public function BuildLinks() {
			$cb = new CategoryB();
			$cat_id = $this->GetCategory();
			$num = $cb->CalculateNumberOfLinks($cat_id);
			if($num == 1)
				return;
			$count = 1;
			while ($count <= $num) {
				$link = <<<DELIMITER
				<a href="index.php?category={$cat_id}&page={$count}"
				{$this->SetStyleForCurrentPage($count)}>
					[{$count}]
				</a>
				DELIMITER;
				echo $link;
				$count++;
			}
		}

		public function GetPage() {
			$page_id;
			if (!isset($_GET['page']))
				$page_id = 1;
			else 
				$page_id = $_GET['page'];
			return $page_id;
		}

		public function SetStyleForCurrentPage($count) {
			$page_id = $this->GetPage();
			$style = "";
			if($count == $page_id) 
				$style = "style='color:black'";
			return $style;
		}
	}
?>