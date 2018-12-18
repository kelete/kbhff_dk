<?php
global $action;
global $model;
global $IC;

$IC = new Items();
$page_item = $IC->getItem(array("tags" => "page:member-help-signup", "extend" => array("user" => true, "tags" => true, "mediae" => true)));
if($page_item) {
	$this->sharingMetaData($page_item);
}

include_once("classes/system/department.class.php");
$DC = new Department();
$departments = $DC->getDepartments();

$signupfees = $IC->getItems(array("itemtype" => "signupfee", "status" => 1, "extend" => true));
$email = $model->getProperty("email", "value");
?>
<div class="scene member_help_signup i:member_help_signup">


<? if($page_item && $page_item["status"]):
	$media = $IC->sliceMedia($page_item); ?>
	<div class="article i:article id:<?= $page_item["item_id"] ?>" itemscope itemtype="http://schema.org/Article">

		<? if($media): ?>
		<div class="image item_id:<?= $page_item["item_id"] ?> format:<?= $media["format"] ?> variant:<?= $media["variant"] ?>"></div>
		<? endif; ?>


		<?= $HTML->articleTags($page_item, [
			"context" => false
		]) ?>


		<h1 itemprop="headline"><?= $page_item["name"] ?></h1>

		<? if($page_item["subheader"]): ?>
		<h2 itemprop="alternativeHeadline"><?= $page_item["subheader"] ?></h2>
		<? endif; ?>


		<?= $HTML->articleInfo($page_item, "/signup", [
			"media" => $media,
		]) ?>


		<? if($page_item["html"]): ?>
		<div class="articlebody" itemprop="articleBody">
			<?= $page_item["html"] ?>
		</div>
		<? endif; ?>
	</div>
<? else:?>
	<h1>Sign up</h1>
<? endif; ?>

<?= $model->formStart("save", array("class" => "member_help_signup labelstyle:inject")) ?>
<?= $model->input("maillist", array("type" => "hidden", "value" => "Nyheder")); ?>
<?= $model->input("quantity", array("type" => "hidden", "value" => 1)); ?>

<? if(message()->hasMessages(array("type" => "error"))): ?>
	<p class="errormessage">
<?	$messages = message()->getMessages(array("type" => "error"));
		message()->resetMessages();
		foreach($messages as $message): ?>
		<?= $message ?><br>
<?	endforeach;?>
	</p>
<?	endif; ?>

	<fieldset>
		<?= $model->input("firstname", array("required" => true, "label" => "Fornavn", "hint_message" => "Skriv medlemmets fornavn her", "error_message" => "Fornavn er obligatorisk. Det kan kun indeholde bogstaver.")) ?>
		<?= $model->input("lastname", array("required" => true, "label" => "Efternavn", "hint_message" => "Skriv medlemmets efternavn her", "error_message" => "Efternavn er obligatorisk. Det kan kun indeholde bogstaver.")) ?>
		<?= $model->input("email", array("required" => true, "label" => "Medlemmets e-mailadresse", "value" => $email, "hint_message" => "Indtast medlemmets e-mailadresse.", "error_message" => "Du har indtastet en ugyldig e-mailadresse.")); ?>
		<?= $model->input("confirm_email", array("label" => "Gentag medlemmets e-mailadresse", "required" => true, "hint_message" => "Indtast medlemmets e-mailadresse igen.", "error_message" => "De to e-mailadresser er ikke ens.")); ?>
		<?= $model->input("item_id", array("type" => "select", "label" => "Vælg medlemskab", "options" => $HTML->toOptions($signupfees, "id", "name", ["add" => ["" => "Vælg medlemskab"]]),)); ?>
		<?= $model->input("department", array("type" => "select", "label" => "Vælg lokalafdeling", "options" => $HTML->toOptions($departments, "id", "name", ["add" => ["" => "Vælg afdeling"]]),)); ?>
		<?= $model->input("terms"); ?>
	</fieldset>

	<ul class="actions">
		<?= $model->submit("Næste", array("class" => "primary", "wrapper" => "li.member_help_signup")) ?>
		<li class="reject"><a href="/medlemshjaelp" class="button">Annuller</a></li>
	</ul>
<?= $model->formEnd() ?>

</div>