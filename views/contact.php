<?php
/** @var $this \Nirya\PhpMvcCore\view  */

use Nirya\PhpMvcCore\form\TextAreaField;
?>

<h1>Contact us</h1>
<title><?php echo $this->title = 'Contact'; ?></title>

<?php $form = \Nirya\PhpMvcCore\form\FORM::begin('', "post");?>

<?php echo $form->field($model, 'subject')?>
<?php echo $form->field($model, 'email')?>
<?php echo new TextAreaField($model, 'body')?>
<button type="submit" class="btn btn-primary">Submit</button>

<?php \Nirya\PhpMvcCore\form\FORM::end(); ?>
