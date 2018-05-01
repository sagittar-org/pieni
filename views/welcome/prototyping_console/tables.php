			<div id="tableTables">
				<span>
					<input name="table_name" type="radio">
					<label name="id"></label>
				</span>
			</div>
			<script>
			$.ajax({
				url: '<?php href('api/aliases'); ?>',
				dataType: 'json',
				success: (vars) => {
					let rowElementTemplate = $('#tableTables *:first');
					for (let rowName in vars.data.scalars) {
						if (vars.data.scalars[rowName].table !== rowName) continue;
						let rowElement = rowElementTemplate.clone();
						rowElement.find('[name="id"]').text(rowName);
						$('#tableTables').append(rowElement);
					}
				},
			});
			</script>
