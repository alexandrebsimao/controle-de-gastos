<?php
	echo form_open(current_url());

	echo form_label('Código:','codigo');

	echo form_input($codigo);

	echo form_label('Descrição:','descricao');

	echo form_input($descricao);

	echo form_label('Valor: *','valor');

	echo form_input($valor);

	echo form_label('Observação:','observacao');

	echo form_textarea($observacao);

	echo br();

	echo form_label('Data: *','data');

	echo form_input($data);

	echo form_label('Tipo: *','tipo');

	echo br();

	echo form_label('Crédito:','credito');

	echo nbs();

	echo form_radio('tipo','credito',@($dados->tipo == 'credito') ? $dados->tipo : '');

	echo form_label('Débito:','debito');

	echo nbs();

	echo form_radio('tipo','debito',@($dados->tipo == 'debito') ? $dados->tipo : '');

	echo br(2);

	echo form_submit($salvar);

	echo form_close();
?>