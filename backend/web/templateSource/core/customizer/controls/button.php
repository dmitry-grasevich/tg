<?php

if (class_exists('TG_Button_Control')) {
    return;
}

class TG_Button_Control extends TG_Customize_Control
{
    public $type = 'toggle';

    public function render_content()
    {
        ?>
        <label>
            <span class="customize-control-title">
                <?php echo esc_attr($this->label); ?>
                <?php if (!empty($this->description)) : ?>
                    <?php // The description has already been sanitized in the Fields class, no need to re-sanitize it. ?>
                    <span class="description customize-control-description"><?php echo $this->description; ?></span>
                <?php endif; ?>
            </span>

            <a class="tg-button btn-medium" href="<?php echo esc_attr($this->href) ?>" data-button_text="<?php echo esc_attr($this->text) ?>">
                <?php echo esc_attr($this->text) ?></a>
        </label>
        <?php
    }
}
