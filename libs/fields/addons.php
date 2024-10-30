<?php
defined('ABSPATH') or die;

/**
 *
 * Field: Addons Info
 *
 * @since 1.3.0
 * @version 1.0.0
 */

if (!class_exists('CSF_Field_Addons')) {
    class CSF_Field_Addons extends CSF_Fields {
        public function __construct( $field, $value = '', $unique = '', $where = '', $parent = '' ) {
            parent::__construct( $field, $value, $unique, $where, $parent );
        }

        public function render() {
            echo $this->field_before();

            $addons = isset($this->field['addons']) ? $this->field['addons'] : array();

            ?>
            <div class="latmmo-addons">
                <?php foreach ($addons as $addon) :
                    ?>
                    <div class="latmmo-addon ocanus-addon-<?php echo esc_attr($addon['id']); ?>">
                        <?php if ($addon['thumbnail']) : ?>
                        <div class="latmmo-addon-thumbnail">
                            <img class="latmmo-addon-thumbnail-img" src="<?php echo esc_url($addon['thumbnail']); ?>" alt="<?php echo esc_attr($addon['title']); ?>" />
                        </div>
                        <?php endif; ?>

                        <div class="latmmo-addon-info">
                            <h3><?php echo esc_attr($addon['title']); ?></h3>
                            <div class="latmmo-addon-desc">
                                <?php echo esc_attr($addon['desc']); ?>
                            </div>
                            <div class="latmmo-addon-actions">
                                <a href="<?php echo $addon['detail_url']; ?>" class="button button-primary latmmo-addon-more-detail" target="_blank">
                                    <?php echo esc_html__('More Details', 'latmmo-aff-amazon'); ?>
                                </a>
                                <?php if (!class_exists($addon['class'])) : ?>
                                    <a href="<?php echo $addon['buy_now_url']; ?>" class="button button-primary button-primary latmmo-addon-buy-now" target="_blank">
                                        <?php echo esc_html__('Buy Now!', 'latmmo-aff-amazon'); ?>
                                    </a>
                                <?php else : ?>
                                    <span class="latmmo-addon-installed-msg"><?php echo esc_html__('Addon Installed!', 'latmmo-aff-amazon'); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <?php
            echo $this->field_after();
        }
    }
}

