<?php

namespace tecai\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputArgument;

class MakeModelObserver extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'make:modelObserver';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new model observer.';

    /**
     * @var string
     */
    protected $type = 'Model Observer';

    protected function replaceClass($stub, $name)
    {
        $stub = parent::replaceClass($stub, $name);

        $name = str_replace('Observer', '', $name);//去掉Observer

        $name = substr($name,strrpos($name, '\\')+1);

        return strtr($stub, [
            'ModelClass' => $name,
            'Model'      => '$' . strtolower($name)
        ]);
    }

    /**
     * 定义指定模板文件
     * @return string
     */
    protected function getStub()
    {
        return app_path() . '/Stubs/model/observer.stub';
    }

    /**
     * 获取该类文件的默认命名空间（其实是设定）
     *
     * @param  string $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Observers';
    }

    /**
     * 获取CLI命令行的参数（xxx）
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the model observer.'],
        ];
    }

    /**
     * 获取CLI命令行的选项参数（--xxx）
     * @return array
     */
    protected function getOptions()
    {
        return [];
    }

}
