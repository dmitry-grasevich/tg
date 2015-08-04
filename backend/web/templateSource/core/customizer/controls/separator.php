<?php
/**
 * Custom class for hr - for separate customizer controls
 */
if (!class_exists('TG_Separator_Control')) {

    class TG_Separator_Control extends TG_Customize_Control
    {
        public $type = 'hr';

        public function render_content() {
            ?>

            <hr class="section-separator" />

        <?php
        }
    }

}
