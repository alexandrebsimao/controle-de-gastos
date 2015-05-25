<?php
	echo form_open(current_url(),array('class'=>''));
	
	echo form_label('Nome:','nome');
	echo form_input($nome);

	echo form_label('E-mail:','email');
	echo form_input($email);

	echo form_label('Usuário:','usuario');
	echo form_input($usuario);

	echo form_label('Senha:','senha');
	echo form_input($senha);

	echo form_label('Confirma Senha:','conf_senha');
	echo form_input($conf_senha);

	echo br(2);

	echo form_submit($salvar);

	echo form_close();
?>