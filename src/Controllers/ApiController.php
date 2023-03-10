<?php

namespace Denniskemboi\LaravelRestHelper\Controllers;

use Exception;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    protected $model = null;
    protected $with=[];
    protected $name=null;

    public function __construct(){
        
    }

    // get the name of the 
    protected function getName(){
        $name = "";
        if(is_null($this->name) && is_null($this->model))
            $name = "";
        elseif(is_null($this->name))
            $name = get_class($this->model);
        else $name = $this->name;
        return ucfirst(strtolower($name));
    }

    // list all
    public function index()
    {
        $data = [];
        try {
            if(isset($this->with)){
                if(is_array($this->with)){
                    if(sizeof($this->with)>0){
                        $query = $this->model::query();
                        foreach($this->with as $with){
                            $query = $query->with($with);
                        }
                        $data['data'] = $query->get();
                    }else $data['data'] = $this->model::all();
                }else $data['data'] = $this->model::with($this->with)->get();
            }else $data['data'] = $this->model::all();
            
            $data['success']=true;
            return response()->json($data, 200);
        } catch (Exception $e) {
            $data['success']=false;
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    // save to the database
    public function store(Request $request)
    {
        try {
            $data = new $this->model();
            $data->fromReq($request);
            $data->save();
            return response()->json(['success' => true, 'message' => $this->getName(). ' saved successfully', 'data'=>$data], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
        }
    }

    // retrieve one item from the database
    public function show($id)
    {
        $data = [];
        try {
            if(isset($this->with)){
                if(is_array($this->with)){
                    if(sizeof($this->with)>0){
                        $query = $this->model::query();
                        foreach($this->with as $with){
                            $query = $query->with($with);
                        }
                        $data['data'] = $query->find($id);
                    }else $data['data'] = $this->model::find($id);
                }else $data['data'] = $this->model::with($this->with)->find($id);
            }else $data['data'] = $this->model::find($id);
            $data['success']=true;
            return response()->json($data, 200);
        } catch (Exception $e) {
            $data['success']=false;
            $data['message'] = $e->getMessage();
            return response()->json($data, 400);
        }
    }

    // updates an item in the database
    public function update(Request $request, $id)
    {
        $data=[];
        try {
            // retrive rocord from database
            $rec = $this->model::query()->find($id);
            $rec->fromReq($request);
            $rec->update();

            $data['success']=true;
            $data['message'] = $this->getName(). $this->getName().' updated successfully';

            return response()->json($data, 200);
        } catch (Exception $e) {
            $data['success']=false;
            $data['message'] = $e->getMessage();
            return response()->json($data, 400);
        }
    }

    public function destroy($id)
    {
        $data=[];
        try {
            $rec = $this->model::query()->find($id);
            $rec->delete();
            $data['success']=true;
            $data['message'] = $this->getName().' deleted successfully';
            return response()->json($data, 200);
        } catch (Exception $e) {
            $data['success']=false;
            $data['message'] = $e->getMessage();
            return response()->json($data, 400);
        }
    }
}
