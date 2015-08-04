<?php
/**
 * Class to create a custom post type control
 */
if (!class_exists('TG_Post_Type_DropDown_Control')) {

    class TG_Post_Type_DropDown_Control extends TG_Customize_Control
    {
        private $postTypes = array();

        /**
         * @param WP_Customize_Manager $manager
         * @param string $id
         * @param array $args
         * @param array $options
         */
        public function __construct($manager, $id, $args = array(), $options = array())
        {
            $postargs = wp_parse_args($options, array('public' => true));
            $this->postTypes = get_post_types($postargs, 'object');

            parent::__construct($manager, $id, $args);
        }

        /**
         * Render the content on the theme customizer page
         */
        public function render_content()
        {
            if (!empty($this->postTypes)) {
                ?>
                <label>
                    <span class="customize-post-type-dropdown"><?php echo esc_html($this->label); ?></span>
                    <select name="<?php echo $this->id; ?>" id="<?php echo $this->id; ?>">
                        <?php foreach ($this->postTypes as $k => $post_type) {
                            printf('<option value="%s" %s>%s</option>', $k, selected($this->value(), $k, false), $post_type->labels->name);
                        } ?>
                    </select>
                </label>
                <?php
            }
        }
    }

}