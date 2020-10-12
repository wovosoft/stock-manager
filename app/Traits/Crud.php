<?php

namespace App\Traits;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

/**
 * Trait Crud
 * @package App\Traits
 */
trait Crud
{
    /**
     * Storing Model Method
     * @param Request $request
     * @return JsonResponse|void
     * @throws \Throwable
     */
    public function store(Request $request): JsonResponse
    {
        try {
            if (!method_exists($this, 'storeSearchBy')) {
                throw new \Exception('storeSearchBy Method is not Exists', Response::HTTP_METHOD_NOT_ALLOWED);
            }
            if (!method_exists($this, 'storeData')) {
                throw new \Exception('storeData Method is not Exists', Response::HTTP_METHOD_NOT_ALLOWED);
            }
            DB::beginTransaction();
            $item = $this->model::updateOrCreate($this->storeSearchBy($request), $this->storeData($request));

            if (!$item) {
                throw new \Exception("Unable to Save the Data", 304);
            }
            DB::commit();
            return response()->json([
                "status" => true,
                "title" => 'SUCCESS!',
                "type" => "success",
                "msg" => ' Successfully Done'
            ]);
        } catch (\Throwable $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    /**
     * Returns Paginated Response of Items. Simple for Datatable
     * @param Request $request [
     *                              string filter Search Query,
     *                              int per_page = 10 Numbers of items Per Page,
     *                              string orderBy = 'id',
     *                              string order ='desc',
     *                              array columns =['*'] fields to be selected.
     *                          ]
     * @return LengthAwarePaginator | Model
     * @throws \Throwable
     */

    public function list(Request $request)
    {
        try {
            if ($request->has('id')) {
                if (isset($this->listWith)) {
                    return $this->model::with($this->listWith)->findOrFail($request->post('id'));
                }
                return $this->model::findOrFail($request->post('id'));
            }
            if (isset($this->listWith)) {
                return $this->model::with($this->listWith)->defaultDatatable($request, $this->date_range_by ?? null);
            }
            return $this->model::defaultDatatable($request, $this->date_range_by ?? null);
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }

    /**
     * @param Request $request [array search_selects=null, int limit=30, string order='id', string orderBy='asc',string query=null]
     * @return Collection | JsonResponse
     * @throws \Throwable
     */
    public function search(Request $request)
    {
        try {
            if ($request->post('search_selects') && is_array($request->post('search_selects')) && count($request->post('search_selects'))) {
                $selects = $request->post('search_selects');
            } elseif (isset($this->search_selects)) {
                $selects = $this->search_selects;
            } else {
                $selects = ['*'];
            }

            $items = $this->model::query();
            if (isset($this->searchWith)) {
                $items->with($this->searchWith);
            }
            $items->select($selects)
                ->limit($request->post('limit') ?? 30)
                ->orderBy($request->post('order') ?? 'id', $request->post('orderBy') ?? 'asc');

            $c = 0;
            foreach ($this->search_fields as $search_field) {
                if ($c === 0) {
                    if ($search_field === 'id') {
                        $items->where($search_field, '=', $request->post('query'));
                    } else {
                        $items->where($search_field, 'LIKE', '%' . $request->post('query') . '%');
                    }
                } else {
                    if ($search_field === 'id') {
                        $items->orWhere($search_field, '=', '%' . $request->post('query') . '%');
                    } else {
                        $items->orWhere($search_field, 'LIKE', '%' . $request->post('query') . '%');
                    }
                }
                $c++;
            }
            return $items->get();
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }

    /**
     * @param Request $request [int id]
     * @return JsonResponse
     * @throws \Exception
     */
    public function delete(Request $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $item = $this->model::find($request->post('id'));
            if (!$item) {
                throw new ModelNotFoundException('Item Not Found', 404);
            }
            if (!$item->delete()) {
                throw new \Exception('Unable to Delete', 405);
            }
            DB::commit();
            return response()->json([
                "status" => true,
                "title" => "Success",
                "type" => "success",
                "message" => "Successfully Delete"
            ]);
        } catch (\Throwable $exception) {
            DB::rollBack();
            throw $exception;
        }
    }
}
