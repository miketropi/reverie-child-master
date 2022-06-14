<form role="search" method="get" id="searchform" action="<?php echo home_url('/'); ?>">
	<input type="text" value="" name="s" id="s" placeholder="<?php esc_attr_e('Search', 'reverie'); ?>">
	<div class="search-btn"><input type="submit" id="searchsubmit" value="Find Items" class="button postfix"></div>
</form>