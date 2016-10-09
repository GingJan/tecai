<?php
namespace tecai\Http\Controllers\User;

use Illuminate\Pagination\Paginator;
use tecai\Http\Controllers\Controller;
use Illuminate\Http\Request;
use tecai\Models\User\Job;
use tecai\Repositories\Interfaces\User\JobRepository;
use tecai\Transformers\JobTransformer;

/**
 * Class JobController
 * @package tecai\Http\Controllers\User
 */
class JobController extends Controller {
    /**
     * @var JobRepository
     */
    private $repository;

    /**
     * @param JobRepository $jobRepository
     */
    public function __construct(JobRepository $jobRepository)
    {
        $this->repository = $jobRepository;
    }

    /**
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     * TODO HATEOAS
     */
    public function index(Request $request) {
        //添加meta元数据的是laravel的paginate
        return $this->response()->paginator($this->repository->paginate(), new JobTransformer());
    }


    public function show($id) {
        return $this->response()->item($this->repository->find($id), new JobTransformer());
    }

    /**
     * @param Request $request
     */
    public function store(Request $request)
    {
        $model = $this->repository->create($request->all());
        return $this->response()->created(generateResourceURI() . '/' . $model->id);
    }

    /**
     * @param Request $request
     */
    public function update(Request $request, $id)
    {
        $this->repository->update($request->all(), $id);
        return $this->response()->noContent();
    }

    /**
     * @param int $id 岗位编号
     * @return \Dingo\Api\Http\Response
     */
    public function destroy($id) {
        $this->repository->delete($id);
        return $this->response()->noContent();
    }


















}