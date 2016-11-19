<?php
namespace tecai\Providers;

use Illuminate\Support\ServiceProvider;
use tecai\Models\System\Account;
use tecai\Transformers\AccountTransformer;

class TransformerServiceProvider extends ServiceProvider {
    public function boot()
    {
//        app('Dingo\Api\Transformer\Factory')->register(Job::paginate(10), 'JobTransformer');
        app('Dingo\Api\Transformer\Factory')->register(Account::class, new AccountTransformer());
    }

    public function register()
    {
    }
}