<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title><?php $title ?></title>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.7/angular.min.js" charset="utf-8"></script>
        <script src="<?php echo DanceParty::ASSET_URL . 'event_creator.js' ?>" charset="utf-8"></script>
        <?php wp_head(); ?>
        <style media="screen">
            .border-light {
                border: 1px solid grey;
                border-radius: .2rem;
                padding: 1rem;
            }
        </style>
    </head>
    <body>
        <div class="wrap" ng-app="EventCreator" ng-controller="formBuilder">
            <h1>Create a new event</h1>

            <editable tag="h3" form-value="form.name"></editable>
            <div ng-repeat="f in form.fields">
                <editable tag="label" form-value="f.name"></editable>
                <input type="{{ f.type }}" id="{{ f.short_name }}" name="{{ f.short_name }}">
            </div>

            <div ng-if="showCreateField">
                <br/>
                <div class="border-light">
                    <editable tag="label" form-value="$parent.newFieldName"></editable>
                    <input type="text" id="field_name" name="field_name">
                </div>
                <br/>
                <button type="button" ng-click="createField()">Add</button>
                <button type="button" ng-click="discardField()">Cancel</button>
            </div>
            <br/>
            <button ng-if="!showCreateField" type="button" name="button" ng-click="addField()">New Field</button>
        </div>
        <?php wp_footer(); ?>
    </body>
</html>