<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Gate;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Task;
use App\Repositories\TaskRepository;
    
class TaskController extends Controller
{
    /**
     * The task repository instance.
     *
     * @var TaskRepository
     */
    protected $tasks;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(TaskRepository $tasks)
    {
        $this->middleware('auth');

		$this->tasks = $tasks;
    }

    /**
     * Display a list of all of the user's task.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request)
    {
//$uu = $request->user();
//print_r($uu);
////print_r($uu->attributes);
//var_dump($uu->name);
//var_dump($uu->attributes);
//var_dump($uu);
//$attr = $uu->getAttributes();
//var_dump($attr);
//exit;
//eval(\Psy\sh());

//		$tasks = Task::where('user_id', $request->user()->id)->get();

        //return view('tasks.index');
        return view('tasks.index', [
            //'tasks' => $tasks,
            'tasks' => $this->tasks->forUser($request->user()),
        ]);
    }

    /**
     * Create a new task.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
        ]);
    
        // Create The Task...
        $request->user()->tasks()->create([
            'name' => $request->name,
        ]);
    
        return redirect('/tasks');
    }

    /**
     * Destroy the given task.
     *
     * @param  Request  $request
     * @param  Task  $task
     * @return Response
     */
    public function destroy(Request $request, Task $task)
    {
//print_r($task);
//print_r($request->user());
//exit;
	    $this->authorize('destroy', $task);
//eval(\Psy\sh());

//		if (Gate::denies('destroy', $task)) {
//			echo 'deny';
//        } else {
//			echo 'allow';
//		}
//echo "done";
//exit;

	    $task->delete();
	
	    return redirect('/tasks');
    }


}
