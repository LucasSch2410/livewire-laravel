<?php
namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
    use HttpResponses;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        if (!$user->tokenCan('server:update')) {
            return $this->response('Você não tem acesso.', 401);
        }

        $users = User::all();
        $userResource = UserResource::collection($users)->resolve();
        return $this->response('Retorno dos usuários com sucesso!', 200, $userResource);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);
        $userResource = (new UserResource($user))->resolve();
        return $this->response('Usuário criado com sucesso!', 201, $userResource);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);
        if (!$user) {
            return $this->response('Usuário não encontrado.', 404);
        }
        $userResource = (new UserResource($user))->resolve();
        return $this->response('Usuário encontrado.', 200, $userResource);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
