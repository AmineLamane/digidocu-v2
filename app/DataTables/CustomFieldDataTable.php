<?php

namespace App\DataTables;

use App\CustomField;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class CustomFieldDataTable extends DataTable
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

        return $dataTable->addColumn('action', 'custom_fields.datatables_actions')
            ->editColumn('model_type',function (CustomField $customField){
                return config('settings_array.model_types_plural')[$customField->model_type];
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\CustomField $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(CustomField $model)
    {
        return $model->newQuery();
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
            ->minifiedAjax()
            ->addAction(['width' => '120px', 'printable' => false, 'title' => 'Actions'])
            ->parameters([
                'dom'       => 'Bfrtip',
                'stateSave' => true,
                'order'     => [[0, 'desc']],
                'buttons'   => [
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
            'model_type' => ['title' => 'Type de modèle'],
            'name' => ['title' => 'Nom'],
            'validation' => ['title' => 'Validation'],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'custom_fieldsdatatable_' . time();
    }
}
