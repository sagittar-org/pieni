			<div id="tableTables">
				<span class="hide">
					<input name="table_name" type="radio" disabled>
					<label name="id"></label>
				</span>
			</div>
			<script>
			$.ajax({
				url: '<?php href('api/aliases'); ?>',
				dataType: 'json',
				success: (vars) => {
					let rowElementTemplate = $('#tableTables *:first');
					let index = 0;
					for (let rowName in vars.data.scalars) {
						if (vars.data.scalars[rowName].table !== rowName) continue;
						let rowElement = rowElementTemplate.clone();
						rowElement.removeClass('hide');
						rowElement.find('[type="radio"]').prop('disabled', false);
						if (index === 0) {
							rowElement.find('[type="radio"]').prop('checked', true);
						}
						rowElement.find('[name="id"]').text(rowName);
						$('#tableTables').append(rowElement);
						index++;
					}
				},
			});
			</script>
