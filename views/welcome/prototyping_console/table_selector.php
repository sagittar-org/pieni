			<div id="tableTableSelector">
				<span class="hide">
					<input name="table_name" type="radio" disabled onclick="getTables(this.value);">
					<label name="id"></label>
				</span>
			</div>
			<script>
			function getTables(name)
			{
				getDatabaseSchema(name);
				getApplicationSchema(name);
			}
			$.ajax({
				url: '<?php href('api/aliases'); ?>',
				dataType: 'json',
				success: (vars) => {
					let rowElementTemplate = $('#tableTableSelector *:first');
					let index = 0;
					for (let rowName in vars.data.scalars) {
						if (vars.data.scalars[rowName].table !== rowName) continue;
						let rowElement = rowElementTemplate.clone();
						rowElement.removeClass('hide');
						rowElement.find('[type="radio"]').prop('disabled', false);
						rowElement.find('[type="radio"]').val(rowName);
						if (index === 0) {
							rowElement.find('[type="radio"]').prop('checked', true);
						}
						rowElement.find('[name="id"]').text(rowName);
						$('#tableTableSelector').append(rowElement);
						index++;
					}
				},
			});
			</script>
