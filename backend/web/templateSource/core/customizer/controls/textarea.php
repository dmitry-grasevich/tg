<?php
/**
 * Customize for textarea, extend the WP customizer
 *
 */

if (!class_exists('TG_Textarea_Control')) {

    class TG_Textarea_Control extends TG_Customize_Control
    {
        /**
         * Render the control's content.
         *
         * Allows the content to be overriden without having to rewrite the wrapper.
         */
        public function render_content()
        {
            ?>
            <label>
                <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
                <textarea class="large-text" cols="20" rows="5" <?php $this->link(); ?>>
                    <?php echo esc_textarea($this->value()); ?>
                </textarea>
            </label>
            <?php
        }
    }

}