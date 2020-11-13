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
        $rootObj = Obj::root()->forCurrentTeam()->first()->uuid;

        $object = Obj::forCurrentTeam()
                    ->where('uuid', $request->get('uuid', $rootObj))
                    ->with(['children.objectable'])
                    ->firstOrFail();

        return view('files.index', [
            'object' => $object

        ]);
    }
}
