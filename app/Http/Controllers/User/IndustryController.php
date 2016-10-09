<?php

namespace tecai\Http\Controllers\User;

use Illuminate\Http\Request;

use tecai\Http\Requests;
use tecai\Http\Controllers\Controller;
use tecai\Repositories\Interfaces\User\IndustryRepository;
use tecai\Transformers\IndustryTransformer;

class IndustryController extends Controller
{
    /**
     * @var IndustryRepository
     */
    private $repository;

    /**
     * @param IndustryRepository $industryRepository
     */
    public function __construct(IndustryRepository $industryRepository)
    {
        $this->repository = $industryRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->response()->paginator($this->repository->paginate(), new IndustryTransformer());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $model = $this->repository->create($request->all());
        return $this->created($model->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->response()->item($this->repository->find($id), new IndustryTransformer());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->repository->update($request->all(), $id);
        return $this->response()->noContent();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->repository->delete($id);
        return $this->response()->noContent();
    }
}
