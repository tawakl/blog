<?php

namespace App\Blog\Categories\Controllers;
use App\Blog\Categories\Category;
use App\Blog\Categories\Requests\CreateCategoriesRequest;
use App\Blog\Categories\Requests\UpdateCategoriesRequest;
use App\Http\Controllers\Controller;


class CategoriesController extends Controller
{
    public $model;
    public $module;

    public function __construct(Category $model)
    {
        $this->module = 'categories';
        $this->title = trans('app.Categories');
        $this->model = $model;
    }
    public function getIndex()
    {
        $data['module'] = $this->module;
        $data['page_title'] = trans('categories.List categories');
        $data['rows'] = $this->model->getData()->latest()->paginate();
        return view('admin.'.$this->module . '.index', $data);
    }


    public function getCreate()
    {
        $data['module'] = $this->module;
        $data['page_title'] = trans('app.Create') . " " . $this->title;
        $data['breadcrumb'] = [$this->title => route('categories')];
        $data['row'] = $this->model;
        return view('admin.'.$this->module . '.create', $data);

    }

    public function postCreate(CreateCategoriesRequest $request)
    {
        $data['module'] = $this->module;
        if ($row = $this->model->create($request->except(['_token']))) {
            flash()->success(trans('app.Created successfully'));
            return redirect( '/' . $this->module );
        }
        flash()->error(trans('app.failed to save'));
        return back();
    }


    public function getEdit($id) {
        $data['module'] = $this->module;
        $data['page_title'] = trans('app.Edit') . " " . $this->title;
        $data['breadcrumb'] = [$this->title => $this->module];
        $data['row'] = $this->model->findOrFail($id);
        return view('admin.'.$this->module . '.edit', $data);
    }

    public function postEdit(UpdateCategoriesRequest $request , $id) {
        $row = $this->model->findOrFail($id);
        if ($row->update($request->except(['_token','_method']))) {
            flash(trans('app.Update successfully'))->success();
            return redirect( '/' . $this->module );
        }
    }

    public function getDelete($id)
    {
        $row = $this->model->findOrFail($id);
        $row->delete();
        flash()->success(trans('app.Deleted Successfully'));
        return back();
    }

}
