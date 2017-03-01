<?php
	global $tpl_listgrid;
	global $layout; 
	$hide_load_more_btn = ''; ?>
	<div class="content-block content-sub">
		<div class="container">
			<div class="filter-option filter-option-list">
				<div class="layout-action">
					<a href="javascript:void(null);" name="list" class="link link-list <?php if($tpl_listgrid == 'list'){ echo ' active';} ?>"><span class="icon-list"></span></a>
					<a href="javascript:void(null);" name="grid" class="link link-grid <?php if($tpl_listgrid == 'grid'){ echo ' active';} ?>"><span class="icon-grid"></span></a>
				</div>
				<div class="select-holder search-filter">
					<a href="#" class="btn btn-primary btn-filter"><i class="fa fa-sliders"></i> <?php _e('FILTER', 'entrada'); ?></a>
					<div class="filter-slide">
						<div class="select-col">
							<select class="filter-select" id="filter_holiday_type">
								<option value=""><?php _e('Holiday Type', 'entrada'); ?></option>
								<option value=""><?php _e('All Holiday Types', 'entrada'); ?></option>
								<?php 
									$holiday_types = get_terms( 'holiday_type', 'hide_empty=0' );
									if ( $holiday_types ) {
										foreach ( $holiday_types as $holiday_type ) { ?>
											<option value="<?php echo $holiday_type->slug; ?>"><?php echo $holiday_type->name; ?></option>
									<?php
										}
									} ?>
							</select>
						</div>
						<div class="select-col">
						<?php echo entrada_custom_taxonomy_in_optgroup('destination', 'filter_destination', 'filter-select', 'filter_destination', $current_selected = ''); ?>
						</div>
						<div class="select-col">
							<select class="filter-select" id="filter_activity_level">
								<option value=""><?php _e('Difficulty', 'entrada'); ?></option>
								<option value=""><?php _e('All Difficulties', 'entrada'); ?></option>
								<?php 
									$activity_levels = get_terms( 'activity_level', 'orderby=id&order=asc&hide_empty=0' );
									if ( $activity_levels ) {
										foreach ( $activity_levels as $activity_level ) { ?>
											<option value="<?php echo $activity_level->slug; ?>"><?php echo $activity_level->name; ?></option>
									<?php 
										}
									} ?>
							</select>
						</div>
						<div class="select-col">
							<select class="filter-select" id="filter_activities">
								<option value=""><?php _e('Activity', 'entrada'); ?></option>
								<option value=""><?php _e('All Activities', 'entrada'); ?></option>
								<?php
									$product_cats = get_terms( 'product_cat', 'orderby=id&order=asc&hide_empty=0' );
									if ( $product_cats ) {
										foreach ( $product_cats as $product_cat ) { ?>
											<option value="<?php echo $product_cat->slug; ?>"><?php echo $product_cat->name; ?></option>
									<?php 
										}
									} ?>
							</select>
						</div>
						<div class="select-col">
							<select class="filter-select" id="filter_price_range">
								<option value=""><?php _e('Price Range', 'entrada'); ?></option>
								<option value=""><?php _e('All Price Ranges', 'entrada'); ?></option>
									<?php entrada_product_price_range(true);?>
							</select>
						</div>
					</div>
				</div>
			</div>
			<!-- main article section -->
			<div <?php if($tpl_listgrid == 'list'){ echo ' id="ajax_content_wrapper"'; } ?> class="content-holder <?php echo ($tpl_listgrid == 'grid') ? 'content-sub-holder' : 'list-view'; ?>">
			<?php
				global $loop;
				if($tpl_listgrid == 'grid'){
					echo '<div class="row db-3-col"  id="ajax_content_wrapper">';
				}				
				if ( $loop->have_posts() ) {
					$hide_load_more_btn = 'no';				
					while ( $loop->have_posts() ) : $loop->the_post();				
						get_template_part( 'template-parts/search', $tpl_listgrid );					
					endwhile;
					if( $tpl_listgrid == 'grid' ){
						echo '</div>';
					}				
				}
				else {
					$hide_load_more_btn = '';	
					if($tpl_listgrid == 'grid'){
						echo '</div>';
					}					
					echo '<div class="pagination-wrap" id="have_no_record"><p>'. __("No Trip matches your search criteira", "entrada") .'</p> </div>';
				} ?>		
		</div>
		<!-- pagination wrap -->
		<nav class="loadmore-wrap text-center" style="display:<?php echo ($hide_load_more_btn ? 'block' : 'none'); ?>">
			<input type="hidden" id="search_layout" name="search_layout" value="<?php echo $layout; ?>" >
			<input type="hidden" id="posts_per_page" name="posts_per_page" value="<?php global $posts_per_page; echo $posts_per_page; ?>" />
			<input type="hidden" id="paged" name="paged" value="2" />
            <input type="hidden" id="start_date" name="start_date" value="<?php global $start_date; ?>" />
            <input type="hidden" id="end_date" name="end_date" value="<?php global $end_date; ?>" />
			<a href="javascript:void(null);" id="search_load_more_post" class="btn btn-default"><?php _e('LOAD MORE', 'entrada'); ?></a>
		</nav>
	</div>
</div>