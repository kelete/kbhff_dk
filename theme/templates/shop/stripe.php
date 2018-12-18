<?php
global $action;
global $model;

$UC = new User();
$IC = new Items();

// get current user id
$user_id = session()->value("user_id");
$order_no = $action[1];
$amount = "";
$user = $UC->getUser();

$order = $model->getOrders(array("order_no" => $order_no));
$membership = $UC->getMembership();

$is_membership = false;
$subscription_method = false;


if($order) {
	$total_order_price = $model->getTotalOrderPrice($order["id"]);
	if($total_order_price) {
		$amount = formatPrice($total_order_price);
	}


	if($membership && $membership["order"]) {
		$is_membership = ($membership["order"] && $order["id"] == $membership["order"]["id"]) ? true : false;
	}


	if($membership && $membership["item"] && $membership["item"]["subscription_method"] && $membership["item"]["subscription_method"]["duration"]) {
		$subscription_method = $membership["item"]["subscription_method"];
		$payment_date = $membership["renewed_at"] ? date("jS", strtotime($membership["renewed_at"])) : date("jS", strtotime($membership["created_at"]));
	}

}

if($is_membership) {
	$reference = "Member ".$membership["id"];
}
else {
	$reference = $order_no;
}

//$this->headerIncludes(["https://checkout.stripe.com/checkout.js"]);

?>
<div class="scene shopPayment stripe <?= $order ? "i:stripe" : "i:scene" ?>">

<? if($order): ?>

	<h1>Betal dit medlemskab</h1>
	<p>Indmeldelsesgebyr: <?= $order["items"][0]["unit_price"] ?> DKK.</p>
	<p>Moms: <?= $total_order_price["vat"] ?> DKK.</p>
	<p>I alt: <?= $total_order_price["price"] ?> DKK.</p>
	<?= $model->formStart("/butik/betaling/".$order_no."/stripe/process", array("class" => "card")) ?>
		<? //= $model->input("reference", array("type" => "hidden", "value" => $reference)); ?>
		<? //= $model->input("email", array("type" => "hidden", "value" => $user["email"])); ?>

	<fieldset>
		<?= $model->input("card_number", array("type" => "tel")); ?>
		<?= $model->input("card_exp_month", array("type" => "tel")); ?><span class="slash">/</span><?= $model->input("card_exp_year", array("type" => "tel")); ?>
		<?= $model->input("card_cvc", array("type" => "tel")); ?>

	</fieldset>

	<ul class="actions">
		<?= $model->submit("Betal ".formatPrice($total_order_price), array("class" => "primary", "wrapper" => "li.pay")) ?>
	</ul>
	<?= $model->formEnd() ?>

	<p>Betalingsreference: <?= $reference ?>.</p>
	<p class="note">
		Vi bruger <a href="https://stripe.com" target="_blank">Stripe</a> til at behandle betalingen. <br />
		Vi beholder ingen kortinformationer på vores server. <br />
		All kommunikation er krypteret. <br />
	</p>

	<p>Hvis du ikke vil betale nu kan du gøre det senere ved at <a href="/">springe over.</a></p>

<? else: ?>

	<h1>Er du ved at gennemføre en betaling?</h1>
	<p>Du bør <a href="/login">logge ind</a> på din konto og starte din betaling derfra.</p>

<? endif;?>

</div>
