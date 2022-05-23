<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\User\UserCollection;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Helpers\CollectionHelper;

class UserController extends Controller
{
    /**
     * current User
     *
     * @var User
     */
    protected $user;
    
    public function __construct()
    {
       $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {               
        if($request->has('alldata')) {
            return new UserCollection(User::all());
        }

        $results = User::all()->sortByDesc('created_at');
        $total = $results->count();
        $pageSize = 5;
        $users = CollectionHelper::paginate($results, $total, $pageSize);
        
        return new UserCollection($users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request)
    {
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password'))
        ]);

        if($user) {
            return response()->json(['message' => 'Новый пользователь "' . $user->name . '" успешно создан']);
        }
        else {
            return response()->json(['message' => 'Внутренняя ошибка сервера при создании нового пользователя!'], 500);
        }        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        if($user) {
            return new UserResource($user);
        }
        else {
            return response()->json(['message' => 'Пользователь с идентификатором id ' . $id . ' не найден!'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, $id)
    {        
        $user = User::find($id);

        if(empty($user)) {
            return response()->json(['message' => 'Пользователь с идентификатором id ' . $id . ' не найден!'], 404);
        }
        
        if($user->id !== $this->user && $user->is_admin) {
            return response()->json(['message' => 'Обычным пользователям нельзя редактировать профили других пользователей!'], 422);
        }

        $user->name = $request->input('name');       
        $user->email = $request->input('email');
        //Если поле == null - в модель пароль не передавать, иначе - зашифровать перед передачей в модель
        $request->input('password') == null ?: $user->password = bcrypt($request['password']);
        
        if(empty($user->save())) {
            return response()->json(['message' => 'Внутренняя ошибка сервера при сохранении изменений данных пользователя!'], 500);
        }

        return response()->json(['message' => 'Изменения для пользователя "' . $user->name . '" успешно применены']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);        

        if(empty($user)) {
            return response()->json(['message' => 'Пользователь с идентификатором id ' . $id . ' не найден!'], 404);
        }
        
        if($user->is_admin) {
            return response()->json(['message' => 'Нельзя удалять Администраторов!'], 422);
        }

        if($user->id !== $this->user && $user->is_admin) {
            return response()->json(['message' => 'Обычным пользователям нельзя удалять других пользователей!'], 422);
        }

        $user->sections()->detach();

        $user->delete();

        return new UserCollection(User::all());
    }
}
