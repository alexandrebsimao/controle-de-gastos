<div class="container-fluid">
  <a href="<?php echo base_url(); ?>controle_fixo/novo_registro" class="btn btn-primary pull-right">Novo Registro</a>
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
            <td><a href="<?php echo base_url().'controle_fixo/editar_registro/'.$dado->id; ?>" class="glyphicon glyphicon-edit rm-link" title="Editar Registro"></a></td>
            <td><a href="<?php echo base_url().'controle_fixo/remover_registro/'.$dado->id;; ?>" class="glyphicon glyphicon-remove-circle rm-link" title="Remover Registro"></a></td>
        </tr>
        <?php endforeach; ?>

      </tbody>
    </table>
  </div>

<?php if($saldo_fixo->total_mes): ?>
  <table class="table table-bordered saldos">
    <thead>
      <tr>
        <th>Soma Crédito</th>
        <th>Saldo Mês</th>
        <th>Despesas Mês</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <?php if($soma_credito->total_mes < 0): ?>
          <td class="saldo-danger" width="300">
          R$ -<?php echo bd2valor($soma_credito->total_mes); ?>
        <?php else: ?>
          <td class="saldo-success" width="300">
          R$ <?php echo bd2valor($soma_credito->total_mes); ?>
        <?php endif; ?>

        <?php if($saldo_fixo->total_mes < 0): ?>
          <td class="saldo-danger" width="300">
          R$ -<?php echo bd2valor($saldo_fixo->total_mes); ?>
        <?php else: ?>
          <td class="saldo-success" width="300">
          R$ <?php echo bd2valor($saldo_fixo->total_mes); ?>
        <?php endif; ?>

        <?php if($gasto_fixo->total_mes >= $soma_credito->total_mes): ?>
          <td class="saldo-danger" width="300">
          R$ -<?php echo bd2valor($gasto_fixo->total_mes); ?>
        <?php else: ?>
          <td class="saldo-success" width="300">
          R$ <?php echo bd2valor($gasto_fixo->total_mes); ?>
        <?php endif; ?>
        </td>
        </td>
      </tr>
    </tbody>
  </table>

<?php else: ?>

  <p><strong>Você não possui nenhum registro cadastrado. <br>Comece a registrar seus gastos ou entradas clicando no botão 
  <a href="<?php echo base_url(); ?>controle/novo_registro" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i> Novo Registro</a>.</strong></p>

<?php endif; ?>

