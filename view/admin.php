<div class="wrap">
    <?php if(isset($bolUpdated)) { ?>
        <div id="message" class="updated">
            <p><strong><?php _e('Settings saved.') ?></strong></p>
        </div>
    <?php } ?>

    <?php if(isset($bolError)) { ?>
        <div class="error">
            <p><?php _e('The sum of your requirements is greater than your password length', 'Seitenhype Password Strength'); ?></p>
        </div>
    <?php } ?>

	<h2><?php _e('Password Strength', 'Seitenhype Password Strength'); ?></h2>

	<form method="post" autocomplete="off">
        <?php echo wp_nonce_field( 'update_password_strength' ); ?>
        <table class="form-table">
            <tr>
                <th style="width:400px;"><label for="password_length"><?php _e( 'Password Length', 'Seitenhype Password Strength' ); ?></label></th>
                <td>
                    <select id="password_length" name="intPasswordLength">
                        <optgroup label="<?php _e( 'Weak', 'Seitenhype Password Strength' ); ?>">
                            <?php for ( $i = 6; $i < 16; $i++) { ?>
                                <option value="<?php echo $i; ?>" <?php selected($i, $objVar["intPasswordLength"]); ?>><?php echo $i; ?></option>
                            <?php } ?>
                        </optgroup>
                        <optgroup label="<?php _e( 'Strong', 'Seitenhype Password Strength' ); ?>">
                            <?php for ( $a = 16; $a < 129; $a++) { ?>
                                <option value="<?php echo $a; ?>" <?php selected($a, $objVar["intPasswordLength"]); ?>><?php echo $a; ?></option>
                            <?php } ?>
                        </optgroup>
                    </select>
                </td>
            </tr>
            <tr>
                <th><label for="lowerChar"><?php _e('Should contain at least (x) lowercase character(s)', 'Seitenhype Password Strength'); ?></label></th>
                <td>
                    <input id="lowerChar" name="intLowerChar" class="small-text" type="number" value="<?php echo $objVar["intLowerChar"]; ?>" min="0" step="1"> (<?php _e('e.g.', 'Seitenhype Password Strength'); ?> abcdefgh)
                </td>
            </tr>
            <tr>
                <th><label for="upperChar"><?php _e('Should contain at least (x) uppercase character(s)', 'Seitenhype Password Strength'); ?></label></th>
                <td>
                    <input id="upperChar" name="intUpperChar" class="small-text" type="number" value="<?php echo $objVar["intUpperChar"]; ?>" min="0" step="1"> (<?php _e('e.g.', 'Seitenhype Password Strength'); ?> ABCDEFGH)
                </td>
            </tr>
            <tr>
                <th><label for="numbers"><?php _e('Should contain at least (x) number(s)', 'Seitenhype Password Strength'); ?></label></th>
                <td>
                    <input id="numbers" name="intNumbers" class="small-text" type="number" value="<?php echo $objVar["intNumbers"]; ?>" min="0" step="1"> (<?php _e('e.g.', 'Seitenhype Password Strength'); ?> 123456)
                </td>
            </tr>
            <tr>
                <th><label for="symbols"><?php _e('Should contain at least (x) symbol(s)', 'Seitenhype Password Strength'); ?></label></th>
                <td>
                    <input id="symbols" name="intSymbols" class="small-text" type="number" value="<?php echo $objVar["intSymbols"]; ?>" min="0" step="1"> (<?php _e('e.g.', 'Seitenhype Password Strength'); ?> @#$%)
                </td>
            </tr>
        </table>

        <input type="submit" name="submit" class="button-primary" value="<?php _e('Save', 'Seitenhype Password Strength'); ?>" />
	</form>
</div>
