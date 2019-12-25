<?php include "business/productB.php" ?>
<?php include "business/inventoryB.php" ?>
<?php include "business/productAnalysisB.php" ?>
<?php
class ProductP
{
	private $from = "2019-08-01";
	private $to = "2019-10-05";

	public function ShowItem()
	{
		//1. Get product id
		$product_id = $this->GetProduct();

		//2. Show single product
		$pb = new ProductB();
		$result = $pb->GetProductsByID($product_id);
		$row = mysqli_fetch_array($result);
		$name = $row['product_name'];
		$price = $row['product_price'];
		$this->ShowSingleProduct($name, $price);

		//3. Update view
		$pab = new ProductAnalysisB();
		$pab->UpdateViewOfProduct($product_id);
	}

	public function GetProduct()
	{
		$product_id = 0;
		if (!isset($_GET['product_id']))
			$product_id = 0;
		else
			$product_id = $_GET['product_id'];
		return $product_id;
	}

	public function ShowSingleProduct($name, $price)
	{
		$product = <<<DELIMITER
			<div class="col-sm-12 mt-4">
				<div class="card h-100">
					<img class="card-img-top" src="http://placehold.it/700x400" alt="Card image">
					<div class="card-body">
						<h4 class="card-title"><a href="#">{$name}</a></h4>
						<h5 class="card-text">\${$price}</h3>
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet numquam aspernatur!</p>
					</div>
					<div class="card-footer">
							<small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small>
					</div>
				</div>
			</div>
			DELIMITER;
		echo $product;
	}

	public function ShowProduct($name, $price, $id, $image)
	{
		$product = <<<DELIMITER
			<div class="col-sm-4 mt-4">
				<div class="card h-100">
					<a href="item.php?product_id={$id}">
						<img class="card-img-top" src="{$image}" alt="Card image">
					</a>
					<div class="card-body">
						<h4 class="card-title"><a href="#">{$name}</a></h4>
						<h5 class="card-text">{$price} VNĐ</h3>
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet numquam aspernatur!</p>
					</div>
					<div class="card-footer">
							<small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small>
					</div>
				</div>
			</div>
			DELIMITER;
		echo $product;
	}

	public function ShowFeaturedProduct()
	{
		//1. Get product list sorted by performance
		$ib = new InventoryB();
		$featuredList = $ib->GetPoorPerformanceList($this->from, $this->to);

		foreach ($featuredList as $x => $x_value) {
			$pb = new ProductB();
			$result = $pb->GetProductsByID($x);
			$row = mysqli_fetch_array($result);
			$this->ShowProduct($row['product_name'], $row['product_price'], $row['product_id'], $row['product_image']);
		}
	}

	public function VarForProductName($cat_id, $page_id, $product_name, $count)
	{
		$session_name = $cat_id . "_" . $page_id . "_" . "name" . "_" . $count;
		$_SESSION["{$session_name}"] = $product_name;
	}

	public function ShowProductsByGroup()
	{
		$cp = new categoryP();
		$cat_id = $cp->GetCategory();
		$page_id = $cp->GetPage();

		$cb = new categoryB();
		$result = $cb->GetProductsInGroup($cat_id, $page_id);
		while ($row = mysqli_fetch_array($result)) {
			$this->ShowProduct($row['product_name'], $row['product_price'], $row['product_id'], $row['product_image']);
		}
	}

	public function ShowProductsByUser()
	{
		$cp = new categoryP();
		$cat_id = $cp->GetCategory();
		if ($cat_id == 0) {
			$this->ShowFeaturedProduct();
		} else {
			$this->ShowProductsByGroup();
		}
	}
}
?>