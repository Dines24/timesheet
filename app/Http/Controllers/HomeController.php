<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Departments;
use App\Models\Designations;
use App\Models\UserPermissions;
use App\Models\ProjectUsers;
use App\Models\Tasks;
use App\User;
use App\Project;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Creating a Department.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function addDepartment(Request $request)
    {
        // $request->validate([
        //     'name' => 'required|string',    
        // ]);
        
        if ($request->department_id !== null) {
            $id = $request->department_id;
            $Departments = Departments::find($id);
        }else{
            $Departments = new Departments;
        }
                
        $Departments->name = $request->name;
        $Departments->created_by = Auth::user()->id;

        $add_department = $Departments->save();

        if($add_department){
            return response()->json(['status' => 200,'msg' => 'Department added Succesfully']);
        }else{
            return response()->json(['status' => 500,'msg' => 'Somthing went wrong']);
        }
        
    }

    /**
     * show a Department.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showDepartments(Request $request)
    {
        $sortBy = 'created_at';
        $orderBy = 'desc';

        $Departments = Departments::with('user')->orderBy($sortBy, $orderBy)->get();

        return response()->json(['status' => 200, 'data' => $Departments]);

    }

    /* delete department the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function deleteDepartment(Request $request)
   {
        
        $model = Departments::find( $request->department_id );
        
        if($model->delete()){
            return response()->json(['status' => 200, 'msg'=>'Department Deleted successfully.']);
        }
        else{
            return response()->json(['status' => 500, 'msg'=>'Somthing went wrong']);
        }
   
    }

    /**
     * Creating a designation.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function adddesignation(Request $request)
    {

        // $request->validate([
        //     'name' => 'required|string',    
        // ]);
      
        if ($request->designation_id !== null) {
            $Designations = Designations::find($request->designation_id);
        }else{
            $Designations = new Designations;
        }
        

        $Designations->name = $request->name;
        $Designations->created_by = Auth::user()->id;

        $add_designation = $Designations->save();

        if($add_designation){
            return response()->json(['status' => 200,'msg' => 'designation added Succesfully']);
        }else{
            return response()->json(['status' => 500,'msg' => 'Somthing went wrong']);
        }
        
    }

    /**
     * show a Department.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showDesignations(Request $request)
    {
        $sortBy = 'created_at';
        $orderBy = 'desc';

        $Designations = Designations::with('user')->orderBy($sortBy, $orderBy)->get();

        return response()->json(['status' => 200, 'data' => $Designations]);
    }

    /* delete designations the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function deleteDesignation(Request $request)
   {
        
        $model = Designations::find( $request->designation_id );
        
        if($model->delete()){
            return response()->json(['status' => 200, 'msg'=>'Designation Deleted successfully.']);
        }
        else{
            return response()->json(['status' => 500, 'msg'=>'Somthing went wrong']);
        }
   
    }

    /**
     * Creating a designation.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function addEmployee(Request $request)
    {

        // $request->validate([
        //     'fname' => 'required|string',    
        // ]);

        if ($request->user_id !== null) {
            $User = User::find($request->user_id);
        }else{
            $User = new User;
        }
                
        $User->fname = $request->fname;
        $User->lname = $request->lname;
        $User->department = $request->department;
        $User->designation_id = $request->designation;
        $User->email = $request->email;
        $User->phone_no = $request->phone_no;
        $User->role = '3';
        $User->password = bcrypt($request->password);
        $User->created_by = Auth::user()->id;

        $add_User = $User->save();

        if($add_User){
            return response()->json(['status' => 200,'msg' => 'User added Succesfully']);
        }else{
            return response()->json(['status' => 500,'msg' => 'Somthing went wrong']);
        }
        
    }

    /**
     * show a Department.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showEmployee(Request $request)
    {
        $sortBy = 'created_at';
        $orderBy = 'desc';

        $Users = User::whereIn('role', [2, 3])->orderBy($sortBy, $orderBy)->get();

        return response()->json(['status' => 200, 'data' => $Users]);
    }

    /* delete Employee the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function deleteEmployee(Request $request)
   {
        
        $model = User::find( $request->user_id );
        
        if($model->delete()){
            return response()->json(['status' => 200, 'msg'=>'User Deleted successfully.']);
        }
        else{
            return response()->json(['status' => 500, 'msg'=>'Somthing went wrong']);
        }
   
    }

    /* add project the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function addProject(Request $request)
   {
    // $json = file_get_contents('php://input');
    // return response()->json(['status' => 500,'msg' => $json->project_name]);
        $ispermission =  permission('addproject'); //1=addproject, 2=create, 3 = delete, 4=view
       
        if($ispermission[0]->addproject==0){
            return response()->json(['status' => 500,'msg' => 'permission denied']);
        }
        $filename = '';
        $post_type = 'document';
        if($request->hasFile('document'))
        {
            $allowedfileExtension=['jpg','jpeg','png'];
            $file = $request->file('document');
            
            $fileoriginname = $file->getClientOriginalName();
            
            $extension = $file->getClientOriginalExtension();
            $check=in_array($extension,$allowedfileExtension);
            // dd($extension);
            $photo =  $request->document;
                $filename = $photo->store($post_type);
            // if($check)
            // {
                
            //     // print_r($filename);die;
            // }
            // else
            // {
         
            // }
      
        }
        if ($request->project_id !== null) {
            $Project = Project::find($request->project_id);
        }else{
            $Project = new Project;
        }
                //projectname,
        $Project->project_name = $request->input('project_name');
        $Project->project_owner = $request->project_owner;
        $Project->project_from = $request->project_from;
        $Project->project_type = $request->project_type;
        $Project->project_for = $request->project_for;
        $Project->pages = $request->page;
        $Project->deadline = $request->deadline;
        $Project->priority = $request->priority;
        $Project->project_description = $request->project_description;
        $Project->document = $request->document;
        $Project->designing_est_time = $request->designing_est_time;
        $Project->ios_est_time = $request->ios_est_time;
        $Project->development_est_time = $request->development_est_time;
        $Project->android_est_time = $request->android_est_time;
        $Project->created_by = Auth::user()->id;
        $Project->document = $filename;

        $add_Project = $Project->save();

        if($add_Project){
            return response()->json(['status' => 200,'msg' => 'Project added Succesfully']);
        }else{
            return response()->json(['status' => 500,'msg' => 'Somthing went wrong']);
        }
   
    }
    public function getProjectsStatus(Request $request){
       
        // echo Auth::user()->id;die;
        $pendinglist = Project::where('status', '=', 'pending')->where('is_active', '=', '1')->get();
        $pendingCount = $pendinglist->count();
        $completedlist = Project::where('status', '=', 'completed')->where('is_active', '=', '1')->get();
        $completedCount = $completedlist->count();
        $ongoinglist = Project::where('status', '=', 'ongoing')->where('is_active', '=', '1')->get();
        $ongoingCount = $ongoinglist->count();
        $alllist = Project::where('is_active', '=', '1')->get();
        $allCount = $alllist->count();
        $pendingOngoingTotal = $pendingCount + $ongoingCount;
        $data['pending'] = [ 'pending' => $pendingCount, 'total' => $pendingOngoingTotal];
        $data['ongoing']= [ 'ongoing' => $ongoingCount, 'total' => $pendingOngoingTotal];
        $data['completed'] = ['completed' => $completedCount, 'total' => $allCount];
        return response()->json(['status' => 200,'pending' => $data['pending'],'ongoing' => $data['ongoing'] ,'completed' => $data['completed']]);
    }
    public function updatePermission(Request $request){
        if(Auth::user()->role == 1 || Auth::user()->role == 2){
            $permissiontype = $request->permissiontype; //addproject,view,createtask,delete,
            $permission = $request->permission; //1,0
            $user_id = $request->user_id;
            if($permissiontype=='status'){
                $user = User::find($user_id);
                $user->status = $permission;
                $user->save();
            }else{
                $data[$permissiontype] = $permission;
                $flight = UserPermissions::updateOrCreate(
                    ['user_id' => $user_id],
                    $data
                );
            }
            
            
            return response()->json(['status' => 200, 'msg' => 'permission updated']);
        }else{
            return response()->json(['status' => 500, 'msg' => 'permission denied']);
        }
    }
    public function getUserPermission(Request $request){
        if(Auth::user()->role == 1 || Auth::user()->role == 2){
            if($request->has('department_id')){
                $department_id = $request->department_id;
                $pendinglist = User::with('userPermissions')->with('designation')->where('department', '=', $department_id)->get();
            }else{
                $pendinglist = User::with('userPermissions')->with('designation')->get();
            }
           
            return response()->json(['status' => 200, 'data' => $pendinglist]);
        }
    }
    public function projectList(Request $request){
        if($request->has('status')){
            $status  =  $request->input('status');
            $Projects = Project::with('user')->where('status', '=', $status)->where('is_active', '=', '1')->get();
        }else{
            $Projects = Project::with('user')->where('is_active', '=', '1')->get();
        }
        
        foreach($Projects as $project){
            $notifications = \DB::table('users')
            ->select(\DB::raw("users.id ,users.fname,users.lname, project_users.status" ))
            ->leftJoin('project_users',function ($join) use ($project) {
                $join->on('users.id', '=' , 'project_users.user_id');
                $join->where('project_users.project_id','=',$project->id);
            })
            ->where('users.role','<>', 1)
            ->where('users.status','=', 1)
            ->get();
            $project['projectuser'] = $notifications;
        }
            return response()->json(['status' => 200, 'data' => $Projects]);
       
    }
    public function addremoveProjectUser(Request $request){
        if(Auth::user()->role == 1 || Auth::user()->role == 2){
                $data['status'] = (int) $request->input('status');
                $user_id = $request->user_id;
                $project_id = $request->project_id;
                $flight = ProjectUsers::updateOrCreate(
                    ['user_id' => $user_id, 'project_id' => $project_id],
                    $data
                );
            return response()->json(['status' => 200, 'msg' => 'user updated']);
        }else{
            return response()->json(['status' => 500, 'msg' => 'something went wrong']);
        }
    }
    public function deleteProject(Request $request)
    {
         
         $model = Project::find( $request->project_id );
         
         if($model->delete()){
             return response()->json(['status' => 200, 'msg'=>'Project Deleted successfully.']);
         }
         else{
             return response()->json(['status' => 500, 'msg'=>'Somthing went wrong']);
         }
    
     }
     public function getProject(Request $request){
        $product_id = $request->input('project_id');
            $Projects = Project::with('user')->where('id', '=', $product_id)->where('is_active', '=', '1')->get();
       
        
        foreach($Projects as $project){
            $notifications = \DB::table('users')
            ->select(\DB::raw("users.id ,users.fname,users.lname, project_users.status" ))
            ->leftJoin('project_users',function ($join) use ($project) {
                $join->on('users.id', '=' , 'project_users.user_id') ;
                $join->where('project_users.project_id','=',$project->id) ;
            })
            ->where('users.role','<>', 1)
            ->where('users.status','=', 1)
            ->get();
            $project['projectuser'] = $notifications;
        }
            return response()->json(['status' => 200, 'data' => $Projects]);
    }
    public function addTask(Request $request)
   {
    // $json = file_get_contents('php://input');
    // return response()->json(['status' => 500,'msg' => $json->project_name]);
        // $ispermission =  permission('createtask'); //1=addproject, 2=create, 3 = delete, 4=view
       
        // if($ispermission[0]->addproject==0){
        //     return response()->json(['status' => 500,'msg' => 'permission denied']);
        // }
        if ($request->has('task_id') && $request->task_id!='') {
            $Tasks = Tasks::find($request->task_id);
        }else{
            $Tasks = new Tasks;
        }
                //projectname,
        $Tasks->project_id = $request->input('project_id');
        $Tasks->task_name = $request->task_name;
        $Tasks->department = $request->department;
        $Tasks->description = $request->description;
        $Tasks->assign_to = $request->assign_to;
        $Tasks->start_date = $request->start_date;
        $Tasks->duration = $request->duration;
        $Tasks->priority = "low";
       
        $Tasks->created_by = Auth::user()->id;
        $addTasks = $Tasks->save();

        if($addTasks){
            return response()->json(['status' => 200,'msg' => 'Tasks added Succesfully']);
        }else{
            return response()->json(['status' => 500,'msg' => 'Somthing went wrong']);
        }
   
    }
    public function taskList(Request $request){
        // if($request->has('status')){
        //     $status  =  $request->input('status');
        //     $Projects = Project::with('user')->where('status', '=', $status)->where('is_active', '=', '1')->get();
        // }else{
        //     $Projects = Project::with('user')->where('is_active', '=', '1')->get();
        // }
        $project_id  =  $request->input('project_id');
        if($request->has('status')){
            $status  =  $request->input('status');
            $Tasks = Tasks::with('user')->with('project')->with('Departments')->where('status', '=', $status)->where('project_id', '=', $project_id)->where('is_active', '=', '1')->get();
        }else{
            $Tasks = Tasks::with('user')->with('project')->with('Departments')->where('is_active', '=', '1')->where('project_id', '=', $project_id)->get();
        }
        return response()->json(['status' => 200, 'data' => $Tasks]);
        // $Projects = Tasks::where('is_active', '=', '1')->where('project_id', '=', $request->input('project_id'))->get();
     
        //     return response()->json(['status' => 200, 'data' => $Projects]);
       
    }
    public function deleteTask(Request $request)
    {
         
         $model = Tasks::find( $request->task_id );
         
         if($model->delete()){
             return response()->json(['status' => 200, 'msg'=>'Task Deleted successfully.']);
         }
         else{
             return response()->json(['status' => 500, 'msg'=>'Somthing went wrong']);
         }
    
     }
     public function getTask(Request $request){
        $task_id = $request->input('task_id');
        $task = Tasks::with('user')->with('project')->with('Departments')->where('id', '=', $task_id)->where('is_active', '=', '1')->get();
        return response()->json(['status' => 200, 'data' => $task]);
    }
    // public function tasksList(Request $request){
    //     $project_id  =  $request->input('project_id');
    //     if($request->has('status')){
    //         $status  =  $request->input('status');
    //         $Tasks = Tasks::with('user')->with('project')->with('Departments')->where('status', '=', $status)->where('project_id', '=', $project_id)->where('is_active', '=', '1')->get();
    //     }else{
    //         $Tasks = Tasks::with('user')->with('project')->with('Departments')->where('is_active', '=', '1')where('project_id', '=', $project_id)->get();
    //     }
    //     return response()->json(['status' => 200, 'data' => $Tasks]);
    // }
    public function tasksHistory(Request $request){
        if($request->has('status')){
            $status  =  $request->input('status');
            $Tasks = Tasks::with('user')->with('project')->with('Departments')->where('status', '=', $status)->where('is_active', '=', '1')->get();
        }else{
            $Tasks = Tasks::with('user')->with('project')->with('Departments')->where('is_active', '=', '1')->get();
        }
        return response()->json(['status' => 200, 'data' => $Tasks]);
    }
    public function getProjectUser(Request $request){
        $validator= \Validator::make($request->all(),[
            'project_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 401, 'error' => $validator->messages() ]);
        }
        $ProjectUsers = ProjectUsers::with('user')->where('project_id', '=', $request->project_id)->where('status', '=', 1)->get();
        return response()->json(['status' => 200, 'data' => $ProjectUsers]);
    }

    public function completeProject(Request $request)
    {

        if ($request->has('project_id')) {
            $project = Project::find($request->project_id);
        }else{
            return response()->json(['status' => 500,'msg' => 'Somthing went wrong']);
        }

        $project->status = 'completed';
        $completeproject = $project->save();

        if($completeproject){
            return response()->json(['status' => 200,'msg' => 'Project Completed Succesfully']);
        }else{
            return response()->json(['status' => 500,'msg' => 'Somthing went wrong']);
        }
                 
     }

     public function completeTask(Request $request)
     {
 
         if ($request->has('task_id')) {
             $task = Tasks::find($request->task_id);
         }else{
            return response()->json(['status' => 500,'msg' => 'Somthing went wrong']);
         }
 
         $task->status = 'completed';
         $completetask = $task->save();
 
         if($completetask){
             return response()->json(['status' => 200,'msg' => 'Task Completed Succesfully']);
         }else{
             return response()->json(['status' => 500,'msg' => 'Somthing went wrong']);
         }
                  
      }

      public function departmentTask(Request $request){

        $department_id  =  $request->input('department_id');
        if($request->has('department_id')){
            $Tasks = Tasks::with('user')->with('project')->with('Departments')->where('department', '=', $department_id)->where('is_active', '=', '1')->get();
    
        return response()->json(['status' => 200, 'data' => $Tasks]);
       
    }
}
}
