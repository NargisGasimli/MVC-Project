<h1>Register Form</h1>
<?php $form = \app\core\form\FORM::begin('', "post");?>

<div class="row">
  <div class="col">
    <?php echo $form->field($model, 'firstname')?>
  </div>
  <div class="col">
    <?php echo $form->field($model, 'lastname')?>
  </div>
</div>
<?php echo $form->field($model, 'email')?>
<?php echo $form->field($model, 'password')->passwordField()?>
<?php echo $form->field($model, 'confirm_password')->passwordField()?>
<button type="submit" class="btn btn-primary">Submit</button>
<?php \app\core\form\FORM::end(); ?>

<!-- <form action="" method="post">
  <div class="row">
    <div class="col">
      <div class="form-group">
        <label for="exampleInputSubject" class="form-label">Firstname</label>
        <input type="text" name = "firstname" class="form-control" id="exampleInputSubject" aria-describedby="SubjectHelp">
      </div>
    </div>
    <div class="col">
      <div class="form-group">
        <label for="exampleInputEmail1" class="form-label">Lastname</label>
        <input type="text" name = "lastname" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
      </div>
    </div>
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1" class="form-label">Email address</label>
    <input type="email" name = "email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1" class="form-label">Password</label>
    <input type="password" name = "password" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1" class="form-label">Confirm Password</label>
    <input type="password" name = "confirm_password" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form> -->