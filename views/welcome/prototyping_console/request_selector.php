			<h4>Actor</h4>
			<div id="tableActorSelector">
				<span class="hide">
					<input name="alias_name" type="radio">
					<label name="id"></label>
				</span>
			</div>
			<h4>Alias</h4>
			<div id="tableAliasSelector">
				<span class="hide">
					<input name="alias_name" type="radio" disabled onclick="getRequests(this.value);">
					<label name="id"></label>
				</span>
			</div>
			<h4>Action</h4>
			<div id="tableActionSelector">
				<span class="hide">
					<input name="action_name" type="radio">
					<label name="id"></label>
				</span>
			</div>
			<script>
			function getRequests(name)
			{
				getRequestSchema(name);
			}
			$.ajax({
				url: '<?php href('api/aliases'); ?>',
				dataType: 'json',
				success: (vars) => {
					let rowElementTemplate = $('#tableAliasSelector *:first');
					let index = 0;
					for (let rowName in vars.data.scalars) {
						let rowElement = rowElementTemplate.clone();
						rowElement.removeClass('hide');
						rowElement.find('[type="radio"]').prop('disabled', false);
						rowElement.find('[type="radio"]').val(rowName);
						if (index === 0) {
							rowElement.find('[type="radio"]').prop('checked', true);
						}
						rowElement.find('[name="id"]').text(rowName);
						$('#tableAliasSelector').append(rowElement);
						index++;
					}
				},
			});
			</script>
