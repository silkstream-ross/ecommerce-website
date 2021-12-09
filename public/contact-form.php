<?php
include 'classes/Form.php';


$form_completed = false;

$form = new Form();
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $form->setValues($_POST);
    $form->validateText('name');
    $form->validateEmail('email');
    $form->validateText('subject');
    $form->validateText('message');
    if (!$form->hasErrors()) {
        // form is good to go, perform actions
        // insert/update database, redirect, etc
        $form_completed = true;
    }

}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Contact Form</title>
    <link rel="stylesheet" href="src/sass/contact-form.scss">
    <?php include 'includes/head-data.php'; ?>
</head>
<body>

<?php include 'includes/header.php'; ?>

<div id="contact-form-area">
<?php //if ($form_completed): ?>
<!--    <div>Thank you for submitting the form!</div>-->
<!--    --><?php //else: ?>
    <form class="contact-form" method="post">
        <div>
            <label>Name</label>
            <input type="text" name="name" value="<?= $form->displayValue('name') ?>">
            <?= $form->displayError('name') ?>
        </div>
        <div>
            <label>Email</label>
            <input type="text" name="email" value="<?= $form->displayValue('email') ?>">
            <?= $form->displayError('email') ?>
        </div>
        <div>
            <label>Subject</label>
            <input type="text" name="subject" value="<?= $form->displayValue('subject') ?>">
            <?= $form->displayError('subject') ?>
        </div>
        <div>
            <label>Message</label>
            <textarea type="text" name="message"><?= $form->displayValue('message') ?></textarea>
            <?= $form->displayError('message') ?>
        </div>
    </form>
<!--    --><?php //endif ?>
    <button type="button" onclick="loadMessage()">Submit</button>
</div>
<script>
    function loadMessage(){
        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function(){
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("contact-form-area").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "ajax-form-complete.php", true);
        xhttp.send();
    };
</script>
</body>
</html>