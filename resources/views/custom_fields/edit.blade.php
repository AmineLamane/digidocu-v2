@extends('layouts.app')
@section('title','Modification de Champ Personnalisé')
@section('content')
    <section class="content-header">
        <h1>
            Champ Personnalisé
        </h1>
   </section>
   <div class="content">
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($customField, ['route' => ['customFields.update', $customField->id], 'method' => 'patch']) !!}

                        @include('custom_fields.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection
