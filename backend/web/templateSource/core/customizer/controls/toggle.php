<?php

if (!class_exists('TG_Toggle_Control')) {

    class TG_Toggle_Control extends TG_Customize_Control {
        public $type = 'toggle';

        public function render_content() {
            ?>
            <div class="toggle-container">
                <label class="toggle-label" for="<?php echo esc_attr( $this->id ); ?>"><?php echo esc_html( $this->label ); ?></label>
                <div class="onoffswitch">
                    <input type="checkbox" class="onoffswitch-checkbox" id="<?php echo esc_attr( $this->id ); ?>" value="<?php echo esc_attr( $this->value() ); ?>" <?php $this->link(); checked( $this->value() ); ?> >
                    <label class="onoffswitch-label" for="<?php echo esc_attr( $this->id ); ?>">
                        <span class="onoffswitch-inner"></span>
                        <span class="onoffswitch-switch"></span>
                    </label>
                </div>

            </div>
        <?php
        }
    }

}
