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
		$id = $row['product_id'];
		$name = $row['product_name'];
		$price = $row['product_price'];
		$image = $row['product_image'];
		$newPrice = $row['product_new_price'];
		$this->ShowSingleProduct($name, $newPrice, $price, $image, $id);

		//3. Update view
		$pab = new ProductAnalysisB();
		$pab->UpdateViewOfProduct($product_id);

		//4. Session
		if(isset($_GET['action']) && $_GET['action']=="add"){ 
			$id=intval($_GET['product_id']); 
			if(isset($_SESSION['cart'][$id])){ 
				$_SESSION['cart'][$id]['quantity']++; 
			}
			else{ 
				$_SESSION['cart'][$id]=array( 
						"quantity" => 1,
						"product_id" => $id,
						"product_name" => $name,
						"product_new_price" => $newPrice,
						"product_image" => $image
					);  
			}  
		} 
		else if(isset($_GET['action']) && $_GET['action']=="sub"){ 
			$id=intval($_GET['product_id']); 
			if(isset($_SESSION['cart'][$id]) && $_SESSION['cart'][$id]["quantity"] > 1){ 
				$_SESSION['cart'][$id]['quantity']--; 
			}
		} 
	}

	public function GetProductInCart()
	{	
		if(isset($_SESSION['cart'])){
			$count = count($_SESSION['cart']);
		}
		else {
			$count = 0;
		}

		$productInCart = <<<DELIMITER
		<a href="cart.php">
		<div class="cart">
			<i class="fa fa-shopping-cart"></i>
			<span>
			{$count}
			</span>
		</div>
		</a>
		DELIMITER;
		echo $productInCart;
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

	public function ShowSingleProduct($name, $newPrice, $price, $image, $id)
	{
		$product = <<<DELIMITER
			<div class="row">
				<div class="col-6">
					<img class="card-img-top" src="{$image}" alt="Card image">
				</div>
				<div class="col-6">
					<h2 class="card-title mt-4">{$name}</h2>
					<h4>
					<small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small></h4>				
					<span class="card-text oldprice mr-2">\${$price}</span>
					<span class="card-text newprice">\${$newPrice}</span>
					<p class="mt-4 mb-5">Lorem ipsum dolor sit amet, consectetur adipisicing elit.Lorem ipsum dolor sit amet, consectetur adipisicing elit
					Lorem ipsum dolor sit amet, consectetur adipisicing elit
					Lorem ipsum dolor sit amet, consectetur adipisicing elitLorem ipsum dolor sit amet, consectetur adipisicing elit
					Lorem ipsum dolor sit amet, consectetur adipisicing elit Amet numquam aspernatur!</p>
					<a href="item.php?product_id={$id}&action=add"
					onclick="window.location.reload(true);">
						<button class="add-to-cart">
							<i class="fa fa-cart-plus"></i>Add to cart 
						</button>
					</a>
					<a href="cart.php">
						<button class="buy-now">
							Buy now
						</button>
					</a>
				</div>
			</div>
			DELIMITER;
		echo $product;
	}

	public function ShowProduct($name, $newPrice, $price, $id, $image)
	{
		$product = <<<DELIMITER
			<div class="col-sm-4 mt-4">
				<div class="card h-100">
					<a href="item.php?product_id={$id}">
						<img class="card-img-top" src="{$image}" alt="Card image">
					</a>
					<div class="card-body">
						<h4 class="card-title"><a href="#">{$name}</a></h4>
						<span class="card-text oldprice">\${$price}</span>
						<span class="card-text newprice">\${$newPrice}</span>
					
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
		$session_name = "Featured_Product";
		if (isset($_SESSION["{$session_name}"])) {
			foreach ($_SESSION["{$session_name}"] as $value) {
				$this->ShowProduct($value->product_name, $value->product_new_price, $value->product_price, $value->product_id, $value->product_image);
			}
		} else {
			$_SESSION["{$session_name}"] = array();
			$i = 0;
			//1. Get product list sorted by performance
			$ib = new InventoryB();
			$featuredList = $ib->GetPoorPerformanceList($this->from, $this->to);

			foreach ($featuredList as $x => $x_value) {
				$pb = new ProductB();
				$result = $pb->GetProductsByID($x);
				$row = mysqli_fetch_array($result);
				$this->ShowProduct($row['product_name'], $row['product_new_price'], $row['product_price'], $row['product_id'], $row['product_image']);
				$_SESSION["{$session_name}"][$i] = new stdClass();
				$_SESSION["{$session_name}"][$i]->product_name =  $row['product_name'];
				$_SESSION["{$session_name}"][$i]->product_price = $row['product_price'];
				$_SESSION["{$session_name}"][$i]->product_id = $row['product_id'];
				$_SESSION["{$session_name}"][$i]->product_image = $row['product_image'];
				$_SESSION["{$session_name}"][$i]->product_new_price = $row['product_new_price'];
				$i++;
			}
		}
	}

	public function ShowProductsByGroup()
	{
		$cp = new categoryP();
		$cat_id = $cp->GetCategory();
		$page_id = $cp->GetPage();

		$session_name = $cat_id . "_" . $page_id;

		if (isset($_SESSION["{$session_name}"])) {
			foreach ($_SESSION["{$session_name}"] as $value) {
				$this->ShowProduct($value->product_name, $value->product_new_price, $value->product_price, $value->product_id, $value->product_image);
			}
		} else {
			$_SESSION["{$session_name}"] = array();
			$i = 0;
			$cb = new categoryB();
			$result = $cb->GetProductsInGroup($cat_id, $page_id);
			while ($row = mysqli_fetch_array($result)) {
				$this->ShowProduct($row['product_name'], $row['product_new_price'], $row['product_price'], $row['product_id'], $row['product_image']);
				$_SESSION["{$session_name}"][$i] = new stdClass();
				$_SESSION["{$session_name}"][$i]->product_name =  $row['product_name'];
				$_SESSION["{$session_name}"][$i]->product_price = $row['product_price'];
				$_SESSION["{$session_name}"][$i]->product_id = $row['product_id'];
				$_SESSION["{$session_name}"][$i]->product_image = $row['product_image'];
				$_SESSION["{$session_name}"][$i]->product_new_price = $row['product_new_price'];
				$i++;
			}
		}
	}

	public function ShowProductsBySearch($search)
	{
		$ib = new InventoryB();
		$searchList = $ib->SearchProduct($search);
		if ($searchList != null) {
			while ($row = mysqli_fetch_array($searchList)) {
				$this->ShowProduct($row['product_name'], $row['product_new_price'], $row['product_price'], $row['product_id'], $row['product_image']);
			}
		} else {
			echo "Product is not found";
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

	public function ShowProductsSearch()
	{
		$cp = new categoryP();
		$search = $cp->GetSearch();
		if (empty($search)) {
			//
		} else {
			$this->ShowProductsBySearch($search);
		}
	}

	public function ShowProductsInCart()
	{
		// Session
		if(isset($_GET['action']) && $_GET['action']=="add"){ 
			$id=intval($_GET['product_id']); 
			$_SESSION['cart'][$id]['quantity']++; 
		} 
		else if(isset($_GET['action']) && $_GET['action']=="sub"){ 
			$id=intval($_GET['product_id']); 
			if($_SESSION['cart'][$id]["quantity"] > 1){ 
				$_SESSION['cart'][$id]['quantity']--; 
			}
		} 

		if(isset($_SESSION['cart'])){
			$this->TitleProductInCart();
			foreach ($_SESSION['cart'] as $value) {
				$this->HaveProductInCart($value["product_name"], $value["product_new_price"], $value["product_id"], $value["product_image"], $value["quantity"]);
			}
			$this->TotalPriceProductInCart();
		}
		else {
			$this->NoneProductInCart();
		}
	}

	public function TotalPriceProductInCart()
	{
		$total = 0;
		foreach ($_SESSION['money'] as $value) {
			$total = $total + $value;
		}
		$product = <<<DELIMITER
			<h3 class="total-price mt-3">
			Total: {$total}$
			</h3>
			<div class="marginleft-paypal">
			<div class="paypal-container" id="paypal-button-container"></div>
			</div>
			<!-- Set up a container element for the button -->
					
			<!-- Include the PayPal JavaScript SDK -->
			<script src="https://www.paypal.com/sdk/js?client-id=AVYELqUnYbYWQiTgw8K6o_g2wTL6MyyxYj9afnp6Iy-22WL1Akc7z_za3utm_GH4OqXlf2APFOZ3Ldzi&currency=USD"></script>
			<script>
				// Render the PayPal button into #paypal-button-container
				paypal.Buttons({
					locale: 'en_US',
					style: {
						label:'pay',
						color: 'blue',
						shape: 'pill',
						size: 'small',
						layout: 'horizontal',
						tagline:false
					},
								// Set up the transaction
					createOrder: function(data, actions) {
						return actions.order.create({
							purchase_units: [{
								amount: {
									value: "{$total}" //Price
								}
							}]
						});
					},
					// Finalize the transaction
					onApprove: function(data, actions) {
						return actions.order.capture().then(function(details) {
							// Show a success message to the buyer
							alert('Transaction completed by ' + details.payer.name.given_name + '!');
						});
					}
				}).render('#paypal-button-container');
			</script>
			DELIMITER;
		echo $product;
	}

	public function NoneProductInCart()
	{
		$product = <<<DELIMITER
			<h5>
			Your cart is empty
			</h5>
			DELIMITER;
		echo $product;
	}

	public function HaveProductInCart($product_name, $product_new_price, $product_id, $product_image, $quantity)
	{
		$total = $product_new_price * $quantity;
		$_SESSION['money'][$product_id] = $total;
		$product = <<<DELIMITER
			<li class="mt-3">
				<div class="row">
					<div class="col-2">
						<img height="70" width="70" src="{$product_image}" alt="">
					</div>
					<div class="col-4 mt-4  ">
						{$product_name}
					</div>
					<div class="col-2 mt-4 ">
						{$product_new_price}
					</div>
					<div class="col-2 mt-4">
						<a href="cart.php?product_id={$product_id}&action=sub"
						onclick="window.location.reload(true);">
						<button class="mr-1">-</button>
						</a>
						<span>{$quantity}</span>
						<a href="cart.php?product_id={$product_id}&action=add"
						onclick="window.location.reload(true);">
						<button class="ml-1">+</button>
						</a>
					</div>
					<div class="col-2 mt-4 ">
						{$total}$
					</div>
				</div>
			</li>
			DELIMITER;
		echo $product;
	}
	public function TitleProductInCart()
	{
		$product = <<<DELIMITER
			<li>
				<div class="row ">
					<div class="col-2">
					</div>
					<div class="col-4 mt-3 pb-2  ">
					</div>
					<div class="col-2 mt-3 pb-2">
						Price
					</div>
					<div class="col-2 mt-3 pb-2">
						Number
					</div>
					<div class="col-2 mt-3 pb-2">
						Total
					</div>
				</div>
			</li>
			DELIMITER;
		echo $product;
	}
}
?>