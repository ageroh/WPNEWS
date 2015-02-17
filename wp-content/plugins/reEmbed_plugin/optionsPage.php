<?php
    if ( isset( $_POST[ 'after_post' ] ) && $_POST[ 'after_post' ] == 'Y' ) {
        // form data sent
        $code = $_POST[ 'reembed_script_code' ];
        update_option( 'reembed_script_code', $code );
    }
    // normal page display
    ?><div class="wrap">
        <h2>reEmbed Script Options</h2>
        <form name="reembed_form" method="post">
            <input type="hidden" name="after_post" value="Y" />
            <label for="code">reEmbed video code</label>
            <p><input type="text" name="reembed_script_code" value="<?php
                if ( isset( $code ) || $code = get_option( 'reembed_script_code' ) ) {
                    echo $code;
                }
            ?>" size="50" /></p>
            <p><input type="submit" value="Update Code" /></p>
        </form>
        <?php
            if ( empty( $code ) ) {
                ?><p>Don't have a code?<a href="http://app.reembed.com/users/signup"> Get one now!</a></p><?php
            }
        ?>
    </div><?php
