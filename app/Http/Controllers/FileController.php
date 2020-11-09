<?php

namespace App\Http\Controllers;

use App\Models\Obj;
use Illuminate\Http\Request;

class FileController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /***
     * get object based on uuid provided in the request.
     * otherwise get object for the current team.
     * @return view()
     */
    public function index(Request $request)
    {
        $rootObj = optional(Obj::root()->forCurrentTeam()->first())->uuid;

        $object = Obj::forCurrentTeam()
                    ->where('uuid', $request->get('uuid', $rootObj))
                    ->firstOrFail();

        //dd($object->children->get(0)->isFile());

        return view('files.index', compact('object'));
    }
}
