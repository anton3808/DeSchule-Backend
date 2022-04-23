<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Transformers\PackageResource;

use App\Models\Package\Package;

class PackageController extends Controller
{
    protected $package;

    public function __construct(Package $package){
        $this->package = $package;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $lang = $request->header('Language', 'uk');
        $type = $request->input('type');
        \App::setLocale($lang);

        $package = $this->package;
        if($type) {
            $package = $package->where('type', $type);
        }

        $package = $package->paginate($request->get('limit', 15));

        return PackageResource::collection($package);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $lang = $request->header('Language', 'uk');
        \App::setLocale($lang);

        $package = $this->package->find($id);
        return PackageResource::make($package);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
