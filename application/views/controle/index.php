<div class="container-fluid">
<?php
    
  echo form_open(current_url());

  echo form_dropdown('mes',$mes,$data_referente[1],'class="form-control filtro"');

  echo form_dropdown('ano',$ano,$data_referente[0],'class="form-control filtro"');

  echo "<button type='submit' class='btn btn-default' style='float:left;'><i class='glyphicon glyphicon-ok'></i></button>";

  echo form_close();

?>
  <br style="clear:both;">
  <br>
  <a href="<?php echo base_url(); ?>controle/novo_registro" class="btn btn-primary pull-right"><i class="glyphicon glyphicon-plus"></i> Novo Registro</a>
  <a href="<?php echo base_url(); ?>controle/registros_fixo/<?php echo $data_referente[0].'-'.$data_referente[1]; ?>" class="btn btn-primary pull-right hidden-xs" style="margin-right:5px;"><i class="glyphicon glyphicon-share"></i> Importar Registros Fixos</a>
</div>
<br>
  <div class="table-responsive">
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Data</th>
          <th>Codigo</th>
          <th>Descrição</th>
          <th>Valor</th>
          <th class="hidden-xs">Observação</th>
          <th>Status</th>
          <th></th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($dados as $dado): ?>
        <tr>
            <td><?php echo $dado->data; ?></td>
            <td><?php echo $dado->codigo; ?></td>
            <td><?php echo $dado->descricao; ?></td>
            <td>
              <?php if($dado->tipo == 'debito'): ?>
                <span class="danger"><i class="glyphicon glyphicon-chevron-down"></i> <strong>R$ <?php echo bd2valor($dado->valor); ?></strong></span>
              <?php else: ?>
                <span class="success"><i class="glyphicon glyphicon-chevron-up"></i> <strong>R$ <?php echo bd2valor($dado->valor); ?></strong></span>
              <?php endif; ?>
            </td>
            <td class="hidden-xs"><?php echo $dado->observacao; ?></td>
            <td><?php echo ($dado->efetuado == 0) ? 'Não Efetuada' : 'Efetuada'; ?></td>
            <td><a href="<?php echo base_url().'controle/editar_registro/'.$dado->id; ?>" class="glyphicon glyphicon-edit rm-link" title="Editar Registro"></a></td>
            <td><a href="<?php echo base_url().'controle/remover_registro/'.$dado->id;; ?>" class="glyphicon glyphicon-remove-circle rm-link" title="Remover Registro"></a></td>
        </tr>
        <?php endforeach; ?>

      </tbody>
    </table>
  </div>

<?php if($gastos_mes->gastos_mes || $saldo_mensal->total_mes && $saldo_total->saldo_total): ?>
  <table class="table table-bordered saldos">
    <thead>
      <tr>
        <th>Crédito Mês</th>
        <th>Despesas Mês</th>
        <th>Saldo Mês</th>
        <th>Saldo Acumulado</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <?php if($credito_mes->total_mes < 0): ?>
          <td class="saldo-danger" width="300">
          R$ -<?php echo bd2valor($credito_mes->total_mes); ?>
        <?php else: ?>
          <td class="saldo-success" width="300">
          R$ <?php echo bd2valor($credito_mes->total_mes); ?>
        <?php endif; ?>
        </td>
        <?php if($gastos_mes->gastos_mes >= $saldo_total->saldo_total): ?>
          <td class="saldo-danger" width="300">
          R$ <?php echo bd2valor($gastos_mes->gastos_mes); ?>
        <?php else: ?>
          <td class="saldo-success" width="300">
          R$ <?php echo bd2valor($gastos_mes->gastos_mes); ?>
        <?php endif; ?>
        </td>
        <?php if($saldo_mensal->total_mes < 0): ?>
          <td class="saldo-danger" width="300">
            R$ -<?php echo bd2valor($saldo_mensal->total_mes); ?>
        <?php else: ?>
          <td class="saldo-success" width="300">
            R$ <?php echo bd2valor($saldo_mensal->total_mes); ?>
        <?php endif; ?>
        </td>
        <?php if($saldo_total->saldo_total < 0): ?>
          <td class="saldo-danger" width="300">
          R$ -<?php echo bd2valor($saldo_total->saldo_total); ?>
        <?php else: ?>
          <td class="saldo-success" width="300">
          R$ <?php echo bd2valor($saldo_total->saldo_total); ?>
        <?php endif; ?>
        </td>
        
        </td>
      </tr>
    </tbody>
  </table>

<?php else: ?>

  <p><strong>Você não possui nenhum registro cadastrado. <br>Comece a registrar seus gastos ou entradas clicando no botão 
  <a href="<?php echo base_url(); ?>controle/novo_registro" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i> Novo Registro</a> 
  ou importe os registros fixos cadastrados <br>clicando no botão 
  <a href="<?php echo base_url(); ?>controle/registros_fixo/<?php echo $data_referente[0].'-'.$data_referente[1]; ?>" class="btn btn-primary" style="margin-right:5px;"><i class="glyphicon glyphicon-share"></i> Importar Registros Fixos</a>.</strong></p>

<?php endif; ?>
