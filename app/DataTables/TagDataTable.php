<?php

namespace App\DataTables;

use App\Tag;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;

class TagDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);
        $dataTable = $dataTable->addColumn('action', 'tags.datatables_actions')
            ->addColumn('created_by', function (Tag $tag) {
                return $tag->createdBy->name;
            })->editColumn('color', function (Tag $tag) {
                return '<span class="label" style="background-color: ' . $tag->color . '">' . $tag->color . '</span>';
            })->rawColumns(['color'], true)
            ->filterColumn('created_by', function ($query, $keyword) {
                return $query->whereRaw("select count(*) from users where lower(users.name) like ? and users.id=tags.created_by",["%$keyword%"]);
            });

        return $dataTable;
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Tag $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Tag $model)
    {
        $query = $model->newQuery()->with(['createdBy']);
        return $query;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->addColumn(['data' => 'created_by', 'title' => 'Crée par'])
            ->minifiedAjax()
            ->addAction(['width' => '120px', 'printable' => false , 'title' => 'Actions'])
            ->parameters([
                'dom' => 'Bfrtip',
                'stateSave' => true,
                'order' => [[0, 'desc']],
                'buttons' => [
                    ['extend' => 'export', 'className' => 'btn btn-default btn-sm no-corner', 'text' => '<i class="fa fa-download"></i> Exporter <span class="caret"/>'],
                    ['extend' => 'print', 'className' => 'btn btn-default btn-sm no-corner', 'text' => '<i class="fa fa-print"></i> Imprimer'],
                    ['extend' => 'reset', 'className' => 'btn btn-default btn-sm no-corner', 'text' => '<i class="fa fa-undo"></i> Réinitialiser'],
                    ['extend' => 'reload', 'className' => 'btn btn-default btn-sm no-corner', 'text' => '<i class="fa fa-refresh"></i> Recharger']
                ],
                'language' => [
                    'sEmptyTable' =>     'Aucune donnée disponible dans le tableau',
                    'sInfo' =>           'Affichage de _START_ à _END_ sur _TOTAL_ éléments',
                    'sInfoEmpty' =>      'Affichage de 0 à 0 sur 0 élément',
                    'sInfoFiltered' =>   '(filtré à partir de _MAX_ éléments au total)',
                    'sInfoPostFix' =>    '',
                    'sInfoThousands' =>  ',',
                    'sLengthMenu' =>     'Afficher _MENU_ éléments',
                    'sLoadingRecords' => 'Chargement...',
                    'sProcessing' =>     'Traitement...',
                    'sSearch' =>         'Rechercher :',
                    'sZeroRecords' =>    'Aucun élément correspondant trouvé',
                    'oPaginate' => [
                        'sFirst' =>    'Premier',
                        'sPrevious' => 'Précédent',
                        'sNext' =>     'Suivant',
                        'sLast' =>     'Dernier'
                    ],
                    'oAria' => [
                        'sSortAscending' =>  ': activer pour trier la colonne par ordre croissant',
                        'sSortDescending' => ': activer pour trier la colonne par ordre décroissant'
                    ]
                ],
            ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'id' => ['title' => 'Id'],
            'name' => ['title' => 'Nom'],
            'color' => ['title' => 'Couleur']
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'tagsdatatable_' . time();
    }
}
