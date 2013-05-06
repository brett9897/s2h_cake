<style>
	.tableTd {
	   	border-width: 0.5pt; 
		border: solid; 
	}
	.tableTdContent{
		border-width: 0.5pt; 
		border: solid;
	}
	#titles{
		font-weight: bolder;
	}
</style>

<table>
	<tr id="titles">
		<?php foreach($header as $cell): ?>
			<td class="tableTd"><?php echo $cell; ?></td>
		<?php endforeach;?>
	</tr>
	<?php foreach($output as $row): ?>
		<tr>
			<?php foreach($row as $cell): ?>
				<td class="tableTdContent"><?php echo $cell;?></td>
			<?php endforeach; ?>
		</tr>
	<?php endforeach; ?>
</table>
