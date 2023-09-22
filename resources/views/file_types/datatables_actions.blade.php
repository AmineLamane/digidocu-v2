{!! Form::open(['route' => ['fileTypes.destroy', $id], 'method' => 'delete']) !!}
<div class='btn-group'>
    <a href="{{ route('fileTypes.show', $id) }}" class='btn btn-default btn-xs'>
        <i class="glyphicon glyphicon-eye-open" title="Voir"></i>
    </a>
    <a href="{{ route('fileTypes.edit', $id) }}" class='btn btn-default btn-xs'>
        <i class="glyphicon glyphicon-edit" title="Editer"></i>
    </a>
    {!! Form::button('<i class="glyphicon glyphicon-trash" title="Supprimer"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-danger btn-xs',
        'onclick' => "return conformDel(this,event)"
    ]) !!}
</div>
{!! Form::close() !!}
