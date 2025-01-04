<?php
function zahok_options_form() {
    $outputMessage = '';
    ?>
    <div class="wrap">
        <h1><?php esc_html_e('Zahok settings', 'zahok'); ?></h1>
        <?php
        if (isset($_POST['zahok_api_key']) && isset($_POST['zahok_api_secret'])) {
            $zahok_api_key = sanitize_text_field($_POST['zahok_api_key']);
            $zahok_api_secret = sanitize_text_field($_POST['zahok_api_secret']);
            $zahokResponse = wp_remote_post( 
                                                ZAHOK_URL . '/api/public/active-apikey',
                                                [
                                                    'body'  => json_encode( 
                                                                        array(
                                                                        'api_key' =>$zahok_api_key,
                                                                        'api_secret' => $zahok_api_secret,
                                                                    ) 
                                                                ),
                                                    'headers'   => array( 'Content-Type' => 'application/json')
                                                ]
                                            );
            ob_start();
            if( is_wp_error( $zahokResponse ) ) {
                ?>
                <p style="color:red;"><?php echo $zahokResponse->get_error_message(); ?></p>
                <?php
            } else {
                // Success
                $response_body = wp_remote_retrieve_body( $zahokResponse );
                $response_body = json_decode( $response_body, true );
                if($response_body['type'] == false){
                    update_option('zahok_api_key', "");
                    update_option('zahok_api_secret', "");
                    ?>
                        <p style="color:red;"><?php echo $response_body['message']; ?></p>
                    <?php
                }else{
                    ?>
                        <h3 style="color:green;"><?php echo $response_body['message']; ?></h3>
                    <?php
                    update_option('zahok_api_key', $zahok_api_key);
                    update_option('zahok_api_secret', $zahok_api_secret);
                }
            }
            $outputMessage = ob_get_clean();
            
        }
        $zahok_api_key = get_option('zahok_api_key');
        $zahok_api_secret = get_option('zahok_api_secret');
        
        ?>
        <a href="https://zahok.com/my-account?tab=api" target="_blank">Click here to get Api key and Secret</a>
        <form method="post" action="">
            <table class="form-table">
                <tbody>
                    <tr>
                        <th>API Key:</th>
                        <td><input class="regular-text" type="text" name="zahok_api_key" value="<?php echo esc_attr($zahok_api_key); ?>" /></td>
                    </tr>
                    <tr>
                        <th>API Secret:</th>
                        <td><input class="regular-text" type="text" name="zahok_api_secret" value="<?php echo esc_attr($zahok_api_secret); ?>" /></td>
                    </tr>
                </tbody>
            </table>
            
         <?php
            echo $outputMessage;
            submit_button();
            ?>
        </form>
    </div>
    <?php
}