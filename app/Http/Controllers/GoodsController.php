<?php

namespace App\Http\Controllers;

use App\Flight;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GoodsController extends Controller
{
    public function add(Request $request)
    {
        //数据验证
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|min:2|max:20',
            'price' => 'required|numeric|between:0,10000',
            'describe' => 'required|string|min:0|max:30000'
        ], [
            'required' => ':attribute不能为空',
            'in' => ':attribute类型错误',
            'max' => ':attribute长度不符合要求',
            'min' => ':attribute超过长度限制',
            'numeric' => ':attribute必须是数字',
            'between' => ':attribute价格范围在0-100000之间',
        ],[
            'name' => '商品名称',
            'price' => '商品价格',
            'describe' => '商品描述',
        ]);
        if($validator->fails()){
            return response()->json(['status'=>-1,'data'=>$validator->errors()->first()]);
        }
        //接收参数
        $name = $request->input('name');
        $price = $request->input('price');
        $describe = $request->input('describe');

        //实例化orm
        $flight = new Flight;
        $flight->name = $name;
        $flight->price = $price;

        if(!$flight->save()){
            return response()->json(['status'=>0,'data'=>'新增失败']);
        }
        return response()->json(['status'=>1,'data'=>'新增成功']);

    }

    //查询
    public function show(Request $request)
    {
        //接收参数
        $id = $request->input('id');
        //实例化数据表
        $flight = new Flight;
        $res = $flight->where('id',$id)->get();
        $arr = [];
        foreach($res as $k => $y){
            $arr[$k]['name'] = $y->name;
            $arr[$k]['price'] = $y->price;
            $arr[$k]['describe'] = $y->describe;
            $arr[$k]['create_at'] = date('Y-m-d H:i:s',$y->created_at);
            $arr[$k]['update_at'] = date('Y-m-d H:i:s',$y->updated_at);
        }
        if(!$arr){
            return response()->json(['status'=>false,'data'=>'商品id不存在']);
        }
        return response()->json(['status'=>true,'data'=>$arr]);
    }

    public function del(Request $request)
    {
        //接收参数
        $id = $request->input('id');
        //实例化数据表
        $flight = new Flight();
        $res = $flight::find($id);
        if(!$res){
            return response()->json(['status'=>false,'data'=>'商品id不存在']);
        }
        if($res->delete()){
            return response()->json(['status'=>true,'data'=>'删除成功']);
        }else{
            return response()->json(['status'=>false,'data'=>'删除失败,请稍后再试']);
        }


    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'id' => 'required',
            'name' => 'required|string|min:2|max:20',
            'price' => 'required|numeric|between:0,10000',
            'describe' => 'required|string|min:0|max:30000'
        ], [
            'required' => ':attribute不能为空',
            'in' => ':attribute类型错误',
            'max' => ':attribute长度不符合要求',
            'min' => ':attribute超过长度限制',
            'numeric' => ':attribute必须是数字',
            'between' => ':attribute价格范围在0-100000之间',
        ],[
            'id' => '商品id',
            'name' => '商品名称',
            'price' => '商品价格',
            'describe' => '商品描述',
        ]);
        if($validator->fails()){
            return response()->json(['status'=>-1,'data'=>$validator->errors()->first()]);
        }

        //接收参数
        $id = $request->input('id');
        $name = $request->input('name');
        $price = $request->input('price');
        $describe = $request->input('describe');
         //实例化数据表
        $flight = new Flight();
        $res = $flight::find($id);
        if(!$res){
            return response()->json(['status'=>false,'data'=>'商品id不存在']);
        }

        $res->name = $name;
        $res->price = $price;
        $res->describe = $describe;
        if(!$res->save()){
            return response()->json(['status'=>0,'data'=>'修改失败']);
        }
        return response()->json(['status'=>1,'data'=>'修改成功']);
    }


}
