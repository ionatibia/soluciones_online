<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
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
     * Show the services list.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $services = Service::where('is_published', 1)->paginate(10);
        return view('service.index', compact($services));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function home()
    {
        return view('home');
    }

    /**
     * Get auth owner services
     * 
     * @return |Illuminate\Http\JsonResponse
     */
    public function getMyServices(): JsonResponse
    {
        $services = Service::where('user_id', auth()->id())->paginate(10);
        return response()->json($services);
    }

    /**
     * Show the form for creating a new service.
     */
    public function create()
    {
        return view('services.create');
    }

    /**
     * Store a newly created service in storage.
     */
    public function store(Request $request)
    {
        /* return Validator::make($request, [
            'title' => ['required', 'string', 'min:3', 'max:20', 'unique:users'],
            'description' => ['required', 'string', 'min:3', 'max:800'],
            'image' => ['image', 'max:2048'],
            'is_published' => ['required']
        ]); */
        if ($request->image) {
            $imageName = auth()->user()->username . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('assets/services'), $imageName);
        } else {
            $imageName = 'default.webp';
        }

        Service::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => auth()->id(),
            'img_src' => '/assets/services/' . $imageName,
            'is_published' => (int)$request->is_published
        ]);
        return view('home');
    }

    /**
     * Display the specified service.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified service.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified service in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified service from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
