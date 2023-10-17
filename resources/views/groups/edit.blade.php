@extends('layouts.app')
@section('title','Modification de groupe')
@section('content')
    <section class="content-header">
        <h1>
            Modification de groupe
        </h1>
    </section>
    <div class="content">
        {!! Form::model($group, ['route' => ['groups.update', $group->id], 'method' => 'patch']) !!}

        @include('groups.fields')

        {!! Form::close() !!}
    </div>
@endsection
