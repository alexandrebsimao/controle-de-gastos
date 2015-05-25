<?php if($gatos_mes->gatos_mes != 0 && $saldo_mensal->total_mes != 0 && $saldo_total->saldo_total != 0): ?>
  <table class="table table-bordered saldos" style="width:30%">
    <thead>
      <tr>
        <th>Total Mês</th>
        <th>Saldo Mensal</th>
        <th>Saldo Total</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <?php if($gatos_mes->gatos_mes >= $saldo_total->saldo_total): ?>
          <td class="saldo-danger" width="300">
          R$ <?php echo bd2valor($gatos_mes->gatos_mes); ?>
        <?php else: ?>
          <td class="saldo-success" width="300">
          R$ <?php echo bd2valor($gatos_mes->gatos_mes); ?>
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
      </tr>
    </tbody>
  </table>

  <!-- Graficos -->
  <div style="width:50%; float:left;">
    <div>
      <canvas id="graph1" height="450" width="600"></canvas>
    </div>
  </div>

  <div style="width:50%; float:left;">
    <div>
      <canvas id="graph2" height="450" width="600"></canvas>
    </div>
  </div>


<?php else: ?>
  <h2>Bem Vindo!</h2>
  <p>Comece agora a controlar seu orçamento em qualquer dispositivo e em todo lugar.</p>
  <p>Insira sua receitas e gastos fixos mensais clicando em <b>'Controle Fixo'</b>.</p>

<?php endif; ?>

  
  