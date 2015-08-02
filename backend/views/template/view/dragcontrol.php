<script id="draggable-template" type="text/x-handlebars-template">
    <div class="draggable-el" style="width: {{width}}px">
        {{#if isControl}}
        <div class="text-lg" style="padding: 3px;">{{name}}</div>
        {{/if}}

        <img src="{{img}}" width="{{width}}px"
             data-id="{{controlId}}"
             data-name="{{controlName}}"
             data-type="{{type}}">
    </div>
</script>