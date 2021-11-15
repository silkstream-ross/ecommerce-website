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
<html>
<head>
    <title>Contact Form</title>
</head>
<body>
<?php if ($form_completed): ?>
    <div>Thank you for submitting the form!</div>
    <?php else: ?>
    <form method="post">
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
            <label>Subject</label>
            <textarea type="text" name="message"><?= $form->displayValue('message') ?></textarea>
            <?= $form->displayError('message') ?>
        </div>
        <button type="submit">Submit</button>
    </form>
    <?php endif ?>
</body>
</html>