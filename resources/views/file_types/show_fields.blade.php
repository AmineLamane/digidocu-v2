<!-- Name Field -->
<div class="form-group">
    {!! Form::label('name', 'Nom:') !!}
    <p>{{ $fileType->name }}</p>
</div>


<!-- No Of Files Field -->
<div class="form-group">
    {!! Form::label('no_of_files', 'Nombre de fichiers:') !!}
    <p>{{ $fileType->no_of_files }}</p>
</div>


<!-- Labels Field -->
<div class="form-group">
    {!! Form::label('labels', 'Labels:') !!}
    <p>{{ $fileType->labels }}</p>
</div>


<!-- File Validations Field -->
<div class="form-group">
    {!! Form::label('file_validations', 'Validations de fichiers:') !!}
    <p>{{ $fileType->file_validations }}</p>
</div>


<!-- File Maxsize Field -->
<div class="form-group">
    {!! Form::label('file_maxsize', 'Maxsize du fichier:') !!}
    <p>{{ $fileType->file_maxsize }} MB</p>
</div>


<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Créé à:') !!}
    <p>{{ formatDateTime($fileType->created_at) }}</p>
</div>


<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Mis à jour à:') !!}
    <p>{{ formatDateTime($fileType->updated_at) }}</p>
</div>


