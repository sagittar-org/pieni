			<h2>Aliases</h2>
			<table class="table table-condensed">
				<thead>
					<tr>
						<th>id</th>
<?php foreach ($vars['aliases_columns']['scalars'] as $column_name): ?>
						<th><?php h($column_name); ?></th>
<?php endforeach; ?>
					</tr>
				</thead>
				<tbody id="tableAliases">
					<tr>
						<td name="id"></td>
<?php foreach ($vars['aliases_columns']['scalars'] as $column_name): ?>
						<td name="<?php h($column_name); ?>"></td>
<?php endforeach; ?>
					</tr>
				</tbody>
			</table>
			<script>
			$.ajax({
				url: '<?php href('api/aliases'); ?>',
				dataType: 'json',
				success: (vars) => {
					let rowElementTemplate = $('#tableAliases *:first');
					for (let rowName in vars.data.scalars) {
						let rowElement = rowElementTemplate.clone();
						rowElement.find('[name="id"]').text(rowName);
						for (let columnName in vars.data.scalars[rowName]) {
							rowElement.find('[name="' + columnName + '"]').text(vars.data.scalars[rowName][columnName]);
						}
						$('#tableAliases').append(rowElement);
					}
				},
			});
			</script>
