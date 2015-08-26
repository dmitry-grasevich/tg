<?php
use common\models\Control;
?>
<script id="section-template" type="text/x-handlebars-template">
    {{#if isWrap}}
    <div class="ui-sortable-handle">
    {{/if}}

        <a href="#" class="section-wrapper {{#if isUnsaved}}unsaved{{/if}}">
            <button class="btn btn-xs btn-purple duplicate-btn">Duplicate</button>
            <img src="/images/controls/section.png"
                 data-toggle="panel-overlay"
                 data-target="#settings-wrapper"
                 data-type="<?= Control::TYPE_SECTION ?>"
                 data-settings="{{settings}}"
                 id="{{uid}}">
            <div class="controls-sortable"></div>
        </a>

    {{#if isWrap}}
        </div>
    {{/if}}
</script>