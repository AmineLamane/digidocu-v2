@extends('layouts.app')
@section('title','Liste de type de '.ucfirst(config('settings.file_label_plural')))
@section('content')
    <section class="content-header">
        <h1 class="pull-left">Types de {{ucfirst(config('settings.file_label_plural'))}} </h1>
        <h1 class="pull-right">
           <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('fileTypes.create') !!}">
               <i class="fa fa-plus"></i>
               Ajouter Nouveau
           </a>
        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                    @include('file_types.table')
            </div>
        </div>
        <div class="text-center">

        </div>
    </div>
@endsection

