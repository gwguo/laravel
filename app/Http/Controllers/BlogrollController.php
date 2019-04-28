<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class BlogrollController extends Controller
{
    public function aa(Request $request){
        $sess = $request->session()->forget('user');
    }
    public function add(){
        return view('BlogrollController/add');
    }
    public function adddo(Request $request){
        $data = request()->all();
//        dd($data['_token']);
        unset($data['_token']);
        $data['logo']='';
        if ($request->hasFile('logo')){
            $data['logo'] = $this->images($request,'logo');
        }
//        dd($data);
        $res = DB::table('blogroll')->insert($data);
//        dd($res);
        if ($res){
            return redirect('BlogrollController/index')->with('status', '添加成功');
        }else{
            return redirect('BlogrollController/add')->with('status', '添加失败');
        }
    }
    public function index(){
        $query = request()->all();
        $name = request()->input('name');
        $where['show'] = '是';
        if ($name!=''){
            $where[] = ['name','like',"%$name%"];
        }
        $data = DB::table('blogroll')->where($where)->paginate(2);
//         dd($data)
        //compact 给摸板赋值
        return view('BlogrollController/index', compact('data','name','query'));
    }
    public function edit($id){
        $data = DB::table('blogroll')->where('id',$id)->get()->first();
        return view('BlogrollController/edit', ['data' => $data]);
    }
    public function editdo(Request $request){
        $data = request()->except('_token');
        $logo = DB::table('blogroll')->where('id',$data['id'])->select('logo');
        if ($request->hasFile('logo')){
            $data['logo'] = $this->images($request,'logo');
        }
        if (!empty($data['logo'])){
            @unlink(storage_path('app/public/images/').$logo);
        }
        $res = DB::table('blogroll')->where('id', $data['id'])->update($data);
        if ($res){
            return redirect('BlogrollController/index');
        }else{
            return redirect('BlogrollController/index');
        }
    }
    public function del($id){
        $logo = DB::table('blogroll')->where('id',$id)->select('logo');
        $res = DB::table('blogroll')->where('id',$id)->delete();
        if ($res){
            @unlink(storage_path('app/public/images/').$file->file);
            return redirect('BlogrollController/index');
        }
    }
    public function images(Request $request,$file){
        if ($request->file($file)->isValid()) {
            $photo = $request->file($file);
            $store_result = $photo->store(date('Ymd'));
            return $store_result;
        }
        exit('未获取到上传文件或上传过程出错');
    }
    public function checkName(){
        $name = request()->input('name');
        $id = request()->input('id');
        $where[] = ['name','=',$name];
        if ($id!='') {
            $where[] = ['id', '!=', $id];
        }
        $num = DB::table('blogroll')->where($where)->count();
        if ($num>0){
            return ['code'=>0,'font'=>'用户名已存在'];
        }else{
            return ['code'=>1,'font'=>'用户名可用'];
        }
    }
    public function login(){
        return view('BlogrollController/login');
    }
    public function loginDo(){
        $name = request()->input('name');
        $pwd = request()->input('pwd');
        $user = DB::table('user')->where('name',$name)->get()->first();
        if ($user){
            if ($pwd==$user->pwd){
                $userInfo = ['name'=>$name,'id'=>$user->id];
                session(['user'=>$userInfo]);
                echo 1;
                return redirect('BlogrollController/index')->with('status', '登录成功');
            }else{
                return redirect('/login')->with('status', '登录失败');
            }
        }else{
            echo 2;
            return redirect('/login')->with('status', '登录失败');
        }
    }
}
