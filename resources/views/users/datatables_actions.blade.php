{!! Form::open(['route' => ['users.destroy', $id], 'method' => 'delete']) !!}
<div class='btn-group'>
    <a href="{{ route('users.show', $id) }}" class='btn btn-default btn-xs' data-toggle="tooltip" title="Voir">
        <i class="glyphicon glyphicon-eye-open"></i>
    </a>
    @can('update users')
        <a href="{{ route('users.edit', $id) }}" class='btn btn-default btn-xs' title="Editer">
            <i class="glyphicon glyphicon-edit"></i>
        </a>
        <a href="{{ route('users.blockUnblock', $id) }}" class='btn btn-default btn-xs' title="Bloquer/Débloquer">
            <i class="fa fa-ban"></i>
        </a>
    @endcan
    @can('delete users')
        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', [
            'type' => 'submit',
            'title' => 'Supprimer',
            'class' => 'btn btn-danger btn-xs',
            'onclick' => "return conformDel(this,event)"
        ]) !!}
    @endcan
</div>
{!! Form::close() !!}
