<?php

namespace App\Http\Controllers;

use App\Project;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with('projects')->orderBy('created_at', 'desc')->get();

        $avg = User::select(DB::raw('avg(sociability) s, avg(engineering_skill) e, avg(time_management) t, avg(knowledge_of_languages) k'))
                ->first();

        return view('app', compact('users', 'avg'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
        ]);
        if ($validator->fails()) {
            $error_text = '';
            foreach ($validator->messages()->all('<li>:message</li>') as $message)
            {
                $error_text .= $message;
            }
            return response()->json([
                'status' => 0,
                'msg' => $error_text
            ]);
        }

        $filename = '';
        if ($request->hasFile('photo')) {
            $path = public_path() . '\uploads\photos\\';
            $file = $request->file('photo');

            $filename = (str_random(20) . '.' . $file->getClientOriginalExtension()) ?: 'png';
            $img = Image::make($file);
            $img->fit(80, 80)->save($path . $filename);
        }

        $user = new User();
        $user->name = $request->name;
        $user->photo = $filename;
        $user->sociability = (int)$request->sociability;
        $user->engineering_skill = (int)$request->engineering_skill;
        $user->time_management = (int)$request->time_management;
        $user->knowledge_of_languages = (int)$request->knowledge_of_languages;
        $user->save();

        if ( !empty($request->projects[0]) && \count($request->projects) > 0 ) {
            $user->projects()->sync($request->projects);
        }

        return response()->json([
            'status' => 1,
            'msg' => 'User added'
        ]);
    }


    /**
     * List resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        $users = User::with('projects')->orderBy('created_at', 'desc')->get();

        $avg = User::select(DB::raw('avg(sociability) s, avg(engineering_skill) e, avg(time_management) t, avg(knowledge_of_languages) k'))
            ->first();

        return view('partials.list', compact('users', 'avg'));
    }

    /**
     * Search resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $users = User::with('projects')->where('name', 'like', $request->text.'%')->orderBy('created_at', 'desc')->get();

        $avg = User::where('name', 'like', $request->text.'%')
            ->select(DB::raw('avg(sociability) s, avg(engineering_skill) e, avg(time_management) t, avg(knowledge_of_languages) k'))
            ->first();

        return view('partials.list', compact('users', 'avg'));
    }

    /**
     * Show add user form.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $projects = Project::orderBy('id', 'asc')->get();
        return view('partials.modal', compact('projects'))->with('modal_title', 'Add New User')->with('route', '/add');
    }

    /**
     * Show edit user form.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $user = User::with('projects')->where('id', $request->user_id)->first();

        $projects = Project::orderBy('id', 'asc')->get();

        $projects_ids = [];
        foreach ($user->projects as $key => $value) {
            $projects_ids[] = $value->id;
        }

        return view('partials.modal', compact('projects'))->with('user', $user)->with('projects_ids', $projects_ids)->with('modal_title', 'Update User')->with('route', '/edit');
    }

    /**
     * Update resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = User::where('id',  $request->user_id)->first();

        if ( $user ) {

            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255',
                'sociability' => 'min:1|max:10',
                'engineering_skill' => 'integer|between:1,10',
                'time_management' => 'integer|between:1,10',
                'knowledge_of_languages' => 'integer|between:1,10',
            ]);
            if ($validator->fails()) {
                $error_text = '';
                foreach ($validator->messages()->all('<li>:message</li>') as $message)
                {
                    $error_text .= $message;
                }
                return response()->json([
                    'status' => 0,
                    'msg' => $error_text
                ]);
            }

            $filename = $request->photo;

            if ( $request->hasFile('photo')) {
                $path = public_path() . '\uploads\photos\\';
                $file = $request->file('photo');
                $filename = (str_random(20) . '.' . $file->getClientOriginalExtension()) ?: 'png';
                $img = Image::make($file);
                $img->fit(80, 80)->save($path . $filename);
            }

            User::where('id',  $request->user_id)->update([
                'name' => $request->name,
                'photo' => $filename,
                'sociability' => (int)$request->sociability,
                'engineering_skill' => (int)$request->engineering_skill,
                'time_management' => (int)$request->time_management,
                'knowledge_of_languages' => (int)$request->knowledge_of_languages,
            ]);
            if ( !empty($request->projects[0]) && \count($request->projects) > 0 ) {
                $user = User::findOrFail($request->user_id);
                $user->projects()->sync($request->projects);
                $user->save();
            }

            $result = [
               'status' => 1,
               'msg' => 'User edited'
            ];
        } else {
            $result = [
                'status' => 1,
                'msg' => 'Error'
            ];
        }

        return response()->json($result);
    }

    /**
     * Remove user photo.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function remove_photo(Request $request)
    {
        $user = User::where('id',  $request->user_id)->first();
        if ( $user->photo !== '' ) {
            User::where('id',  $request->user_id)->update(['photo' => '']);
            @unlink(public_path('uploads/photos/'.$user->photo));
            $result = [
                'status' => 1,
                'msg' => 'Photo deleted'
            ];
        } else {
            $result = [
                'status' => 0,
                'msg' => 'Photo not deleted'
            ];
        }
        return response()->json($result);
    }

}
