<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Sistema de Gestão de Gastos Pessoais</title>

  <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/datepicker3.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>public/css/datepicker.css">
	<!-- Optional theme -->
	
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/css/style.css">

	<script src="<?php echo base_url();?>public/js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
</head>
<body>
	
    <div class="navbar navbar-fixed-top navbar-pro" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Controle</a>
        </div>
        
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li><a href="<?php echo base_url(); ?>home">Dashboard <i class='glyphicon glyphicon-th-large'></i></a></li>
            <li><a href="<?php echo base_url(); ?>controle">Controle Mensal <i class='glyphicon glyphicon-calendar'></i></a></li>
            <li><a href="<?php echo base_url(); ?>controle_fixo">Controle Fixo <i class='glyphicon glyphicon-list-alt'></i></a></li>
            <li><a href="#">Relatórios <i class='glyphicon glyphicon-print'></i></a></li>
          </ul>
        
          <ul class="nav navbar-nav navbar-right">
            <?php if($session_user['id'] == 'Y1AjMVh5MTB2TQ=='): ?>
            <?php endif; ?>''
            
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Olá <?php echo $session_user['nome']; ?> <b class="caret"></b></a>
              <ul class="dropdown-menu">
               <li><a href="#"><i class='glyphicon glyphicon-user'></i> Conta</a></li>
			         <li><a href="<?php echo base_url(); ?>user/usuarios"><i class='glyphicon glyphicon-user'></i> Usuários</a></li>
                <li class="divider"></li>
                <li><a href="<?php echo base_url(); ?>logout"><i class='glyphicon glyphicon-log-out'></i> Sair</a></li>
              </ul>
            </li>

          </ul>

        </div>
      </div>
    </div>

    <div class="container-fluid">

          <?php if( (isset($icon) && $icon) && (isset($titulo) && $titulo) ): ?>
          <div class="title-content">
            <h1 class=""><i class='glyphicon glyphicon-<?php echo $icon; ?>'></i> <?php echo $titulo; ?></h1>
          </div>
          <?php endif; ?>

          <?php echo $this->alert_library->alert(); ?>

        	<!-- <h3><?php echo isset($titulo) ? $titulo : ''; ?> </h3> -->
        	
        	<?php $this->load->view($view); ?>

          <br style="clear:both;">

        <!-- </div> -->
      <!-- </div> -->
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <!-- // <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script> -->
    <script type="text/javascript" src="<?php echo base_url(); ?>public/js/vendor/jquery-1.9.0.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->    
    <script type="text/javascript" src="<?php echo base_url(); ?>public/js/bootstrap.min.js"></script>

    <script type="text/javascript" src="<?php echo base_url(); ?>public/js/vendor/Chart.min.js"></script>

    <script type="text/javascript" src="<?php echo base_url(); ?>public/js/docs.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>public/js/vendor/jquery.mask.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>public/js/vendor/Chart.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>public/js/vendor/bootstrap-datepicker.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>public/js/funcoes.js"></script>

</body>
</html>