<?php

namespace tecai\Http\Controllers\Organization;

use Illuminate\Http\Request;

use tecai\Http\Requests;
use tecai\Http\Controllers\Controller;
use tecai\Repositories\Interfaces\Organization\CorporationRepository;
use tecai\Transformers\CorporationTransformer;

class CorporationController extends Controller
{
    /**
     * @var CorporationRepository
     */
    protected $repository;

    /**
     * @param CorporationRepository $corporationRepository
     */
    public function __construct(CorporationRepository $corporationRepository) {
        $this->repository = $corporationRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->response()->paginator($this->repository->paginate(),new CorporationTransformer());
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
        return $this->response()->created(generateResourceURI() . '/' .$model->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->response()->item($this->repository->find($id), new CorporationTransformer());
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
