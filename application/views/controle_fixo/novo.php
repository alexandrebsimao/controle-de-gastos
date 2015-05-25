<?php
	echo form_open();

	echo form_label('Código','codigo');

	echo form_input($codigo);

	echo form_label('Descrição','descricao');

	echo form_input($descricao);

	echo form_label('Valor','valor');

	echo form_input($valor);

	echo form_label('Observação','observacao');

	echo form_textarea($observacao);

	echo form_label('Efetuada','efetuada');

	echo form_checkbox('efetuada',$efetuada);

	echo form_label('Data','data');

	echo form_input($data);

	echo form_label('Mês/Ano Referência','mes_ano_referencia');

	echo form_input($mes_ano_referencia);

	echo form_label('Tipo','tipo');

	echo form_label('Crédito','credito');

	echo form_radio('tipo','credito');

	echo form_label('Débito','debito');

	echo form_radio('tipo','debito');

	echo form_submit($salvar);

	echo form_close();
?>