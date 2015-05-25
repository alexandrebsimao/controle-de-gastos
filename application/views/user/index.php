<p><a href="<?php echo base_url(); ?>user/novo_usuario" class="btn btn-primary pull-right">Novo Usuário</a></p>

<table class="table">
	<thead>
		<tr>
			<th>#</th>
			<th>Usuário</th>
			<th>E-mail</th>
			<th>Último Acesso</th>
			<th>IP</th>
			<th width="20">Editar</th>
			<th width="20">Status</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($usuarios as $usuario): ?>
			<tr>
				<td><?php echo $usuario->id; ?></td>
				<td><?php echo $usuario->nome; ?></td>
				<td><?php echo $usuario->email; ?></td>
				<td><?php echo $usuario->ultimo_acesso; ?></td>
				<td><?php echo $usuario->ip; ?></td>
				<td><center><a href="<?php echo base_url().'user/editar_usuario/'.$usuario->id; ?>" class="icon glyphicon glyphicon-edit"></a></center></td>
				<?php if($usuario->ativado == 1): ?>
					<td><center><a href="<?php echo base_url().'user/status/'.$usuario->id; ?>" class="ativado glyphicon glyphicon-plus-sign"></a></center></td>
				<?php else: ?>
					<td><center><a href="<?php echo base_url().'user/status/'.$usuario->id; ?>" class="desativado glyphicon glyphicon-minus-sign"></a></center></td>
				<?php endif; ?>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>