<?php 
	$current_key = array_search($pagina_atual, array_keys($formularios));
	$keys = array_keys($formularios);
	$anterior_url = array_key_exists($current_key-1, $keys) ? $formularios[$keys[$current_key-1]]['url'] : "";
	$proxima_url = array_key_exists($current_key+1, $keys) ? $formularios[$keys[$current_key+1]]['url'] : "";

?>

<div class="bottom-index" <?php if ($pagina_atual == 'inicio') { echo 'style="margin-top: 0"';}?> >
	<?php if ($pagina_atual != 'inicio') { ?>
		<div class="anterior">
			<a href="<?php echo $anterior_url; ?>"> <button>&larr; Anterior</button></a>
		</div>
		<?php if ($proxima_url) { ?>
			<div class="proxima">
				<a href="<?php echo $proxima_url; ?>" ><button>Próximo &rarr;</button></a>
			</div>
		<?php } ?>
	<?php } ?>

	<div class="indice">
		<h4>Índice</h4><br>
		<ul>
			<?php foreach ($formularios as $key => $value) {
				if ($key == $pagina_atual) { ?>
					<li class="aula_atual"><?php echo $value['nome']; ?></li>
				<?php } else { ?>
					<li><a href="<?php echo $value['url']; ?>"><?php echo $value['nome']; ?></a></li>
				<?php }
			} ?>
		</ul>
	</div>
</div>