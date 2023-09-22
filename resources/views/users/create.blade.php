@extends('layouts.app')
@section('title','Nouveau utilisateur')
@section('content')
    <section class="content-header">
        <h1>
            Utilisateur
        </h1>
    </section>
    <div class="content">

        {!! Form::open(['route' => 'users.store']) !!}

        @include('users.fields')

        {!! Form::close() !!}
    </div>
@endsection
