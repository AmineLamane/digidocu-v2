{!! Form::open(['route' => ['groups.destroy', $id], 'method' => 'delete']) !!}
<div class='btn-group'>
    <a href="{{ route('groups.show', $id) }}" class='btn btn-default btn-xs' data-toggle="tooltip" title="Voir">
        <i class="glyphicon glyphicon-eye-open"></i>
    </a>
        <a href="{{ route('groups.edit', $id) }}" class='btn btn-default btn-xs' title="Editer">
            <i class="glyphicon glyphicon-edit"></i>
        </a>
        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', [
            'type' => 'submit',
            'title' => 'Supprimer',
            'class' => 'btn btn-danger btn-xs',
            'onclick' => "return conformDel(this,event)"
        ]) !!}
</div>
{!! Form::close() !!}
