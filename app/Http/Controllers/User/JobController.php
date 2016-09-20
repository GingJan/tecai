<?php
namespace tecai\Http\Controllers\User;

use tecai\Http\Controllers\Controller;
use tecai\Http\Requests\Request;
use tecai\Repositories\Interfaces\User\JobRepository;

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
     */
    public function store(Request $request)
    {
        $this->repository->create($request->all());
    }

    /**
     * @param Request $request
     */
    public function update(Request $request, $id)
    {
        return $this->repository->update($request->all(), $id);
    }
}