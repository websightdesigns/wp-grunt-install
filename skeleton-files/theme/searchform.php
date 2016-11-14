<h3 class="widget-title visible-xs visible-sm">Search</h3>
<form role="search" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">
	<div class="input-group input-group-sm">
		<input type="text" name="s" id="s" class="form-control" placeholder="Search" value="<?php echo ( isset($_GET['s']) ? $_GET['s'] : null ); ?>">
		<span class="input-group-btn">
			<button class="btn btn-default" type="submit">
				<span class="glyphicon glyphicon-search"></span>
			</button>
		</span>
	</div>
</form>