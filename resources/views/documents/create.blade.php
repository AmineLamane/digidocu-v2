@extends('layouts.app')
@section('title',"Création de ".ucfirst(config('settings.document_label_singular')))
@section('content')
    <section class="content-header">
        <h4>
            /<a href="{{ route('documents.index') }}">racine</a>
            @foreach($breadcrumb as $item)
            /<a href="{{ route('documents.index', ['tags' => key($item)]) }}">{{ current($item) }}</a>
            @endforeach
            /<a href="{{ route('documents.index', ['tags' => $gettag->id]) }}">{{$gettag->name}}</a>
            /Création
        </h4>
    </section>
    <div class="content">
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'documents.store']) !!}
                        @include('documents.fields',['document'=>null])
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
