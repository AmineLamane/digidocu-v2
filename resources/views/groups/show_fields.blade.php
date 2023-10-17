<!-- Name Field -->
<div class="form-group">
    {!! Form::label('name', 'Nom:') !!}
    <p>{{ $group->name }}</p>
</div>

<!-- Username Field -->
<div class="form-group">
    {!! Form::label('users', 'Liste des utilisateurs:') !!}
    <p>
        <ul>
        @foreach($group->users as $user)
        <li>
            {{ $user->name }}
        </li>
        @endforeach
        </ul>
    </p>
</div>

<!-- Description Field -->
<div class="form-group">
    {!! Form::label('description', 'Description:') !!}
    <p>{!! $group->description !!}</p>
</div>

<!-- Created Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Crée le:') !!}
    <p>{{ formatDateTime($user->created_at) }}</p>
</div>

<!-- Created Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Mis à jour le:') !!}
    <p>{{ formatDateTime($user->updated_at) }}</p>
</div>


