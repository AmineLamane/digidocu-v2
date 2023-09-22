@extends('layouts.app')
@section('title','Liste des utilisateurs')
@section('content')
    <section class="content-header">
        <h1 class="pull-left">Utilisateur</h1>
        <h1 class="pull-right">
            @can('create users')
                <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px"
                   href="{!! route('users.create') !!}">
                    <i class="fa fa-plus"></i>
                    Nouveau utilisateur
                </a>
            @endcan
        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                @include('users.table')
            </div>
        </div>
        <div class="text-center">

        </div>
    </div>
@endsection

