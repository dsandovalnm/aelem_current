<?php
	class SearchForm {

		$view = '';

		createSearchForm($view) {
			echo `
				<div class="search-box" data-view="$view">
					<form id="search-form" class="form-inline">
						<div class="input-group">
								<input id="search-argument" name="search-argument" type="text" class="form-control" autocomplete="off" placeholder="Buscar...">
								<button id="search-sem-btn" type="submit" class="fas fa-search search-icon"></button>
						</div>
					</form>
				</div>
			`;
		}
	}