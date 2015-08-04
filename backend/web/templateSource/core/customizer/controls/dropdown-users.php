<?php
/**
 * Customize for user select, extend the WP customizer
 */

if (!class_exists('TG_Users_DropDown_Control')) {

    class TG_Users_DropDown_Control extends TG_Customize_Control
    {
        private $users = array();

        /**
         * @param WP_Customize_Manager $manager
         * @param string $id
         * @param array $args
         * @param array $options
         */
        public function __construct($manager, $id, $args = array(), $options = array())
        {
            $this->users = get_users($options);

            parent::__construct($manager, $id, $args);
        }

        /**
         * Render the control's content.
         *
         * Allows the content to be overriden without having to rewrite the wrapper.
         */
        public function render_content()
        {
            if (empty($this->users)) {
                ?>
                <label>
                    <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
                    <select <?php $this->link(); ?>>
                        <?php foreach ($this->users as $user) {
                            printf('<option value="%s" %s>%s</option>',
                                $user->data->ID,
                                selected($this->value(), $user->data->ID, false),
                                $user->data->display_name);
                        } ?>
                    </select>
                </label>
                <?php
            }
        }
    }

}