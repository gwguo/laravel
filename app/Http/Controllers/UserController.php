<?php
namespace app\http\controllers;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Validator;
//引入验证器类
use App\Http\Requests\StoreBlogPost;

class UserController extends BaseController
{
    public function add(){
        return view('UserController/add');
    }
    public function aa(Request $request){
        echo $request->session()->get('name');
        die;
        session('user',null);
    }
    public function login(){
        return view('UserController/login');
    }
    public function loginDo(){
        $name = request()->input('name');
        $pwd = request()->input('pwd');
        $user = DB::table('user')->where('name',$name)->get()->first();
        if ($user){
            if ($pwd==$user->pwd){
                session('user',['name'=>$name,'id'=>$user->id]);
                return redirect('UserController/index')->with('status', '登录成功');
            }else{
                return redirect('UserController/login')->with('status', '登录失败');
            }
        }else{
            return redirect('UserController/login')->with('status', '登录失败');
        }
    }
    public function index()
    {
        $name = request()->session()->get('userInfo')['name'];
        return view('UserController/index',compact('name'));
    }
    //引入验证器类自动验证
    public function adddo(StoreBlogPost $request){
//        $validator = Validator::make($request->all(), [
//            'name' => 'required|unique:user|max:255',
//            'sex' => 'required|integer',
//        ]);
//        if ($validator->fails()) {
//            return redirect('UserController/add')
//                ->withErrors($validator)
//                ->withInput();
//        }
        $post['name'] = request()->input('name');
        $post['sex'] = request()->input('sex');
        $post['pwd'] = request()->input('pwd');
        $post['file']='';
        if ($request->hasFile('file')){
            $post['file'] = $this->images($request,'file');
        }
        $res =DB::insert('insert into user values (null,?,?,?,?)',
            [$post['name'],$post['sex'],$post['file'],$post['pwd']]);
        if ($res){
            return redirect('UserController/index');
        }
    }
    public function del($id){
        $file = DB::table('user')->where('id',$id)->get()->first();
        $res = DB::delete('delete from user where id = :id', ['id' => $id]);
        if ($res){
            @unlink(storage_path('app/public/images/').$file->file);
            return redirect('UserController/index');
        }
    }
    public function edit($id){
        $data = DB::table('user')->where('id',$id)->get()->first();
        return view('UserController/edit', ['data' => $data]);
    }
    public function update(Request $request){
        $data = request()->except('_token');
        $file = DB::table('user')->where('id',$data['id'])->get()->first();
        if ($request->hasFile('file')){
            $data['file'] = $this->images($request,'file');
        }
        if (!empty($data['file'])){
            @unlink(storage_path('app/public/images/').$file->file);
        }
        $res = DB::table('user')->where('id', $data['id'])->update($data);
        if ($res){
            return redirect('UserController/index');
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
        $num = DB::table('user')->where('name',$name)->count();
        if ($num>0){
            return ['code'=>0,'font'=>'用户名已存在'];
        }else{
            return ['code'=>1,'font'=>'用户名可用'];
        }
    }
}