<?php
if (isset($_POST['submit'])) {

    if ($_POST['EFLoginAppID'] != "") {
        update_option('EFLoginPageAfterLogin_id', $_POST['EFLoginPageAfterLogin'], '', 'yes');
        update_option('EFLoginPageAfterLogOut_id', $_POST['EFLoginPageAfterLogOut'], '', 'yes');
        $aflogin = get_permalink($_POST['EFLoginPageAfterLogin']);
        $aflogout = get_permalink($_POST['EFLoginPageAfterLogOut']);
        update_option('EFLoginAppID', $_POST['EFLoginAppID'], '', 'yes');
        update_option('EFLoginPageAfterLogin', $aflogin, '', 'yes');
        update_option('EFLoginPageAfterLogOut', $aflogout, '', 'yes');
        update_option('EFLoginDefaultRole', $_POST['EFLoginDefaultRole'], '', 'yes');
        update_option('EFLoginGetAvatar', $_POST['EFLoginGetAvatar'], '', 'yes');
        $msg = '<div class="updated" id="message"><p>Settings Saved <strong>Successfully!</strong></p></div>';
    }
}
?>
<div class="wrap">
    <h2>Easy Facebook Login</h2>
    <?php if (isset($msg)) echo $msg; ?>
    <div class="simpleTabs">
        <ul class="simpleTabsNavigation">
            <li><a href="#">Settings</a></li>
            <li><a href="#">How it Works</a></li>        
        </ul>
        <div class="simpleTabsContent">
            <div class="left-col">
                <form method="POST" action="" name="saveAppID">
                    <dl>
                        <dt><?php _e('Facebook AppId:'); ?></dt>
                        <dd>
                            <input type="text" name="EFLoginAppID" value="<?php echo get_option('EFLoginAppID'); ?>"/>
                            <em><?php _e('Please put your facebook app id.'); ?></em>
                        </dd>

                        <dt><?php _e('Page After Login:'); ?></dt>
                        <dd>
                            <?php printf(wp_dropdown_pages(array('name' => 'EFLoginPageAfterLogin', 'echo' => 0, 'show_option_none' => __('&mdash; Select &mdash;'), 'option_none_value' => '0', 'selected' => get_option('EFLoginPageAfterLogin_id')))); ?>
                            <em><?php _e('Please select page for after login redirection.'); ?></em>
                        </dd>

                        <dt><?php _e('Page After Logout:'); ?></dt>
                        <dd>
                            <?php printf(wp_dropdown_pages(array('name' => 'EFLoginPageAfterLogOut', 'echo' => 0, 'show_option_none' => __('&mdash; Select &mdash;'), 'option_none_value' => '0', 'selected' => get_option('EFLoginPageAfterLogOut_id')))); ?>
                            <em><?php _e('Please select page for after logout redirection.'); ?></em>
                        </dd>

                        <dt><?php _e('Default Role for FB User:'); ?></dt>
                        <dd>
                            <select name="EFLoginDefaultRole" id="EFLoginDefaultRole">
                                <?php wp_dropdown_roles(get_option('EFLoginDefaultRole')); ?>
                            </select>
                            <em><?php _e('Please select a role for new user registration.'); ?></em>
                        </dd>

                        <dt><?php _e('Get User Avatar From Facebook:'); ?></dt>
                        <dd>
                            <select name="EFLoginGetAvatar" id="EFLoginGetAvatar">
                                <option value=""> --Select-- </option>
                                <option value="yes" <?php if (get_option('EFLoginGetAvatar') == 'yes') echo "selected"; ?>> Yes</option>
                                <option value="no" <?php if (get_option('EFLoginGetAvatar') == 'no') echo "selected"; ?> >No</option>
                            </select>
                            <em><?php _e('Please select yes, if you like to use facebook image as wordpress profile image'); ?></em>
                        </dd>
                    </dl>

                    <input type="submit" name="submit" class="button button-primary button-large" value="Save"/>
                </form>
            </div>
            <div  class="right-col">
                <h3>Facebook App Setup Instructions</h3>
                To allow your users to login with their Facebook accounts, you must first setup a Facebook Application for your website:<br /><br />
                <ol>
                    <li>Visit <a href="http://developers.facebook.com/apps" target="lnk">developers.facebook.com/apps</a> and select "Create a New App" from the "Apps" menu at the top.</li>
                    <li>Type in a name (i.e. the name of your site), select a category, and click "Create App."</li>
                    <li>Go to the "Settings" page and click "Add Platform," then "Website," then fill in your "Site URL."<br/>
                        Note: http://example.com/ and http://www.example.com/ are <i>not</i> the same.</li>
                    <li>Also on the "Settings" page, enter a Contact EMail and save changes.</li>
                    <li>Go to the "Status &amp; Review" page and make the app live (flip the switch at the top).</li>
                    <li>Copy the App ID to the box(AppId) , and click the "Save" button.</li>
                </ol>
                <br />That's it! 
            </div> <!-- End Tab -->
                    <div style="clear: both;"></div>
            <hr />
            <h3 class="float_left">Easy Facebook Login</h3>
            <h3 class="float_right"><a href="http://www.phpczar.com/" target="_blank">Praveen Singh Shekhawat</a></h3>

        </div>
        <div class="simpleTabsContent">

            <div  class="left-col">
                <h3>Easy Facebook Login Setup Instructions</h3>
                To use this plugin please follow the bellow instruction's.here we will add, how our app works exactly.here we will add, how our app works
                <ol>
                    <li> Go to <a href="<?php echo site_url("/wp-admin/plugins.php?page=easy-facebook-login/efl.admin.page.php"); ?>" target="_blank">plugin satup page</a>. </li>    
                    <li>Fill your facebook app id.</li>    
                    <li>Select your options as you want.</li>    
                    <li>Use this shortcode for your facebook login button. </br> <blockquote><b>[efl-login]</b></blockquote></li>    
                </ol>

            </div>
            <div  class="right-col">
                <h3>Facebook App Setup Instructions</h3>
                To allow your users to login with their Facebook accounts, you must first setup a Facebook Application for your website:<br /><br />
                <ol>
                    <li>Visit <a href="http://developers.facebook.com/apps" target="lnk">developers.facebook.com/apps</a> and select "Create a New App" from the "Apps" menu at the top.</li>
                    <li>Type in a name (i.e. the name of your site), select a category, and click "Create App."</li>
                    <li>Go to the "Settings" page and click "Add Platform," then "Website," then fill in your "Site URL."<br/>
                        Note: http://example.com/ and http://www.example.com/ are <i>not</i> the same.</li>
                    <li>Also on the "Settings" page, enter a Contact EMail and save changes.</li>
                    <li>Go to the "Status &amp; Review" page and make the app live (flip the switch at the top).</li>
                    <li>Copy the App ID to the box(AppId) , and click the "Save" button.</li>
                </ol>
                <br />That's it! 
            </div>
            <div style="clear: both;"></div>
            <hr />
            <h3 class="float_left">Easy Facebook Login</h3>
            <h3 class="float_right"><a href="http://www.phpczar.com/" target="_blank">Praveen Singh Shekhawat</a></h3>
        </div>
    </div>
</div>