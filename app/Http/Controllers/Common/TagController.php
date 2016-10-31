<?php

namespace tecai\Http\Controllers\Common;

use Illuminate\Http\Request;

use tecai\Http\Requests;
use tecai\Http\Controllers\Controller;
use tecai\Repositories\Interfaces\Common\TagRepository;
use tecai\Transformers\TagTransformer;

class TagController extends Controller
{
    /**
     * @var TagRepository
     */
    private $repository;

    /**
     * @param TagRepository $tagRepository
     */
    public function __construct(TagRepository $tagRepository) {
        $this->repository = $tagRepository;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->response()->paginator($this->repository->paginate(), new TagTransformer());
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
        return $this->response()->item($this->repository->find($id), new TagTransformer());
    }

    /**
     * 标签资源不提供更新接口
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
//    public function update(Request $request, $id) {}

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
