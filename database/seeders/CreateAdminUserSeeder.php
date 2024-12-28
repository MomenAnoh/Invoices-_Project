<?php
namespace Database\Seeders;  // لازم

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class CreateAdminUserSeeder extends Seeder

// دا يخليني او معمل مثلا فريش للداتا او اطير الداتا يعملي ايميل وياس واسم جديد

{
/**
* Run the database seeds.
*
* @return void
*/
public function run()
{
    
         $user = User::create([
        'name' => 'Momen ', 
        'email' => 'momennoh123aa@gamal.com',
        'password' => bcrypt('20042004'),
        'roles_name' => ["owner"],
        'Status' => 'مفعل',
        ]);
  
        $role = Role::create(['name' => 'owner']);
   
        $permissions = Permission::pluck('id','id')->all();
  
        $role->syncPermissions($permissions);
   
        $user->assignRole([$role->id]);


}
}
