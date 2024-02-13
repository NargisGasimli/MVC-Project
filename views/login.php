<?php 
  /** @var \app\models\User 
   *  @var $this \app\core\view
   * */ 

  use app\core\form\Form;
?>
<h1>Login</h1>

<title><?php echo $this->title = 'Login'; ?></title>

<?php $form = Form::begin('', 'post') ?>
    <?php echo $form->field($model, 'email') ?>
    <?php echo $form->field($model, 'password')->passwordField() ?>
    <button class="btn btn-success">Submit</button>
<?php Form::end() ?>