@extends('layouts.app')
@section('title','Modification d\'utilisateur')
@section('content')
    <section class="content-header">
        <h1>
            Utilisateur
        </h1>
    </section>
    <div class="content">
        {!! Form::model($user, ['route' => ['users.update', $user->id], 'method' => 'patch']) !!}

        @include('users.fields')

        {!! Form::close() !!}
    </div>
@endsection
