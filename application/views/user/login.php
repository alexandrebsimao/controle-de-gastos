<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sistema de Gestão de Gastos Pessoais</title>

  <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/bootstrap.min.css">
  <!-- Optional theme -->
  <!-- <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css"> -->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/css/login.css">

  <script src="<?php echo base_url();?>public/js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
</head>
<body>


    <div class="container">
      <form role="form" class="form-signin" action="<?php echo base_url(); ?>user/autenticar" method="post">
        <h1 class="form-signin-heading">Controle</h1>
        <div style="color:red;">
        <?php echo $this->alert_library->alert(); ?>
        </div>

        <input type="text" autofocus="" required="" name="user" placeholder="Usuario" class="form-control">
        <input type="password" required="" placeholder="Senha" name="pass" class="form-control">
        <button type="submit" class="btn btn-lg btn-primary btn-block">Entrar</button>
      </form>

    </div>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
    
    <script type="text/javascript" src="<?php echo base_url(); ?>public/js/docs.min.js"></script>

</body>
</html>