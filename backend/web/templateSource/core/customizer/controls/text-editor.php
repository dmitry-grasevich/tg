<?php
/**
 * Class to create a custom tags control
 */
if (!class_exists('TG_Text_Editor_Control')) {

    class TG_Text_Editor_Control extends TG_Customize_Control
    {
        /**
         * Render the content on the theme customizer page
         */
        public function render_content()
        {
            ?>
            <label>
                <span class="customize-text_editor"><?php echo esc_html($this->label); ?></span>
                <?php
                $settings = array(
                    'textarea_name' => $this->id
                );

                wp_editor($this->value(), $this->id, $settings);
                ?>
            </label>
            <?php
        }
    }

}