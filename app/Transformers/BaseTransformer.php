<?php
/**
 * Created by PhpStorm.
 * User: zjien
 * Date: 4/6/16
 * Time: 11:25 AM
 */
namespace tecai\Transformers;

use Illuminate\Database\Eloquent\Model;
use League\Fractal\TransformerAbstract;

abstract class BaseTransformer extends TransformerAbstract
{
    public function transform(Model $model)
    {
        //把数字全部转换为int型
        $temp = $model->toArray();
        foreach($temp as $k => $v) {
            is_numeric($v)? $model->$k = intval($v) : false;
        }

        $transformData = $this->transformData($model);

        $data = array_filter($transformData, function($value) {//array_filter，对数组中每个元素进行映射
            if(is_null($value)) {
                return false;//如果返回false，映射后的结果数组中不会含有该元素
            }
            return true;
        });

        foreach(array_keys($model->toArray()) as $key) {//对model的每个键遍历
            if(!isset($data[$key]) || is_null($data[$key])) {
                $data[$key] = '';
            }
        }

        return $data;
    }

    abstract protected function transformData($model);//由各子类实现

}