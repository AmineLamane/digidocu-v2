@extends('layouts.app')
@section('title','Nouveau groupe')
@section('content')
    <section class="content-header">
        <h1>
            Création de groupe
        </h1>
    </section>
    <div class="content">

        {!! Form::open(['route' => 'groups.store']) !!}

        @include('groups.fields')
        
        {!! Form::close() !!}
    </div>
@endsection
