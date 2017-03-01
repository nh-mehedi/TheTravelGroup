<?php

if ( ! class_exists( 'WP_Customize_Control' ) ){
    return NULL;
}
/**
 * A class to create a dropdown for all google fonts
 */
 class Entrada_Google_Font_Dropdown_Custom_Control extends WP_Customize_Control{
    private $fonts = false;

    public function __construct( $manager, $id, $args = array(), $options = array() ){
        $this->fonts = $this->get_fonts();
        parent::__construct( $manager, $id, $args );
    }

    /**
     * Render the content of the category dropdown
     *
     * @return HTML
     */
    public function render_content(){
        if( !empty( $this->fonts ) ){ ?>
			<label>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<select <?php $this->link(); ?> class="entrada_google_font_select" >
					<option value=""><?php _e('Default', 'entrada'); ?></option>
				<?php
					foreach( $this->fonts as $v => $i ){
						printf( '<option value="%s" %s>%s</option>', $v, selected($this->value(), $v, false), str_replace( "+", " ", $v ) );
					} ?>
				</select>
			</label>
	<?php
        }
		else{ 
			$all_fonts = array(); 
			$allfonts["PT+Sans"] 				= array( "300", "300italic", "regular", "italic", "600", "600italic", "700", "700italic", "800", "800italic" ); 
			$allfonts["Roboto"] 				= array( "100", "100italic", "300", "300italic", "regular", "italic", "500", "500italic", "700", "700italic", "900", "900italic" ); 
			$allfonts["Open+Sans"] 				= array( "300", "300italic", "regular", "italic", "600", "600italic", "700", "700italic", "800", "800italic" ); 
			$allfonts["Lato"] 					= array( "100", "100italic", "300", "300italic", "regular", "italic", "700", "700italic", "900", "900italic" ); 
			$allfonts["Lora"] 					= array( "regular", "italic", "700", "700italic" ); 
			$allfonts["Montserrat"] 			= array( "regular", "700" ); 
			$allfonts["Raleway"] 				= array( "100", "100italic", "200", "200italic", "300", "300italic", "regular", "italic", "500", "500italic", "600", "600italic", "700", "700italic", "800", "800italic", "900", "900italic" ); 
			$allfonts["PT+Serif"] 				= array( "regular", "italic", "700", "700italic" ); 
			$allfonts["Indie+Flower"] 			= array( "regular" ); 
			$allfonts["Lobster"] 				= array( "regular" ); 
			$allfonts["Cinzel"] 				= array( "regular", "700", "900" ); 
			$allfonts["Shadows+Into+Light"] 	= array( "regular" ); 
			$allfonts["Patrick+Hand"] 			= array( "regular" ); 
			$allfonts["Fredericka+the+Great"] 	= array( "regular" );
			$allfonts["Alef"] 					= array( "regular", "700" ); 
			$allfonts["Cabin+Sketch"] 			= array(  "regular", "700" ); 
			$allfonts["Merienda"] 				= array( "regular", "700" ); ?>
			<label>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<select <?php $this->link(); ?> class="entrada_google_font_select" >
					<option value=""><?php _e('Default', 'entrada'); ?></option>
				<?php
					foreach( $all_fonts as $v => $i ){
						printf( '<option value="%s" %s>%s</option>', $v, selected($this->value(), $v, false), str_replace( "+", " ", $v ) );
					} ?>
				</select>
			</label>
		<?php
			set_transient( 'google_fonts_variant_lists', $all_fonts, 14 * DAY_IN_SECONDS );
		}
    }

    /**
     * Get the google fonts from the API or in the cache
     *
     * @param  integer $amount
     *
     * @return String
     */
    public function get_fonts( $amount = 'all' ){
		$all_fonts = array();
		if ( false === ( $special_query_results = get_transient( 'google_fonts_variant_lists' ) ) ) {
			$googleApi = 'https://www.googleapis.com/webfonts/v1/webfonts?sort=popularity&key=AIzaSyAjlVAd7y3z2Q-clTeHzkLuA_QskrZjzYo';
			$fontContent = wp_remote_get( $googleApi, array('sslverify'   => false) );
			 
			if ( is_array( $fontContent ) && ! is_wp_error( $fontContent ) ) {
				$content = json_decode($fontContent['body']);
				
				if($amount == 'all'){
					$fonts = $content->items;
					sort($fonts);
					if( !empty( $fonts ) ){
						foreach ( $fonts as $k => $v ){
							$family = str_replace( " ", "+", $v->family );
							$all_fonts[$family] = $v->variants;
						} 
					}
				}
			}
			
			set_transient( 'google_fonts_variant_lists', $all_fonts, 14 * DAY_IN_SECONDS );
			return $all_fonts;
		}
		else{
			$variant_lists = get_transient( 'google_fonts_variant_lists' );
			return $variant_lists;
		}
    }

 } ?>