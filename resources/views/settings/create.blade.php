@extends('layouts.app')
@section('title','Création de paramètre')
@section('content')
    <section class="content-header">
        <h1>
            Paramètre
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'settings.store']) !!}

                        @include('settings.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
