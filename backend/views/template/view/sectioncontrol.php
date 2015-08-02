<?php
use common\models\Control;
?>
<script id="control-template" type="text/x-handlebars-template">
    {{#if isWrap}}
        <div class="ui-sortable-handle">
    {{/if}}

        <a href="#" class="control-wrapper {{#if isSaved}}saved{{else}}unsaved{{/if}}">
            <div class="text-lg control-label">{{label}}</div>
            <img src="{{img}}"
                 data-toggle="panel-overlay"
                 data-target="#settings-wrapper"
                 data-type="<?= Control::TYPE_CONTROL ?>"
                 data-settings="{{settings}}"
                 id="{{uid}}">
        </a>

    {{#if isWrap}}
        </div>
    {{/if}}
</script>