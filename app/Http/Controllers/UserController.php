<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    //
    /**
     * Procesa la petición de listar todos los usuarios.
     * @return Response Objeto Response que regresa el controlador.
     * @author GerardCod
     * @version 1.0.0
     */
    public function index(): Response {
        return response(User::all(), Response::HTTP_OK);
    }

    /**
     * Procesa la petición de obtener la información de un usuario específico.
     * @param $id int Id del usuario.
     * @return Response Objeto Response que regresa el controlador
     * @author GerardCod
     * @version 1.0.0
     */
    public function show(int $id): Response {
        return response(User::find($id), Response::HTTP_OK);
    }

    /**
     * Procesa la petición de creación de un usuario.
     * @param CreateUserRequest $request Cuerpo de la petición.
     * @return Response Objeto Response que regresa el controlador.
     * @author GerardCod
     * @version 1.0.0
     */
    public function store(CreateUserRequest $request): Response {
        $user = User::create($request->only('first_name', 'last_name', 'email') +
            ['password' => Hash::make(123456789)]
        );
        return response($user, Response::HTTP_CREATED);
    }

    /**
     * Procesa la petición de actualizar un usuario.
     * @param UpdateUserRequest $request
     * @param int $id Id del usuario.
     * @return Response Objeto Response que regresa el controlador.
     * @author GerardCod
     * @version 1.0.0
     */
    public function update(UpdateUserRequest $request, int $id): Response {
        $user = User::find($id);
        $body = $request->only('first_name', 'last_name', 'email', 'password');
        $body["password"] = Hash::make($body['password']);
        $user->update($body);
        return response($user, Response::HTTP_ACCEPTED);
    }

    /**
     * Procesa la petición de borrar un usuario.
     * @param int $id
     * @return Response Objeto Response que regresa el controlador.
     * @author GerardCod
     * @version 1.0.0.
     */
    public function destroy(int $id): Response {
        User::destroy($id);
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
