@extends('layouts.app')
@section('title','Détail d\'utilisateur')
@section('content')
    <section class="content-header" style="margin-bottom: 25px;">
        <h1 class="pull-left">
            Utilisateurs
        </h1>
        <span class="pull-right">
            <a href="{{ route('users.index') }}" class="btn btn-default">
                <i class="fa fa-chevron-left" aria-hidden="true"></i> Retour
            </a>
            <a href="{{ route('users.edit',$user->id) }}" class="btn btn-primary">
                <i class="fa fa-edit" aria-hidden="true"></i> Editer
            </a>
            <a href="{{ route('users.blockUnblock', $user->id) }}" class="btn btn-warning">
                <i class="fa fa-ban"></i> Bloquer / Débloquer
            </a>
            {!! Form::open(['route' => ['users.destroy', $user->id], 'method' => 'delete','style'=>'display:inline']) !!}
            {!! Form::button('<i class="fa fa-trash"></i> Supprimer', [
            'type' => 'submit',
            'title' => 'Delete',
            'class' => 'btn btn-danger',
            'onclick' => "return conformDel(this,event)",
            ]) !!}
            {!! Form::close() !!}
        </span>
    </section>
    <div class="content">
        <div class="row">
            <div class="col-sm-12">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#user" data-toggle="tab"
                                              aria-expanded="true">Utilisateur</a>
                        </li>
                        @can('user manage permission')
                            <li class=""><a href="#tab_permissions" data-toggle="tab"
                                            aria-expanded="false">Permission</a>
                            </li>
                        @endcan
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="user">
                            @include('users.show_fields')
                        </div>
                        @can('user manage permission')
                            <div class="tab-pane" id="tab_permissions">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th colspan="3"
                                        style="font-size: 1.8rem;">Permissions Global
                                    </th>
                                </tr>
                                <tr>
                                    <th>Module</th>
                                    <th>Permissions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if ($user->hasAnyPermission(array_keys(config('constants.GLOBAL_PERMISSIONS.USERS'))) || $user->hasAnyPermission(array_keys(config('constants.GLOBAL_PERMISSIONS.TAGS'))) || $user->hasAnyPermission(array_keys(config('constants.GLOBAL_PERMISSIONS.DOCUMENTS'))))
                                    @foreach ($globalPermissions as $key=>$p)
                                        <tr>
                                            <td>
                                                {{$key}}
                                            </td>
                                            <td>
                                                @foreach ($p['permissions']??[] as $perm)
                                                    <label class="label label-default">{{$perm}}</label>
                                                @endforeach
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="2">Aucun résultat trouvé</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                            <table class="table">
                                <thead>
                                <tr>
                                    <th colspan="3"
                                        style="font-size: 1.8rem;">
                                        Permissions aux {{ucfirst(config('settings.document_label_plural'))}} relatives aux {{config('settings.tags_label_plural')}}
                                    </th>
                                </tr>
                                <tr>
                                    <th>{{ucfirst(config('settings.tags_label_singular'))}}</th>
                                    <th>Permissions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if (count($tags)==0)
                                    <tr>
                                        <td colspan="2">Aucun résultat trouvé</td>
                                    </tr>
                                @endif
                                @foreach($tags as $tag)
                                    <tr>
                                        <td>
                                            {{$tag->name}}
                                        </td>
                                        <td>
                                            @foreach(config('constants.TAG_LEVEL_PERMISSIONS') as $perm_key=>$perm)
                                                @if ($user->can($perm_key.$tag->id))
                                                    <label class="label label-default">
                                                        <!-- {{$perm}} -->
                                                        @if($perm == 'create')
                                                            Créer
                                                        @endif
                                                        @if($perm == 'read')
                                                            Consulter
                                                        @endif
                                                        
                                                        @if($perm == 'update')
                                                            Modifier
                                                        @endif
                                                        @if($perm == 'delete')
                                                            Supprimer
                                                        @endif
                                                    </label>
                                                @endif
                                            @endforeach
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <table class="table">
                                <thead>
                                <tr>
                                    <th colspan="3"
                                        style="font-size: 1.8rem;">Permissions relatives aux {{ucfirst(config('settings.document_label_plural'))}} spécifiques
                                    </th>
                                </tr>
                                <tr>
                                    <th>{{ucfirst(config('settings.document_label_singular'))}}</th>
                                    <th>Permissions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if (count($documents)==0)
                                    <tr>
                                        <td colspan="2">Aucun résultat trouvé</td>
                                    </tr>
                                @endif
                                @foreach($documents as $document)
                                    <tr>
                                        <td>
                                            {{$document->name}}
                                        </td>
                                        <td>
                                            @foreach(config('constants.DOCUMENT_LEVEL_PERMISSIONS') as $perm_key=>$perm)
                                                @if ($user->can($perm_key.$document->id))
                                                    <label class="label label-default">{{$perm}}</label>
                                                @endif
                                            @endforeach
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
