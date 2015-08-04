<?php
/**
 * Class to create a custom menu control
 */
if (!class_exists('TG_Menu_DropDown_Control')) {

    class TG_Menu_DropDown_Control extends TG_Customize_Control
    {
        private $menus = array();

        /**
         * @param WP_Customize_Manager $manager
         * @param string $id
         * @param array $args
         * @param array $options
         */
        public function __construct($manager, $id, $args = array(), $options = array())
        {
            $this->menus = wp_get_nav_menus($options);

            parent::__construct($manager, $id, $args);
        }

        /**
         * Render the content on the theme customizer page
         */
        public function render_content()
        {
            if (!empty($this->menus)) {
                ?>
                <label>
                    <span class="customize-menu-dropdown"><?php echo esc_html($this->label); ?></span>
                    <select name="<?php echo $this->id; ?>" id="<?php echo $this->id; ?>">
                        <?php foreach ($this->menus as $menu) {
                            printf('<option value="%s" %s>%s</option>', $menu->term_id, selected($this->value(), $menu->term_id, false), $menu->name);
                        } ?>
                    </select>
                </label>
                <?php
            }
        }
    }

}