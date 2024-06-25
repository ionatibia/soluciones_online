<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function getMyServices(): JsonResponse
    {
        $services = Service::where('user_id', auth()->id())->paginate(10);
        return response()->json($services);
    }

    public function createService(Request $request): JsonResponse
    {
        return Validator::make($request, [
            'name' => ['required', 'string', 'min:3', 'max:20', 'unique:users'],
            'description' => ['required', 'string', 'min:3', 'max:800'],
            'image' => ['image', 'max:2048']
        ]);

        if ($request->image) {
            $imageName = auth()->username . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('assets/services'), $imageName);
        } else {
            $imageName = 'default.webp';
        }

        $service = Service::create([
            'name' => $request->name,
            'description' => $request->description,
            'user_id' => auth()->id(),
            'img_src' => '/assets/services/' . $imageName
        ]);
        return response()->json($service);
    }
}
