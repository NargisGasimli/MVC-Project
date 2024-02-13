<?php
/** @var $this \app\core\view  */

use app\core\form\TextAreaField;
?>

<h1>Contact us</h1>
<title><?php echo $this->title = 'Contact'; ?></title>

<?php $form = \app\core\form\FORM::begin('', "post");?>

<?php echo $form->field($model, 'subject')?>
<?php echo $form->field($model, 'email')?>
<?php echo new TextAreaField($model, 'body')?>
<button type="submit" class="btn btn-primary">Submit</button>

<?php \app\core\form\FORM::end(); ?>
