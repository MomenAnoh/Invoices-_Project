<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;
class RoleController extends Controller
{
/**
* Display a listing of the resource.
*
* @return \Illuminate\Http\Response
*/


// دي حماية للكنتروللر عشان  ميعرفش يدخل ع اي حاجة لوملهوش احقية ممكن يخش باللين كعشان كدا هعمل الحماية 
// public function __construct()
// {
//     $this->middleware('permission:عرض صلاحية', ['only' => ['index']]);// معناها لو احقية انو يخش علي فانكشن الادكس لو معاه صلاحية عرض الصلاحية وهكذا 
//     $this->middleware('permission:اضافة صلاحية', ['only' => ['create','store']]);
//     $this->middleware('permission:تعديل صلاحية', ['only' => ['edit','update']]);
//     $this->middleware('permission:حذف صلاحية', ['only' => ['destroy']]);
// }




/**
* Display a listing of the resource.
*
* @return \Illuminate\Http\Response
*/
public function index(Request $request)
{
$roles = Role::orderBy('id','DESC')->paginate(5);
return view('roles.index',compact('roles'))
->with('i', ($request->input('page', 1) - 1) * 5);
}
/**
* Show the form for creating a new resource.
*
* @return \Illuminate\Http\Response
*/
public function create()
{
$permission = Permission::get();
return view('roles.create',compact('permission'));
}
/**
* Store a newly created resource in storage.
*
* @param  \Illuminate\Http\Request  $request
* @return \Illuminate\Http\Response
*/
public function store(Request $request)
{
    
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'permission' => 'required|array', 
    ]);

  
    $role = Role::create([
        'name' => $request->input('name'),
    ]);

    // جلب الصلاحيات باستخدام المعرفات المرسلة
    $permissions = Permission::whereIn('id', $request->input('permission'))->get();

    // ربط الصلاحيات بالدور
    $role->syncPermissions($permissions);

    return redirect()->route('roles.index')->with('success', 'تم إضافة الدور بنجاح');
}
/**
* Display the specified resource.
*
* @param  int  $id
* @return \Illuminate\Http\Response
*/
public function show($id)
{
$role = Role::find($id);
$rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
->where("role_has_permissions.role_id",$id)
->get();
return view('roles.show',compact('role','rolePermissions'));
}
/**
* Show the form for editing the specified resource.
*
* @param  int  $id
* @return \Illuminate\Http\Response
*/
public function edit($id)
{
$role = Role::find($id);
$permission = Permission::get();
$rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
->all();
return view('roles.edit',compact('role','permission','rolePermissions'));
}
/**
* Update the specified resource in storage.
*
* @param  \Illuminate\Http\Request  $request
* @param  int  $id
* @return \Illuminate\Http\Response
*/
public function update(Request $request, $id)
{
    // التحقق من صحة البيانات
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'permission' => 'required|array',
        'permission.*' => 'exists:permissions,id',  // تأكد من أن المعرفات موجودة
    ]);

    // جلب الدور بناءً على المعرف
    $role = Role::find($id);

    // إذا لم يتم العثور على الدور، قم بإرجاع خطأ
    if (!$role) {
        return redirect()->route('roles.index')->with('error', 'الدور غير موجود');
    }

    // تحديث اسم الدور
    $role->name = $request->input('name');
    $role->save();

    // جلب الصلاحيات بناءً على المعرفات المُرسلة
    $permissions = Permission::whereIn('id', $request->input('permission'))->get();

    // ربط الصلاحيات بالدور
    $role->syncPermissions($permissions);

    // إعادة التوجيه مع رسالة نجاح
    return redirect()->route('roles.index')->with('success', 'تم تحديث الدور بنجاح');
}

/**
* Remove the specified resource from storage.
*
* @param  int  $id
* @return \Illuminate\Http\Response
*/
public function destroy($id)
{
DB::table("roles")->where('id',$id)->delete();
return redirect()->route('roles.index')
->with('success','Role deleted successfully');
}
}