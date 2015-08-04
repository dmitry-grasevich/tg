<?php
/**
 * A class to create a dropdown for all categories in your wordpress site
 */
if (!class_exists('TG_Category_DropDown_Control')) {

    class TG_Category_DropDown_Control extends TG_Customize_Control
    {
        private $cats = array();

        /**
         * @param WP_Customize_Manager $manager
         * @param string $id
         * @param array $args
         * @param array $options
         */
        public function __construct($manager, $id, $args = array(), $options = array())
        {
            $this->cats = get_categories($options);

            parent::__construct($manager, $id, $args);
        }

        /**
         * Render the content of the category dropdown
         *
         * @return string
         */
        public function render_content()
        {
            if (!empty($this->cats)) {
                ?>
                <label>
                    <span class="customize-category-select-control"><?php echo esc_html($this->label); ?></span>
                    <select <?php $this->link(); ?>>
                        <?php foreach ($this->cats as $cat) {
                            printf('<option value="%s" %s>%s</option>', $cat->term_id, selected($this->value(), $cat->term_id, false), $cat->name);
                        } ?>
                    </select>
                </label>
                <?php
            }
        }
    }

}