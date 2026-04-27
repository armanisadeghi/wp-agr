 <?php 
if($_POST){
    update_option( 'insightly_api_key', $_POST['api-key']);
}
?>
<form method="post" action="#">
    <?php settings_fields( 'myplugin_options_group' ); ?>
    <h3>Insightly settings</h3>
    <p></p>
    <table>
        <tr valign="top">
            <th scope="row"><label for="myplugin_option_name">Enter Api Key</label></th>
            <td><input type="text" id="api key" name="api-key" value="<?php echo get_option('insightly_api_key');?>" style="width: 350px;" /></td>
        </tr>
    </table>
    <?php  submit_button(); ?>
</form>
<?php  ?>