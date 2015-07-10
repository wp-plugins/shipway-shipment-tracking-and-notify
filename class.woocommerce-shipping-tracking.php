<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'WooCommerce_Shipping_Tracking' ) ) {

	
	class WooCommerce_Shipping_Tracking {

		/**
		 * @var $_panel Panel Object
		 */
		protected $_panel;
		
        private $options; 
		
		 public function __construct() {

		 $this->initialize_settings();

			add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
			add_action( 'admin_init', array( $this, 'page_init' ) );
			add_action( 'add_meta_boxes', array( $this, 'add_order_tracking_metabox' ) );
			add_action( 'woocommerce_process_shop_order_meta', array( $this, 'save_order_tracking_metabox' ), 10 );
	}
		






		/**
		 * Set values from plugin settings page
		 */
		public function initialize_settings() {
			$this->default_carrier     = get_option( 'ship_carrier_default_name' );
			$this->order_text_position = get_option( 'ship_order_tracking_text_position' );
		}

		

	
		function add_order_tracking_metabox() {
         $userdata =  get_option('my_option_name'); 
          if($userdata){
			add_meta_box( 'order-tracking-information', __( 'Order tracking', 'ship' ), array(
				$this,
				'show_order_tracking_metabox'
			), 'shop_order', 'side', 'high' );
		}
}
		
		
		
		function show_order_tracking_metabox( $post ) {
		
		  $userdata =  get_option('my_option_name'); 
          if($userdata){
		  
			$data                = get_post_custom( $post->ID );
			$order_tracking_code = isset( $data['ship_tracking_code'][0] ) ? $data['ship_tracking_code'][0] : '';
			$order_carrier_name  = isset( $data['ship_courier_name'][0] ) ? $data['ship_courier_name'][0] : '';
			
			
			if($order_tracking_code != ''  &&  $order_carrier_name != ''  ){	?>
			
				<div class="track-information">
				<p>
					<label for="ship_tracking_code"> <?php _e( 'Tracking code:', 'ship' ); ?></label><?php echo $order_tracking_code; ?>
					
				
				</p>
				
					<p>
				<label for="ship_courier_name"> <?php _e( 'Courier:', 'ship' ); ?></label>
				

				<?php if (isset($order_carrier_name) && $order_carrier_name=="11") echo "Aramex";?>
				<?php if (isset($order_carrier_name) && $order_carrier_name=="1") echo "Bluedart";?>
				<?php if (isset($order_carrier_name) && $order_carrier_name=="2") echo "Delhivery";?>
				<?php if (isset($order_carrier_name) && $order_carrier_name=="12") echo "Dhl";?>
				<?php if (isset($order_carrier_name) && $order_carrier_name=="8") echo "Dotzot";?>
				<?php if (isset($order_carrier_name) && $order_carrier_name=="7") echo "Dtdc";?>
				<?php if (isset($order_carrier_name) && $order_carrier_name=="6") echo "Ecom Express";?>
				<?php if (isset($order_carrier_name) && $order_carrier_name=="5") echo "Fedex";?>
				<?php if (isset($order_carrier_name) && $order_carrier_name=="10") echo "First Flight";?>
				<?php if (isset($order_carrier_name) && $order_carrier_name=="3") echo "Gati";?>
				<?php if (isset($order_carrier_name) && $order_carrier_name=="4") echo "Gojavas";?>
				<?php if (isset($order_carrier_name) && $order_carrier_name=="13") echo "The Professional Couriers";?>

				</p>
				
				</div>
	<?php } else {?>
			<div class="track-information">
				<p>
					<label for="ship_tracking_code"> <?php _e( 'Tracking code:', 'ship' ); ?></label>
					<br/>
					<input style="width: 100%" type="text" name="ship_tracking_code" id="ship_tracking_code"
					       placeholder="<?php _e( 'Enter tracking code', 'ship' ); ?>"
					       value="<?php echo $order_tracking_code; ?>"/>
				</p>

				<p>
					<label for="ship_courier_name"> <?php _e( 'Courier:', 'ship' ); ?></label>
					<br/>
					
					<select id="ship_courier_name" name="ship_courier_name">
					<option value="0" <?php if (isset($order_carrier_name) && $order_carrier_name=="0") echo "selected";?>>Select..</option>
					<option value="11" <?php if (isset($order_carrier_name) && $order_carrier_name=="11") echo "selected";?>>Aramex</option>
					<option value="1" <?php if (isset($order_carrier_name) && $order_carrier_name=="1") echo "selected";?>>Bluedart</option>
					<option value="2" <?php if (isset($order_carrier_name) && $order_carrier_name=="2") echo "selected";?>>Delhivery</option>
					<option value="12" <?php if (isset($order_carrier_name) && $order_carrier_name=="12") echo "selected";?>>dhl</option>
					<option value="8" <?php if (isset($order_carrier_name) && $order_carrier_name=="8") echo "selected";?>>dotzot</option>
					<option value="7" <?php if (isset($order_carrier_name) && $order_carrier_name=="7") echo "selected";?>>dtdc</option>
					<option value="6" <?php if (isset($order_carrier_name) && $order_carrier_name=="6") echo "selected";?>>ecom express</option>
					<option value="5" <?php if (isset($order_carrier_name) && $order_carrier_name=="5") echo "selected";?>>fedex</option>
					<option value="10" <?php if (isset($order_carrier_name) && $order_carrier_name=="10") echo "selected";?>>first flight</option>
					<option value="3" <?php if (isset($order_carrier_name) && $order_carrier_name=="3") echo "selected";?>>gati</option>
					<option value="4" <?php if (isset($order_carrier_name) && $order_carrier_name=="4") echo "selected";?>>gojavas</option>
					<option value="13" <?php if (isset($order_carrier_name) && $order_carrier_name=="13") echo "selected";?>>the professional couriers</option>
					</select>
					</p>

					</div>
		<?php
}
		}
		}
		


		function save_order_tracking_metabox( $post_id ) {
		
	
		
			$post_id=$post_id ;
			$key='ship_tracking_code';
			$single = TRUE;
		if ( get_post_meta($post_id, $key, $single) ) {
	
			$a =  get_option('my_option_name'); 
	

	} else {
           $a =  get_option('my_option_name'); 
 
           if(isset($_POST['ship_tracking_code'])   &&   $_POST['ship_tracking_code'] != '' ){
					$data = array();
					$data['first_name']    	= $_POST['_billing_first_name'];
					$data['last_name'] 	   	= $_POST['_billing_last_name'];
					$data['email']         	= $_POST['_billing_email'];
					$data['phone']         	= $_POST['_billing_phone'];
					$data['products']      	= 'aaaaa';
					$data['company']	   	= 'Onjection';
					$data['carrier_id']    	= $_POST['ship_courier_name'];
					$data['order_id'] 	   	= $_POST['ID'];
					$data['awb']         	= $_POST['ship_tracking_code'];
					$data['username']         	= $a['id_number'];
					$data['password']      	= $a['title'];

			$url = "http://shipway.in/api/pushOrderData";
			
			$data_string = json_encode($data);
			
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_HTTPHEADER, array(
				'Content-Type:application/json'
			));
			curl_setopt($curl, CURLOPT_URL, $url);
			curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			
			$output = curl_exec($curl);
			$output = json_decode($output);
			curl_close($curl);

	     
	}
	 
	}

 	update_post_meta( $post_id, 'ship_tracking_code', stripslashes( $_POST['ship_tracking_code'] ) );
			if ( isset( $_POST['ship_courier_name'] ) ) {
				update_post_meta( $post_id, 'ship_courier_name', stripslashes( $_POST['ship_courier_name'] ) );
			}
		}

 public function add_plugin_page()
    {
add_menu_page ( 'Shipway', 'Shipway', 'manage_options', 'my-setting-admin', array( $this, 'create_admin_page' ), '', 20 );
        // This page will be under "Settings"
        /*add_options_page(
            'Settings Admin', 
            'Shipway', 
            'manage_options', 
            'my-setting-admin', 
            array( $this, 'create_admin_page' )
        );*/
    }

    /**
     * Options page callback
     */
    public function create_admin_page()
    {
        // Set class property
        $this->options = get_option( 'my_option_name' );
        ?>
        <div class="wrap">
            <h2>Shipway</h2>           
            <form method="post" action="options.php">
            <?php
                // This prints out all hidden setting fields
                settings_fields( 'my_option_group' );   
                do_settings_sections( 'my-setting-admin' );
                submit_button(); 
            ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init()
    {        
        register_setting(
            'my_option_group', // Option group
            'my_option_name', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

		     
		
		
        add_settings_section(
            'setting_section_id', // ID
            'My Custom Settings', // Title
            array( $this, 'print_section_info' ), // Callback
            'my-setting-admin' // Page
        );  

        add_settings_field(
            'id_number', // ID
            'Login Id', // Title 
            array( $this, 'id_number_callback' ), // Callback
            'my-setting-admin', // Page
            'setting_section_id' // Section           
        );      

        add_settings_field(
            'title', 
            'Licence Key', 
            array( $this, 'title_callback' ), 
            'my-setting-admin', 
            'setting_section_id'
        );      
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input )
    { 	
	$new_input = array();
$url = "http://shipway.in/api/authenticateUser";
        $data_string = array(
            "username" => $input['id_number'],
            "password" => $input['title']
        );
        $data_string = json_encode($data_string);
        $curl        = curl_init();
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type:application/json'
        ));
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $output = curl_exec($curl);		
		curl_close($curl);
        
		$output = json_decode($output);	
		if(isset($output->status) && strtolower($output->status) == 'success'){
			
        if( isset( $input['id_number'] ) )
            $new_input['id_number'] = $input['id_number'];

        if( isset( $input['title'] ) )
            $new_input['title'] =  $input['title'] ;
		
		} else {
		
		
		 add_settings_error(
        'invalid-number',
        '',
        'Invalid Credentials.',
        'error'
            );

		
		
		
		
		}
		
		
		
		
		
		
 
        return $new_input;
    }

    /** 
     * Print the Section text
     */
    public function print_section_info()
    {
        print '<td colspan="2">
					<a href="http://shipway.in/admin/index.php/auth/register" target="_blank" style="background-color: #2eade0;color: #ffffff;text-decoration: none;padding: 4px;border: thin solid #ababab;">Register here</a> 
					<span style="font-size:14px;">for free courier tracking.</span> </td>';
			
    }
	
	
	
    /** 
     * Get the settings option array and print one of its values
     */
    public function id_number_callback()
    { //echo '<pre>'; print_r($_POST);die;
		  printf(
            '<input type="text" id="id_number" name="my_option_name[id_number]" value="%s"  required="required"/>',
            isset( $this->options['id_number'] ) ? esc_attr( $this->options['id_number']) : ''
        );
	
	
      
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function title_callback()
    {
        printf(
            '<input type="text" id="title" name="my_option_name[title]" value="%s"  required="required"/>',
            isset( $this->options['title'] ) ? esc_attr( $this->options['title']) : ''
        );
    }


}
}