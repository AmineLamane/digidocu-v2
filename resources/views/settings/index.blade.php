@extends('layouts.app')
@section('title','Liste de paramètres')
@section('content')
    <section class="content-header">
        <h1 class="pull-left">Paramètres</h1>
        <h1 class="pull-right">
        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                    @include('settings.table')
            </div>
        </div>
        <div class="text-center">

        </div>
    </div>
@endsection

