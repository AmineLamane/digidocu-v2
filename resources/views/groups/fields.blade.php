<script id="permission-row" type="text/x-handlebars-template">
        <tr>
            <td>
                {!! Form::select('tag_permissions[@{{index}}][tag_id]', $tags , null , ['class' => 'form-control input-sm']) !!}
            </td>
            @foreach (config('constants.TAG_LEVEL_PERMISSIONS')  as $perm)
                <td><label>
                        <input name="tag_permissions[@{{index}}][{{$perm}}]" type="checkbox" class="iCheck-helper"
                               value="1">
                    </label></td>
            @endforeach
            <td>
                <button onclick="removeRow(this)" class="btn btn-danger btn-xs" title="Supprimer"><i
                        class="fa fa-trash"></i></button>
            </td>
        </tr>
    </script>
    <script>
        @php
        if(isset($group)){
            $groupTagPerm = groupTagsPermissions($group->permissions()->get());
        }else{
            $groupTagPerm = [];
        }
            
        @endphp
        let rowIndex = 0;

        function addRow() {
            var template = Handlebars.compile($("#permission-row").html());
            var html = template({index: rowIndex});
            $(html).appendTo("#permission-body");
            registerIcheck();
            rowIndex++;
        }
        function removeRow(elem) {
            $(elem).parents("tr").remove();
        }
        window.onload = function () {
            @foreach($groupTagPerm as $key=>$value)
                addRow();
                $("#permission-body>tr:last-child").find("select[name^='tag_permissions']").val('{{$value['tag_id']}}');
                @foreach($value['permissions'] as $perm)
                $("#permission-body>tr:last-child").find("input[name$='[{{$perm}}]']").prop('checked',true);
                @endforeach
            @endforeach
            registerIcheck();
        }
    </script>
<div class="box box-primary">
    <div class="box-header no-border">
        <h3 class="box-title">Détail du groupe</h3>

        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="form-group col-sm-6 {{ $errors->has('name') ? 'has-error' :'' }}">
                {!! Form::label('name', 'Nom du groupe*:') !!}
                {!! Form::text('name', null, ['class' => 'form-control']) !!}
                {!! $errors->first('name','<span class="help-block">:message</span>') !!}
            </div>
        
        {{--if in edit mode--}}
        @if (isset($group))
            <div class="form-group col-sm-6 ">
                <label for="users">Utilisateurs*:</label>
                <select class="form-control select2" id="users"
                        name="users[]"
                        multiple
                        >
                        @foreach($users as $id => $name)
                            <option
                            value="{{$id}}" {{(in_array($id,old('users', optional(optional(optional($group)->users)->pluck('id'))->toArray() ?? [] )))?"selected":"" }}>{{$name}}</option>
                        @endforeach
                </select>
            </div>
        @else
            <div class="form-group col-sm-6 {{ $errors->has("users") ? 'has-error' :'' }}">
                <label for="users">Utilisateurs*:</label>
                <select class="form-control select2" id="users" name="users[]" multiple>
                    @foreach($users as $id => $name)
                        <option
                        value="{{$id}}">{{$name}}</option>
                    @endforeach
                </select>
                {!! $errors->first("users",'<span class="help-block">:message</span>') !!}
            </div>
        @endif
        {!! Form::bsTextarea('description',null,['class'=>'form-control b-wysihtml5-editor']) !!}
        </div>
    </div>
</div>
<div class="box box-primary">
    <div class="box-header no-border">
        <h3 class="box-title">Permissions Globals</h3>

        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-sm-4">
                        <label class="control-label">Utilisateur</label><br>
                        @foreach(config('constants.GLOBAL_PERMISSIONS.USERS') as $permission_name=>$permission_label)
                            <div class="form-group">
                                <label>
                                    <input name="global_permissions[]" type="checkbox" class="iCheck-helper"
                                            value="{{$permission_name}}" {{optional($group ?? null)->hasPermissionTo($permission_name)?'checked':''}}>
                                    &nbsp;{{ucfirst($permission_label)}} Utilisateurs
                                </label>
                            </div>
                        @endforeach
                    </div>
                    <div class="col-sm-4">
                        <label class="control-label">{{ucfirst(config('settings.tags_label_plural'))}}</label><br>
                        @foreach(config('constants.GLOBAL_PERMISSIONS.TAGS') as $permission_name=>$permission_label)
                            <div class="form-group">
                                <label>
                                    <input name="global_permissions[]" type="checkbox" class="iCheck-helper"
                                            value="{{$permission_name}}" {{optional($group ?? null)->hasPermissionTo($permission_name)?'checked':''}}>
                                    &nbsp;{{ucfirst($permission_label)}} {{ucfirst(config('settings.tags_label_plural'))}}
                                </label>
                            </div>
                        @endforeach
                    </div>
                    <div class="col-sm-4">
                        <label
                            class="control-label">{{ucfirst(config('settings.document_label_plural'))}}</label><br>
                        @foreach(config('constants.GLOBAL_PERMISSIONS.DOCUMENTS') as $permission_name=>$permission_label)
                            <div class="form-group">
                                <label>
                                    <input name="global_permissions[]" type="checkbox" class="iCheck-helper"
                                            value="{{$permission_name}}" {{optional($group ?? null)->hasPermissionTo($permission_name)?'checked':''}}>
                                    &nbsp;{{ucfirst($permission_label)}} {{ucfirst(config('settings.document_label_plural'))}}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="box box-primary">
    <div class="box-header no-border">
        <h3 class="box-title">Permissions relatives aux {{ucfirst(config('settings.tags_label_plural'))}}</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Sélectionner {{ucfirst(config('settings.tags_label_singular'))}}</th>
                        <th>Consulter</th>
                        <th>Créer</th>
                        <th>Modifier</th>
                        <th>Supprimer</th>
                        <!-- @foreach (config('constants.TAG_LEVEL_PERMISSIONS')  as $perm) -->
                            <!-- <th>{{ucfirst($perm)}}</th> -->
                        <!-- @endforeach -->
                    </tr>
                    </thead>
                    <tbody id="permission-body">

                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="6">
                            <button type="button" onclick="addRow()" class="btn btn-info btn-xs">Ajouter une nouvelle {{config('settings.tags_label_singular')}}</button>
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="form-group">
    {!! Form::submit('Enregistrer', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('groups.index') !!}" class="btn btn-default">Annuler</a>
</div>
