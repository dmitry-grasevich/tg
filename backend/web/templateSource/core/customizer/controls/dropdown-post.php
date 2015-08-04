<?php
/**
 * Class to create a custom post control
 */
if (!class_exists('TG_Post_DropDown_Control')) {

    class TG_Post_DropDown_Control extends TG_Customize_Control
    {
        private $posts = array();

        /**
         * @param WP_Customize_Manager $manager
         * @param string $id
         * @param array $args
         * @param array $options
         */
        public function __construct($manager, $id, $args = array(), $options = array())
        {
            $postargs = wp_parse_args($options, array('numberposts' => '-1'));
            $this->posts = get_posts($postargs);

            parent::__construct($manager, $id, $args);
        }

        /**
         * Render the content on the theme customizer page
         */
        public function render_content()
        {
            if (!empty($this->posts)) {
                ?>
                <label>
                    <span class="customize-post-dropdown"><?php echo esc_html($this->label); ?></span>
                    <select name="<?php echo $this->id; ?>" id="<?php echo $this->id; ?>">
                        <?php foreach ($this->posts as $post) {
                            printf('<option value="%s" %s>%s</option>', $post->ID, selected($this->value(), $post->ID, false), $post->post_title);
                        } ?>
                    </select>
                </label>
                <?php
            }
        }
    }

}