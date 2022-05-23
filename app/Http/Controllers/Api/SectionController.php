<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\SectionStoreRequest;
use App\Http\Requests\SectionUpdateRequest;
use App\Http\Resources\Section\SectionCollection;
use App\Http\Resources\Section\SectionResource;
use App\Models\Section;
use Illuminate\Support\Facades\Auth;

class SectionController extends Controller
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
    public function index()
    {        
        return new SectionCollection(Section::with('users')->paginate(5));
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
    public function store(SectionStoreRequest $request)
    {
        $section = Section::create($request->only(['name', 'description', 'logo']));        
        
        if(empty($section)) {
            return response()->json(['message' => 'Внутранняя ошибка сервера при создании нового отдела!'], 500);            
        }        

        //Проверка на наличие полученного от формы значения поля с name="users"
        if($request->input('users')) :
            $section->users()->attach($request->input('users'));
        endif;
        
        return response()->json(['message' => 'Новый отдел ' . $section->name . ' успешно создан']);
        
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
        $section = Section::find($id);
        if($section) {
            return new SectionResource($section);
        }
        else {
            return response()->json(['message' => 'Отдел с идентификатором id ' . $id . ' не найден!'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SectionUpdateRequest $request, $id)
    {
        $section = Section::find($id);

        if(empty($section)) {
            return response()->json(['message' => 'Пользователь с идентификатором id ' . $id . ' не найден!'], 404);
        }       

        if(empty($section->update($request->only(['name', 'description', 'logo'])))) {
            return response()->json(['message' => 'Внутренняя ошибка сервера при сохранении изменений данных по отделу!'], 500);            
        }

        //Если список пользователей пуст - отсоединяем
        $section->users()->detach();
        //Проверка на наличие полученного от формы значения поля с name="users"
        if($request->input('users')) :
            $section->users()->attach($request->input('users'));
        endif;
        
        return response()->json(['message' => 'Изменения для отдела "' . $section->name . '" успешно применены']);
          
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $section = Section::find($id);

        if(empty($section)) {
            return response()->json(['message' => 'Отдел с идентификатором id ' . $id . ' не найден!'], 404);
        }
        
        $section->users()->detach();

        $section->delete();

        return new SectionCollection(Section::with('users')->get());
    }
}
