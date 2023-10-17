@extends('layouts.app')
@section('title','Détail du '.ucfirst(config('settings.tags_label_singular')))
@section('content')
    <section class="content-header">
        <h1>
            {{ucfirst(config('settings.tags_label_singular'))}}
            <span class="pull-right">
            <a href="{{ route('tags.index') }}" class="btn btn-default">
                <i class="fa fa-chevron-left" aria-hidden="true"></i> Retour
            </a>
            <a href="{{ route('tags.edit',$tag->id) }}" class="btn btn-primary">
                <i class="fa fa-edit" aria-hidden="true"></i> Editer
            </a>
            {!! Form::open(['route' => ['tags.destroy', $tag->id], 'method' => 'delete','style'=>'display:inline']) !!}
                {!! Form::button('<i class="fa fa-trash"></i> Supprimer', [
                'type' => 'submit',
                'title' => 'Supprimer',
                'class' => 'btn btn-danger',
                'onclick' => "return conformDel(this,event)",
                ]) !!}
                {!! Form::close() !!}
        </span>
        </h1>
    </section>
    <div class="content">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tag" data-toggle="tab"
                                      aria-expanded="true">{{ucfirst(config('settings.tags_label_singular'))}}</a>
                </li>
                @can('user manage permission')
                    <li class=""><a href="#tab_permissions" data-toggle="tab"
                                    aria-expanded="false">Permission</a>
                    </li>
                @endcan
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tag">
                    @include('tags.show_fields')
                </div>
                @can('user manage permission')
                    <div class="tab-pane" id="tab_permissions">
                        <div>
                            <table class="table">
                                <thead>
                                <tr>
                                    <th colspan="3" style="font-size: 1.8rem;">Permissions aux {{ucfirst(config('settings.document_label_plural'))}} de cette {{config('settings.tags_label_singular')}}</th>
                                </tr>
                                <tr>
                                    <th>Utilisateur</th>
                                    <th>Permissions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if (count($tagWisePermList)==0)
                                    <tr>
                                        <td colspan="3">Aucun résultat trouvé</td>
                                    </tr>
                                @endif
                                @foreach ($tagWisePermList as $perm)
                                    <tr>
                                        <td>{{$perm['user']->name}}</td>
                                        <td>
                                            @foreach ($perm['permissions'] as $p)
                                                <label class="label label-default">
                                                    <!-- {{$p}} -->
                                                    @if($p == 'create')
                                                        créer
                                                    @endif
                                                    @if($p == 'read')
                                                        consulter
                                                    @endif
                                                    
                                                    @if($p == 'update')
                                                        modifier
                                                    @endif
                                                    @if($p == 'delete')
                                                        supprimer
                                                    @endif
                                                </label>
                                            @endforeach
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <table class="table">
                                <thead>
                                <tr>
                                    <th colspan="3" style="font-size: 1.8rem;">Permission héritée des {{config('settings.document_label_plural')}} globaux</th>
                                </tr>
                                <tr>
                                    <th>Utilisateur</th>
                                    <th>Permissions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if (count($globalPermissionUsers)==0)
                                    <tr>
                                        <td colspan="2">Aucun résultat trouvé</td>
                                    </tr>
                                @endif
                                @foreach ($globalPermissionUsers as $user)
                                    <tr>
                                        <td>{{$user->name}}</td>
                                        <td>
                                            @foreach(config('constants.GLOBAL_PERMISSIONS.DOCUMENTS') as $perm_key=>$value)
                                                @if ($user->can($perm_key))
                                                    <label class="label label-default">{{$value}}</label>
                                                @endif
                                            @endforeach
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endcan
            </div>
        </div>
    </div>
@endsection
