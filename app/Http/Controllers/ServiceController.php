<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\User;
use App\Models\Message;
use App\Jobs\SendMessage;
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
    public function services()
    {
        return view('services.index');
    }

    public function getServices()
    {
        $services = Service::where('is_published', 1)->paginate(6);
        return response()->json($services);
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
        $services = Service::where('user_id', auth()->id())->paginate(6);
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
            $imageName = auth()->user()->username . '_' . $request->title . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('assets/services'), $imageName);
        } else {
            $imageName = 'default.webp';
        }

        Service::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => auth()->id(),
            'img_src' => '/assets/services/' . $imageName,
            'is_published' => $request->has('is_published') ? 1 : 0,
            'price' => $request->price
        ]);
        return redirect(route('home'))->with('success', 'Service Created!!!');
    }

    /**
     * Display the specified service.
     */
    public function show(string $id)
    {
        $service = Service::where('id', $id)->first();

        if (auth()->id() === $service->user_id) {
            $chats = Chat::where('service_id', $service->id)->get();
        } else {
            $chats = Chat::where('service_id', $service->id)->where('user_id', auth()->id())->get();
        }
        if ($chats) {
            foreach ($chats->all() as $chat) {
                $user = User::where('id', $chat->user_id)->first();
                $owner = User::where('id', $chat->user_id)->first();
                $chat->user_obj = $user;
                $chat->owner_obj = $owner;
            }
        } else {
            $chats = collect();
        }

        return view('services.detail', [
            'service' => $service,
            'chats' => $chats
        ]);
    }

    /**
     * Show the form for editing the specified service.
     */
    public function edit(string $id)
    {
        $service = Service::where('id', $id)->first();
        return view('services.edit', compact('service'));
    }

    /**
     * Update the specified service in storage.
     */
    public function update(Request $request, string $id)
    {
        $service = Service::where('id', $id)->first();
        if ($request->image) {
            $imageName = '/assets/services/' . auth()->user()->username . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('assets/services'), $imageName);
        } else {
            $imageName = $service->img_src;
        }
        $service->update([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => auth()->id(),
            'img_src' => $imageName,
            'is_published' => $request->has('is_published') ? 1 : 0,
            'price' => $request->price
        ]);
        return redirect(route('home'))->with('success', 'Service Updated!!!');
    }

    /**
     * Remove the specified service from storage.
     */
    public function destroy(string $id)
    {
        $service = Service::where('id', $id)->first();
        if ($service != null) {
            $service->delete();
        }
        return response()->noContent();
    }

    public function messages($id): JsonResponse
    {
        $chat = Chat::find($id)->first();

        $messages =  Message::where('chat_id', $chat->id)->paginate(10);
        if ($messages) {
            foreach ($messages->all() as $message) {
                $from = User::where('id', $message->from)->first();
                $to = User::where('id', $message->to)->first();
                $message->from_obj = $from;
                $message->to_obj = $to;
            }
        }
        return response()->json($messages);
    }

    public function message(Request $request): JsonResponse
    {
        $chat_id = $request->get('chat_id');
        if ($chat_id === null) {
            $service = Service::where('id', $request->get('service_id'))->first();
            $chat = Chat::create([
                'service_id' => $service->id,
                'owner' => $request->get('to'),
                'user_id' => auth()->id()
            ]);
            $chat_id = $chat->id;
        } else {
            $chat = Chat::where('id', $chat_id);
        }
        $message = Message::create([
            'chat_id' => $chat_id,
            'text' => $request->get('text'),
            'to' => $request->get('to'),
            'from' => auth()->id(),
            'read' => false
        ]);
        /* $message->servicio_id = 1; */
        SendMessage::dispatch($message);

        return response()->json([
            'success' => true,
            'message' => "Message created and job dispatched.",
            'chat' => $chat
        ]);
    }
}
