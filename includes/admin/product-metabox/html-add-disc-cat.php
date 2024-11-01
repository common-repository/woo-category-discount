<!-- HTML for creating discount category on product meta settings html starts -->
<div data-taxonomy="<?php echo esc_attr( $disc_cat_id ); ?>" class="wcd-disc-cat wc-metabox closed " rel="<?php echo $i; ?>">
    <input class="wcd_disc_cat_id" type="hidden" name="wcd_data[<?php echo $i; ?>][disc_cat_id]" value="<?php echo esc_attr( $disc_cat_id ); ?>">
    <!-- HTML for accordian -->
    <h3>
        <a href="#" class="remove_row delete"><?php esc_html_e('Remove', 'woocatdisc'); ?></a>
        <div class="handlediv" title="<?php esc_html_e('Click to toggle', 'woocatdisc');
?>"></div>
        <strong class="wcd_cat_name"><?php echo esc_attr($disc_cat_name); ?></strong>
    </h3>
    <!-- HTML for data inside accordian -->
    <div class="wcd_data wc-metabox-content">
        <table cellpadding="0" cellspacing="0">
            <tbody>
                <tr>
                    <!-- HTML for Discount Category Name -->
                    <td>
                        <label for="disc_cat_names_<?php echo $i ?>"><?php esc_html_e('Name', 'woocatdisc');
?>:</label>
                        <?php if (!empty($disc_cat_id)) { ?>
                            <strong><?php echo esc_attr($disc_cat_name); ?></strong>
                            <input type="hidden" id="disc_cat_names_<?php echo $i ?>" name="wcd_data[<?php echo $i; ?>][disc_cat_name]" value="<?php echo esc_attr($disc_cat_name); ?>" />
                        <?php } else { ?>
                            <input type="text" id="disc_cat_names_<?php echo $i ?>" name="wcd_data[<?php echo $i; ?>][disc_cat_name]" value="<?php echo esc_attr($disc_cat_name); ?>" />
                        <?php } ?>
                        <p class="description"><?php esc_html_e('The name is how it appears on your site.', 'woocatdisc');
                        ?></p>
                        <input type="hidden" class="disc_cat_position" name="wcd_data[<?php echo $i; ?>][disc_cat_position]" value="<?php echo $i; ?>">
                    </td>

                    <!-- HTML for Discount Category Label -->
                    <td>
                        <label for="disc_cat_labels_<?php echo $i; ?>"><?php esc_html_e('Label', 'woocatdisc');
                        ?>:</label>
                        <input type="text" id="disc_cat_labels_<?php echo $i; ?>" name="wcd_data[<?php echo $i; ?>][disc_label]" value="<?php echo esc_attr($disc_label); ?>" />
                        <p class="description"><?php esc_html_e('Enter Discount label. This will be shown on frontend when discount will be applied. Leave it empty if you want to show "Name" of category.', 'woocatdisc');
                        ?></p>
                    </td>
                </tr>
                <tr>
                    <!-- HTML for Discount Type -->
                    <td>
                        <label for="disc_cat_disc_type_<?php echo $i; ?>"><?php esc_html_e('Select Discount Type', 'woocatdisc');
                        ?>:</label>
                        <?php
                        $disc_type_html = '';
                        $disc_type_html .= '<select id="disc_cat_disc_type_' . $i . '" name="wcd_data[' . $i . '][disc_type]" class="wc-enhanced-select wild-disc-type wcd-has-select2">';
                        foreach ($disc_types as $disc_type_key => $disc_type_val) {
                            $disc_type_html .= '<option value="' . $disc_type_key . '"';
                            if ($disc_type == $disc_type_key)
                                $disc_type_html .= ' selected="selected"';
                            $disc_type_html .= ' >' . $disc_type_val . '</option>';
                        }
                        $disc_type_html .= '</select>';
                        echo $disc_type_html;
                        ?>
                        <p class="description"><?php esc_html_e('Select Discount Type.', 'woocatdisc');
                        ?></p>
                    </td>

                    <!-- HTML for Discount Amount -->
                    <td>
                        <label for="disc_amt_<?php echo $i; ?>"><?php esc_html_e('Discount Amount', 'woocatdisc');
                        ?></label>
                        <input type="number" id="disc_amt_<?php echo $i; ?>" name="wcd_data[<?php echo $i; ?>][disc_amt]" min="0" step=0.01 value="<?php echo isset($disc_amt) ? esc_attr( $disc_amt ) : ''; ?>">
                        <p class="description"><?php _e('Enter Discount Amount.', 'woocatdisc');
                        ?></p>
                    </td>
                </tr>
                <tr>
                    <!-- HTML for Discount Start Date -->
                    <td>
                        <label for="disc_start_date_<?php echo $i; ?>"><?php esc_html_e('Discount Start Date', 'woocatdisc');
                        ?></label>
                        <input type="text" id="disc_start_date_<?php echo $i; ?>" name="wcd_data[<?php echo $i; ?>][disc_start_date]" class="wild-disc-start-date" value="<?php echo esc_attr( $disc_start_date ); ?>">
                        <p class="description"><?php esc_html_e('Enter Discount Start Date. Leave it empty if you want to start discount from moment you apply this to product.', 'woocatdisc');
                        ?></p>
                    </td>

                    <!-- HTML for Discount End Date -->
                    <td>
                        <label for="disc_end_date_<?php echo $i; ?>"><?php esc_html_e('Discount End Date', 'woocatdisc');
                        ?></label>
                        <input type="text" id="disc_end_date_<?php echo $i; ?>" name="wcd_data[<?php echo $i; ?>][disc_end_date]" class="wild-disc-end-date" value="<?php echo esc_attr($disc_end_date); ?>">
                        <p class="description"><?php esc_html_e('Enter Discount End Date. You can enter date after which discount will not be applied on product. Leave it empty to allow discount for infinite time.', 'woocatdisc');
                        ?></p>
                    </td>
                </tr>
                <tr>
                    <!-- HTML for Discount Role -->
                    <td>
                        <label for="disc_roles_<?php echo $i; ?>" class="wild-prog-disc-roles-label">
                            <?php esc_html_e('Select Discount Role', 'woocatdisc'); ?>
                        </label>
                        <span class="wild-prog-form-field-easy-select">
                            <a class="wild-prog-select-all-roles" data-id="<?php esc_attr_e($i); ?>" href="#">
                                <?php esc_html_e('Select All', 'woocatdisc');?>
                            </a>
                            <?php esc_html_e(' / ', 'woocatdisc');?>
                            <a class="wild-prog-unselect-all-roles" data-id="<?php esc_attr_e($i); ?>" href="#">
                                <?php esc_html_e('Unselect All', 'woocatdisc');?>
                            </a>
                        </span>
                        <?php
                        $role_html = '';
                        $role_html .= '<select style="width:90% !important;" id="disc_roles_' . $i . '" name="wcd_data[' . $i . '][disc_role][]" multiple="multiple" class="wild-disc-roles wcd-has-select2">';
                        foreach ($all_roles as $all_role_key => $all_role_val) {
                            $role_html .= '<option value="' . $all_role_key . '"';
                            if (!empty($disc_role) && in_array($all_role_key, $disc_role))
                                $role_html .= ' selected="selected"';
                            $role_html .= ' >' . $all_role_val['name'] . '</option>';
                        }
                        $role_html .= '</select>';

                        echo $role_html;
                        ?>
                        <p class="description"><?php esc_html_e('Select Roles for whom you want to give discount. Leave empty if you want to allow discount for all roles.', 'woocatdisc');
                        ?></p>
                    </td>

                    <!-- HTML for Discount Days -->
                    <td>
                        <label for="disc_days_<?php echo $i; ?>" class="wild-prog-disc-days-label">
                            <?php esc_html_e('Select Discount Days', 'woocatdisc'); ?>
                        </label>
                        <span class="wild-prog-form-field-easy-select">
                            <a class="wild-prog-select-all-days" data-id="<?php esc_attr_e($i); ?>" href="#">
                                <?php esc_html_e('Select All', 'woocatdisc');?>
                            </a>
                            <?php esc_html_e(' / ', 'woocatdisc');?>
                            <a class="wild-prog-unselect-all-days" data-id="<?php esc_attr_e($i); ?>" href="#">
                                <?php esc_html_e('Unselect All', 'woocatdisc');?>
                            </a>
                        </span>
                        <?php
                        $day_html = '';
                        $day_html .= '<select multiple="multiple" id="disc_days_' . $i . '" name="wcd_data[' . $i . '][disc_day][]" multiple="multiple" class="wild-disc-day wcd-has-select2">';
                        foreach ($day_arr as $day_key => $day_val) {
                            $day_html .= '<option value="' . $day_key . '"';
                            if (!empty($disc_day) && in_array($day_key, $disc_day))
                                $day_html .= ' selected="selected"';
                            $day_html .= ' >' . $day_val . '</option>';
                        }
                        $day_html .= '</select>';

                        echo $day_html;
                        ?>
                        <p class="description"><?php esc_html_e('Select days on which you want to give discount. Leave empty if you want to allow discount on all days.', 'woocatdisc');
                        ?></p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<!-- HTML for creating discount category on product meta settings html starts -->