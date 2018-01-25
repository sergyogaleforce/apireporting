<?php

use Illuminate\Pagination\Paginator;

if (!function_exists('data_tables_response')) {

    /**
     * Prepare a response for the DataTables front end tables.
     *
     * @param $model
     * @param $request
     * @param bool $searchable
     * @param array $with
     * @return array
     */
    function data_tables_response($model, $request, $searchable = false, $with = [])
    {
        $columns = $request->input('columns');

        $page = ($request->input('start') / $request->input('length') + 1);
        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });

        $model = "App\\Entities\\" . $model;

        $records_total = $model::count();

        $query = $model::orderBy($columns[$request->input('order')[0]['column']]['data'], $request->input('order')[0]['dir']);

        if (count($with)) {
            foreach ($with as $relationship) {
                $query = $query->with($relationship);
            }
        }

        if (($request->input('search')['value'] !== '') && ($searchable !== false)) {
            $query = $query->where($searchable, 'LIKE', '%' . $request->input('search')['value'] . '%');
        }

        $data = $query->paginate($request->input('length'));

        $records_filtered = $data->total();

        $return = [];

        foreach ($data as $value) {
            $return[] = $value;
        }

        return [
            'draw' => (int)$request->input('draw'),
            'recordsTotal' => $records_total,
            'recordsFiltered' => $records_filtered,
            'data' => $return
        ];
    }
}
