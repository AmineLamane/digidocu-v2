<!-- Name Field -->
<div class="form-group">
    {!! Form::label('name', 'Nom Complet:') !!}
    <p>{{ $user->name }}</p>
</div>


<!-- Email Field -->
<div class="form-group">
    {!! Form::label('email', 'Email:') !!}
    <p>{{ $user->email }}</p>
</div>


<!-- Username Field -->
<div class="form-group">
    {!! Form::label('username', 'Nom d\'utilisateur:') !!}
    <p>{{ $user->username }}</p>
</div>


<!-- Address Field -->
<div class="form-group">
    {!! Form::label('address', 'Téléphone:') !!}
    <p>{{ $user->address }}</p>
</div>


<!-- Description Field -->
<div class="form-group">
    {!! Form::label('description', 'Description:') !!}
    <p>{!! $user->description !!}</p>
</div>


<!-- Status Field -->
<div class="form-group">
    {!! Form::label('status', 'Statut:') !!}
    <p>@php
            if($user->status==config('constants.STATUS.ACTIVE'))
                echo '<span class="label label-success">'.$user->status.'</span>';
            else
                echo '<span class="label label-danger">'.$user->status.'</span>';
        @endphp</p>
</div>

<!-- Created Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Crée à:') !!}
    <p>{{ formatDateTime($user->created_at) }}</p>
</div>

<!-- Created Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Mis à jour à:') !!}
    <p>{{ formatDateTime($user->updated_at) }}</p>
</div>


