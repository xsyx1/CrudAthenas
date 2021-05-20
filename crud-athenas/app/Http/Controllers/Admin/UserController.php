<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Person;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class UserController extends Controller
{

    public function index(Request $request)
    {
        $data =  User::person()
            ->when(!empty($request->search), function ($q) use ($request) {
                return  $q->where(function ($quer) use ($request) {
                    return $quer->where('name', 'LIKE', "%$request->search%")
                        ->orWhereRaw('(replace(replace(replace(nif, ".", ""), "/", ""), "-", "") like "%' . clean($request->search) . '%")');
                });
            })
            ->when(!empty($request->start_date), function ($q) use ($request) {
                return $q->where('users.created_at', '>=', $request->start_date);
            })
            ->when(!empty($request->end_date), function ($q) use ($request) {
                return $q->where('users.created_at', '<=', $request->end_date);
            })
            ->latest('id')
            ->paginate(10);

        return view('users.index', compact('data'));
    }

    public function create()
    {

        return view('users.create');
    }

    public function store(Request $request)
    {
        

        DB::transaction(function () use ($request) {
            $inputs = $request->all();
            $inputs['type'] = strlen($request->nif) == 11 ? 1 : 2;

            $person = Person::updateOrCreate(
                [
                    'nif' => $request->nif
                ],
                $inputs
            );

            $inputs['person_id'] = $person->id;
            $inputs['password'] = bcrypt($request->input('password'));

            $user = User::updateOrCreate(
                ['person_id' => $person->id],
                $inputs
            );

        });

        return redirect()->route('users.index')
            ->withStatus('Registro adcionado com sucesso.');
    }

    public function show($id)
    {
        $item = User::person()->findOrFail($id);

        return view('users.show', compact('item'));
    }

    public function edit($id)
    {

        $item = User::person()->with('roles')->findOrFail($id);

        return view('users.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $item = User::findOrFail($id);
       
        DB::transaction(function () use ($request, $item) {
            $inputs = $request->except('roles');

            $item->fill($inputs)->save();

            $people = Person::find($item->person_id);
            $people->fill($inputs)->save();

            if ($request->roles <> '') {
                $roles = Role::where('tenant_id', session('tenant')['id'])->pluck('id')->all();
                $item->roles()->whereIn('roles.id', $roles)->detach();
                $item->roles()->attach($request->roles);
            }
        });

        return redirect()->route('users.index')
            ->withStatus('Registro atualizado com sucesso.');
    }

    public function destroy($id)
    {
        $item = User::findOrFail($id);

        if (auth()->id() != $item->id) {
            try {
                $item->people()->delete();
                $item->delete();
                return redirect()->route('users.index')
                    ->withStatus('Registro deletado com sucesso.');
            } catch (\Exception $e) {
                return redirect()->route('user.index')
                    ->withError('Registro vinculado á outra tabela, somente poderá ser excluído se retirar o vinculo.');
            }
        } else {
            return redirect()->route('users.index')
                ->withError('Você não tem permissão para excluir esse usuário.');
        }
    }

}
