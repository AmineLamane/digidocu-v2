{!! Form::open(['route' => ['tags.destroy', $id], 'method' => 'delete']) !!}
<div class='btn-group'>
    <a href="{{ route('tags.show', $id) }}" class='btn btn-default btn-xs' title="Voir">
        <i class="glyphicon glyphicon-eye-open"></i>
    </a>
    @can('update tags')
        <a href="{{ route('tags.edit', $id) }}" class='btn btn-default btn-xs' title="Editer">
            <i class="glyphicon glyphicon-edit"></i>
        </a>
    @endcan
    @can('delete tags')
        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', [
            'type' => 'submit',
            'title' => 'Supprimer',
            'class' => 'btn btn-danger btn-xs',
            'onclick' => "return conformDel(this,event)"
        ]) !!}
    @endcan
</div>
{!! Form::close() !!}
