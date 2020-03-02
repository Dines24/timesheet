<?php
  use Illuminate\Support\Facades\Auth;
  use App\Models\UserPermissions;
function changeDateFormate($date,$date_format){
    return \Carbon\Carbon::createFromFormat('Y-m-d', $date)->format($date_format);    
}
   
function productImagePath($image_name)
{
    return public_path('images/products/'.$image_name);
}

function permission($permission_type){
    // echo Auth::user()->id;die;// Add Project = 1, Create Task = 2, Delete = 3, View  = 4
    $Permissions = UserPermissions::where('user_id', '=', Auth::user()->id )->where($permission_type, '=', 1)->get();
    // echo json_encode($Permissions);die;
    return $Permissions;
}
function allpermission(){
    // echo Auth::user()->id;die;// Add Project = 1, Create Task = 2, Delete = 3, View  = 4
    return $Permissions = UserPermissions::where('user_id', '=', Auth::user()->id )->where('is_active', '=', '1')->get();
}
