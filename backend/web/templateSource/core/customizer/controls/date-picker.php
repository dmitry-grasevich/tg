<?php
/**
 * Class to create a custom date picker
 */
if (!class_exists('TG_Date_Picker_Control')) {

    class TG_Date_Picker_Control extends TG_Customize_Control
    {
        /**
         * Enqueue the styles and scripts
         */
        public function enqueue()
        {
            wp_enqueue_style('jquery-ui-datepicker');
        }

        /**
         * Render the content on the theme customizer page
         */
        public function render_content()
        {
            ?>
            <label>
                <span class="customize-date-picker-control"><?php echo esc_html($this->label); ?></span>
                <input type="date" id="<?php echo $this->id; ?>" name="<?php echo $this->id; ?>" value="<?php echo $this->value(); ?>" class="datepicker"/>
            </label>

            <?php if ($this->description != ''): ?>
            <div class="description customize-control-description">
                <?php echo $this->description; ?>
            </div>
            <?php endif;
        }
    }

}
