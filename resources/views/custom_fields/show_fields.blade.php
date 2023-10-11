<!-- Model Type Field -->
<div class="form-group">
    {!! Form::label('model_type', 'Type de Model:') !!}
    <p>{{ config('settings_array.model_types_plural')[$customField->model_type] }}</p>
</div>


<!-- Name Field -->
<div class="form-group">
    {!! Form::label('name', 'Nom:') !!}
    <p>{{ $customField->name }}</p>
</div>


<!-- Validation Field -->
<div class="form-group">
    {!! Form::label('validation', 'Validation:') !!}
    <p>{{ $customField->validation }}</p>
</div>

{{--suggestions--}}
<div class="form-group">
    {!! Form::label('suggestions', 'Liste de suggestions:') !!}
    <p>
        @php
            $suggestions = isset($customField)&&!empty($customField->suggestions) ? $customField->suggestions :[];
        @endphp
        <ul>
        @foreach ($suggestions as $suggestion)
            <li>{{$suggestion}}</li>
        @endforeach
        </ul>
    </p>
</div>


<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Créé à:') !!}
    <p>{{ formatDateTime($customField->created_at) }}</p>
</div>


<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Mis à jour à:') !!}
    <p>{{ formatDateTime($customField->updated_at) }}</p>
</div>


