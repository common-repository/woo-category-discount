<div id="wildprog_disc_cat" class="panel wc-metaboxes-wrapper hidden">
    <div class="toolbar toolbar-top">
        <span class="expand-close">
            <a href="#" class="expand_all"><?php esc_html_e('Expand', 'woocatdisc'); ?></a> / <a href="#" class="close_all"><?php esc_html_e('Close', 'woocatdisc');
?></a>
        </span>
        <!-- <select name="wild_disc_cat" class="wild-disc-cat">
            <option value=""><?php esc_html_e('Custom Discount Category', 'woocatdisc'); ?></option>
        </select> -->
        <button type="button" class="button add_disc_cat"><?php esc_html_e('Add Discount Category', 'woocatdisc');
            ?></button>
        <div class="wcd-product-add-cat-desc">
            <b><?php esc_html_e('Pro Tip:', 'woocatdisc');?></b>
            <?php esc_html_e('Avoid hurdle of creating the discount category at product level and start reusing them.', 'woocatdisc');?>
            <a href="https://codecanyon.net/item/woocommerce-category-discount/20332051"><?php esc_html_e('Upgrade to Pro >>', 'woocatdisc'); ?></a>
        </div>
    </div>
    <div class="product_disc_cats wc-metaboxes"> <!-- product_attributes class for shifting up-down -->
        <?php
        if (!empty($wcd_data)) {

            $i = 0;
            $disc_types = $this->model->wcd_get_disc_types();
            $all_roles = $this->model->wcd_get_available_roles();
            $day_arr = $this->model->wcd_get_days_arr();

            foreach ($wcd_data as $data) {

                extract($data);
                include(WOO_CAT_DISC_ADMIN_DIR . '/product-metabox/html-add-disc-cat.php');
                $i++;
            }
        }
        ?>
    </div>
    <?php do_action('woocommerce_product_options_attributes'); ?>
</div>
