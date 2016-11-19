<?php
namespace tecai\Http\Controllers\User;

use tecai\Http\Controllers\Controller;
use Illuminate\Http\Request;
use tecai\Repositories\Interfaces\User\SchoolRepository;
use tecai\Transformers\CommonTransformer;

/**
 * Class SchoolController
 * @package tecai\Http\Controllers\User
 */
class SchoolController extends Controller {
    /**
     * @var SchoolRepository
     */
    protected $repository;

    /**
     * @param SchoolRepository $repository
     */
    public function __construct(SchoolRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return \Dingo\Api\Http\Response
     */
    public function index() {
        //添加meta元数据的是laravel的paginate
        return $this->response()->paginator($this->repository->paginate(), new CommonTransformer());
    }


    public function show($id) {
        return $this->response()->item($this->repository->find($id), new CommonTransformer());
    }

    public function store(Request $request)
    {
        $model = $this->repository->create($request->all());
        return $this->response()->created(generateResourceURI() . '/' . $model->id);
    }

    public function update(Request $request, $id)
    {
        $this->repository->update($request->all(), $id);
        return $this->response()->noContent();
    }

    /**
     * @param int $id
     * @return \Dingo\Api\Http\Response
     */
    public function destroy($id) {
        $this->repository->delete($id);
        return $this->response()->noContent();
    }


















}