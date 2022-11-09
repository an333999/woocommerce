<!-- 
/*HSN added by aji3*/ -->
<!-- New variation created for simple and variable products -->
<!-- custom fileld added for variable products in woocommerce -->
<!-- It is useful for HSN(Hormonized system number), unique product code, unified identification number and etc... -->



<!-- custom field for Variable products -->
<!-- !3333 custem field adding 333! -->

add_action( 'woocommerce_variation_options_pricing', 'bbloomer_add_custom_field_to_variations', 10, 3 );
 
function bbloomer_add_custom_field_to_variations( $loop, $variation_data, $variation ) {
   woocommerce_wp_text_input( array(
'id' => 'hsn[' . $loop . ']',
'class' => 'short',
'label' => __( 'HSN', 'woocommerce' ),
'value' => get_post_meta( $variation->ID, 'hsn', true )
   ) );

}

<!-- !3333 Save custom field 333! -->
 
add_action( 'woocommerce_save_product_variation', 'bbloomer_save_custom_field_variations', 10, 2 );
 
function bbloomer_save_custom_field_variations( $variation_id, $i ) {
   $hsn = $_POST['hsn'][$i];
   if ( isset( $hsn ) ) update_post_meta( $variation_id, 'hsn', esc_attr( $hsn ) );
	
}

<!-- !3333 Store custom field 333! -->

add_filter( 'woocommerce_available_variation', 'bbloomer_add_custom_field_variation_data' );
 
function bbloomer_add_custom_field_variation_data( $variations ) {
   $variations['hsn'] = '<div class="woocommerce_custom_field">HSN- <span id="hsn">' . get_post_meta( $variations[ 'variation_id' ], 'hsn', true ) . '</span></div>';
 return $variations;}





<!-- custom field for single/simple product -->
<!-- 
 /* HSN for single product*/ -->

  

 <!-- !3333  Add field 333! -->
  
add_action( 'woocommerce_product_options_pricing', 'bbloomer_add_RRP_to_products' );      
  
function bbloomer_add_RRP_to_products() {          
    woocommerce_wp_text_input( array( 
        'id' => 'hsn', 
        'class' => 'short wc_input_price', 
        'label' => __( 'HSN', 'woocommerce' ) ,
        
    ));      
}
  

<!-- !333 Save field 333! -->
  
add_action( 'save_post_product', 'bbloomer_save_RRP' );
  
function bbloomer_save_RRP( $product_id ) {
    global $typenow;
    if ( 'product' === $typenow ) {
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
        if ( isset( $_POST['hsn'] ) ) {
            update_post_meta( $product_id, 'hsn', $_POST['hsn'] );
        }
    }
}
  

<!-- !333 Display 333! -->
  
add_action( 'woocommerce_single_product_summary', 'bbloomer_display_RRP', 9 );
  
function bbloomer_display_RRP() {
    global $product;
    if ( $product->get_type() <> 'variable' && $rrp = get_post_meta( $product->get_id(), 'hsn', true ) ) {
        echo '<div class="woocommerce_rrp">';
        _e( 'HSN: ', 'woocommerce' );
        echo '<span>' . wc_price( $hsn ) . '</span>';
        echo '</div>';
    }
}
