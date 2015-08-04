<?php
/**
 * Class to create a custom layout control
 */
if (!class_exists('TG_Layout_Picker_Control')) {

    class TG_Layout_Picker_Control extends TG_Customize_Control
    {
        /**
         * Render the content on the theme customizer page
         */
        public function render_content()
        {
            $imageDirectory = TG_CUSTOMIZER_URI . '/controls/img/';
            ?>
            <label>
                <span class="customize-layout-control"><?php echo esc_html($this->label); ?></span>
                <ul>
                    <li>
                        <img src="<?php echo $imageDirectory; ?>1col.png" alt="Full Width"/>
                        <input type="radio" name="<?php echo $this->id; ?>" id="<?php echo $this->id; ?>[full_width]" value="1"/>
                    </li>
                    <li>
                        <img src="<?php echo $imageDirectory; ?>2cl.png" alt="Left Sidebar"/>
                        <input type="radio" name="<?php echo $this->id; ?>" id="<?php echo $this->id; ?>[left_sidebar]" value="1"/>
                    </li>
                    <li>
                        <img src="<?php echo $imageDirectory; ?>2cr.png" alt="Right Sidebar"/>
                        <input type="radio" name="<?php echo $this->id; ?>" id="<?php echo $this->id; ?>[right_sidebar]" value="1"/>
                    </li>
                </ul>
            </label>
            <?php
        }
    }

}