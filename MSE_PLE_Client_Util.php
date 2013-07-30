<?php
	
	if(!class_exists('MSE_PLE_Client_Util'))
	{
		Class MSE_PLE_Client_Util
		{
			private $WP_OPTION_PREFIX = NULL;
			private $PLUGIN_SOFTWARE_NAME = NULL;
			
			const WP_OPTION_PLE_KEY_NAME = '_ple_key_name';
			const WP_OPTION_PLE_KEY_EMAIL = '_ple_key_email';
			const WP_OPTION_PLE_KEY_EXPIRETIME = '_ple_key_expiretime';
			const WP_OPTION_PLE_KEY_ACTIVATION_KEY = '_ple_key_activation_key';
			const WP_OPTION_PLE_KEY_VALIDATED_TODAY = '_ple_key_validated_today';
			const WP_OPTION_RESET_FIELD_NAME = 'frm_ple_reset_field_key';
			
			public function activate($key,$software){
				$auth_data = $this->getAPIAuthData($key,$software);
				$json = json_encode($auth_data);
				$url = $this->getURLFor("activate");
				return $this->getHttpResult($url, $json);
			}
			
			public function validate($key,$software){
				$auth_data = $this->getAPIAuthData($key,$software);
				$json = json_encode($auth_data);
				$url = $this->getURLFor("validate");
				return $this->getHttpResult($url, $json);
			}
			
			public function getFeatures($key,$software){
				$auth_data = $this->getAPIAuthData($key,$software);
				$json = json_encode($auth_data);
				$url = $this->getURLFor("features");
				return $this->getHttpResult($url, $json);
			}
			
			public function getStatus($key,$software){
				$auth_data = $this->getAPIAuthData($key,$software);
				$json = json_encode($auth_data);
				$url = $this->getURLFor("status");
				return $this->getHttpResult($url, $json);
			}
			
			public function reset($key,$software){
				$auth_data = $this->getAPIAuthData($key,$software);
				$json = json_encode($auth_data);
				$url = $this->getURLFor("reset");
				return $this->getHttpResult($url, $json);
			}
			
			private function getAPIAuthData($key=null, $software=null) {
				$auth_data = array('host' => $this->getHost());
				$auth_data['key'] = $key;
				$auth_data['software'] = $software;
				return $auth_data;
			}
			
			private function getURLFor($name) {
				return "http://www.wpfrogs.com/plm/services/licensegateway/$name.json";
				//return "http://localhost/plm/services/licensegateway/$name.json";
			}
			
			private function getHttpHeaders() {
				return array('Content-Type' => 'application/json');
			}
			
			private function getHttpResult($url, $json) {
				$request = new WP_Http;
				$result = $request->request( $url , array( 'method' => 'POST', 'body' => $json, 'headers' => $this->getHttpHeaders()));
				$result_json = json_decode($result['body'], true);
				//var_dump($result_json);
				//die;
				return $result_json;		
			}
			
			private function getHost() {
				if ($host = $_SERVER['HTTP_X_FORWARDED_HOST'])
				{
					$elements = explode(',', $host);

					$host = trim(end($elements));
				}
				else
				{
					if (!$host = $_SERVER['HTTP_HOST'])
					{
						if (!$host = $_SERVER['SERVER_NAME'])
						{
							$host = !empty($_SERVER['SERVER_ADDR']) ? $_SERVER['SERVER_ADDR'] : '';
						}
					}
				}
				// Remove port number from host
				$host = preg_replace('/:\d+$/', '', $host);
				return trim($host);
			}
			
			public function init($prefix_name,$software_name){
				$this->WP_OPTION_PREFIX = $prefix_name;
				$this->PLUGIN_SOFTWARE_NAME = $software_name;
			}
			
			public function preCheckLicense(){
//exit("Hello");
				if(isset($_POST[MSE_PLE_Client_Util::WP_OPTION_RESET_FIELD_NAME])){
					$this->reset($this->getActivationKey(), $this->PLUGIN_SOFTWARE_NAME);
					$this->removeActiovationDetails();
			
				}
				if(isset($_POST['submit_activationkey'])){
					if(isset($_POST['activation_key'])  && trim($_POST['activation_key']) != ''){
						 
						$response = $this->activate($_POST['activation_key'],$this->PLUGIN_SOFTWARE_NAME);
						//var_dump($response);
						if ($this->responseHasResult($response)) {
							$this->saveActivationResult($response['RESULT']);
						} else {//exit("here");
							$this->parseAndSetError($response);
							$this->showActivationPage();//exit("Hello");
							return true;
						}
					}
					else{	
						echo "<div class='error'><p>Please enter a valid key!</p></div>";
						$this->showActivationPage();//exit("Hello1");
						return true;
					}
				}
				else{
					if($this->WP_OPTION_PREFIX){
						if(!$this->hasLicense()){
							$this->showActivationPage();//exit("Hello2");
							return true;
						}
						elseif(!$this->isCheckedToday()){
							$response = $this->getStatus($this->getActivationKey(),$this->PLUGIN_SOFTWARE_NAME);
							if($this->responseHasStatusResult($response)){
								$this->setValidateDate();
								if($response['STATUS'] == 'warning')
									echo "<div class='updated'><p>".$response['RESULT']."</p></div>";
							}
							else{
								$this->parseAndSetError($response);//exit("Hello3");
								return true;
							}
						}
						
					}
				}
				$this->setResetLink();
				return false;
			}
			
			private function getActivationKey() {
				$PREFIX = $this->WP_OPTION_PREFIX;
				return get_option($PREFIX.MSE_PLE_Client_Util::WP_OPTION_PLE_KEY_ACTIVATION_KEY);
			}
			
			public function hasLicense(){
				return $this->getActivationKey();
			}
			
			private function isCheckedToday() {
				$PREFIX = $this->WP_OPTION_PREFIX;
				$validate_date = date(get_option($PREFIX.MSE_PLE_Client_Util::WP_OPTION_PLE_KEY_VALIDATED_TODAY)); 
				$todays_date = date("Y-m-d"); 
				$todays_time = strtotime($todays_date); 
				$validate_time = strtotime($validate_date);
				if ($validate_time == $todays_time) {
					return true;
				}
				return false;
			}
			
			private function setValidateDate() {
				$PREFIX = $this->WP_OPTION_PREFIX;
				update_option($PREFIX.MSE_PLE_Client_Util::WP_OPTION_PLE_KEY_VALIDATED_TODAY, date("Y-m-d"));
			}
			private function showActivationPage(){
				$form = <<<ACTFORM
				<form name="activation_key_form" method="post" action="#">
					<table style="width: 50%; margin: 25px auto;" align="center" class="wp-list-table widefat plugins">
						<thead>
						<tr>
							<th colspan="2"><b>License Activation<b></th>
						</tr>
						</thead>
						<tr>
							<td width="25%">License Key</td>
							<td>
								<input style="width: 100%;font-size:1.5em" type="text" name="activation_key"/>
							</td>
						</tr>
						<tr>
							<td width="25%"></td>
							<td >
							<input style="width: 50%;height: 35px;" class="button" type="submit" name="submit_activationkey" value="Activate"/>
							</td>
						</tr>						
						
					</table>
				</form>
ACTFORM;
			echo $form;
			}
			
			private function getJavaScript() {
				$js = <<<JS
					<script type="text/javascript">
						function onLicenseInfo() {
							jQuery( "#dialog-message" ).dialog({
								modal: true,
								buttons: {
									Ok: function() {
									jQuery( this ).dialog( "close" );
									}
								}
							});
							jQuery("#dialog-message").dialog( "option", "width", "35%" );
							jQuery(".ui-dialog-titlebar").hide();
						}
						
						function onResetLicense() {
						document.getElementById("frm_ple_client_util_reset").submit();				
						}
						
					</script>			
JS;
			echo $js;
		}
			
			private function setResetLink() {
//exit("Hi");
			$reset_input_name = MSE_PLE_Client_Util::WP_OPTION_RESET_FIELD_NAME;
			$PREFIX = $this->WP_OPTION_PREFIX;
			$name = get_option($PREFIX.MSE_PLE_Client_Util::WP_OPTION_PLE_KEY_NAME);
			$email = get_option($PREFIX.MSE_PLE_Client_Util::WP_OPTION_PLE_KEY_EMAIL);
			$key = get_option($PREFIX.MSE_PLE_Client_Util::WP_OPTION_PLE_KEY_ACTIVATION_KEY);
			$expireOn =  get_option($PREFIX.MSE_PLE_Client_Util::WP_OPTION_PLE_KEY_EXPIRETIME);
			wp_enqueue_script("myUi","http://code.jquery.com/ui/1.10.3/jquery-ui.js");
			wp_enqueue_style("myStyle","http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css");
			$form = <<<ACTFORM
					<style>
					{include "ss-style.css";}
					</style>
					{$this->getJavaScript()}   
					<div id="dialog-message" title="License Information" style="display: none;">
						<table class="wp-list-table widefat plugins" width="100%">
							<thead>
								<tr>
									<th colspan="3">License details<span style="float:right"><a href="#" onclick="onResetLicense()">Reset</a></span></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>Name</td><td>:</td><td>{$name}</td>
								</tr>
								<tr>
									<td>Email</td><td>:</td><td>{$email}</td>
								</tr>
								<tr>
									<td>Key</td><td>:</td><td>{$key}</td>
								</tr>
								<tr>
									<td>Expire on</td><td>:</td><td>{$expireOn}</td>
								</tr>
							</tbody>
						</table>
					</div>					
					<form name="frm_ple_client_util_reset" id="frm_ple_client_util_reset" method="post">
						<input type="hidden" name="{$reset_input_name}" id="{$reset_input_name}" value="Reset"/>
					</form>
					<h3>Your {$this->PLUGIN_SOFTWARE_NAME} plugin is now active</h3>
					<span style="float:right;padding-right:3em;"><a href='#' onclick="onLicenseInfo()">License Info</a> | <a href='#' onclick="onResetLicense()">Reset License</a></span>
ACTFORM;
			echo $form;
				
			}
						
			private function responseHasResult($response) {
				if ($response != null && isset($response['STATUS'])
					&& $response['STATUS'] == 'success'
					&& isset($response['RESULT'])
					&& !empty($response['RESULT']))
					return true;
				else
					return false;
			}
			
			private function responseHasStatusResult($response) {
				if ($response != null && isset($response['STATUS'])
					&& ($response['STATUS'] == 'success' || $response['STATUS'] == 'warning')
					&& isset($response['RESULT'])
					&& !empty($response['RESULT']))
					return true;
				else
					return false;
			}
			
			private function parseAndSetError($response) {
				if ($response != null && isset($response['STATUS'])) {
					if ($response['STATUS'] == 'error') {
						echo "<div class='error'><p>".$response['RESULT']."</p></div>";
					} else if ($response['STATUS'] == 'warning') {
						echo "<div class='updated'><p>".$response['RESULT']."</p></div>";
					} else {
						echo "<div class='error'><p>Request failed!</p></div>";
					}
				} else {
					echo "<div class='error'><p>Failed to connect license server!</p></div>";
				}
			}
			
			private function saveActivationResult($results) {
				$PREFIX = $this->WP_OPTION_PREFIX;
				//$this->removeActiovationDetails();
				add_option($PREFIX.MSE_PLE_Client_Util::WP_OPTION_PLE_KEY_NAME, $results['name']);
				add_option($PREFIX.MSE_PLE_Client_Util::WP_OPTION_PLE_KEY_EMAIL, $results['email']);
				add_option($PREFIX.MSE_PLE_Client_Util::WP_OPTION_PLE_KEY_EXPIRETIME, $results['expiretime']);
				add_option($PREFIX.MSE_PLE_Client_Util::WP_OPTION_PLE_KEY_ACTIVATION_KEY, $results['key']);
				add_option($PREFIX.MSE_PLE_Client_Util::WP_OPTION_PLE_KEY_VALIDATED_TODAY, date("Y-m-d"));
			}
			
			private function removeActiovationDetails() {
				
				$PREFIX = $this->WP_OPTION_PREFIX;
				delete_option($PREFIX.MSE_PLE_Client_Util::WP_OPTION_PLE_KEY_NAME);
				delete_option($PREFIX.MSE_PLE_Client_Util::WP_OPTION_PLE_KEY_EMAIL);
				delete_option($PREFIX.MSE_PLE_Client_Util::WP_OPTION_PLE_KEY_EXPIRETIME);
				delete_option($PREFIX.MSE_PLE_Client_Util::WP_OPTION_PLE_KEY_ACTIVATION_KEY);
				delete_option($PREFIX.MSE_PLE_Client_Util::WP_OPTION_PLE_KEY_VALIDATED_TODAY);
			}
			
			public function onPluginDeactivate() {
				
				$this->removeActiovationDetails();
			}
		
			
		}
	}
?>
