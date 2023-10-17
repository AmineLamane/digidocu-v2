@extends('layouts.app')
@section('title',"Modification de ".ucfirst(config('settings.document_label_singular')))
@section('content')
    <section class="content-header">
        <h4>
            /<a href="{{ route('documents.index') }}">racine</a>
            @foreach($breadcrumb as $item)
            /<a href="{{ route('documents.index', ['tags' => key($item)]) }}">{{ current($item) }}</a>
            @endforeach
            /<a href="{{ route('documents.index', ['tags' => $document->tags->pluck('id')->first()]) }}">{{$document->tags->pluck('name')->first()}}</a>
            /<a href="{{ route('documents.show', $document->id) }}">{{$document->name}}</a>
            / Modification
        </h4>
   </section>
   <div class="content">
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($document, ['route' => ['documents.update', $document->id], 'method' => 'patch']) !!}

                        @include('documents.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection
