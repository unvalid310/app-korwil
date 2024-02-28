<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sekolah;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class OperatorController extends Controller
{
    use HasRoles;
    //
    public function __construct()
    {
        $this->middleware('permission:view operator', ['only' => ['index']]);
        $this->middleware('permission:create operator', ['only' => ['add']]);
        $this->middleware('permission:update operator', ['only' => ['update']]);
        $this->middleware('permission:delete operator', ['only' => ['delete']]);
    }

    public function index() {
        $operator = User::getOperator();
        return view('pages.operator.daftar-operator')->with(['operator' => $operator]);
    }

    public function add() {
        $sekolah = Sekolah::get();
        return view('pages.operator.tambah-operator')->with(['sekolah' => $sekolah]);
    }

    public function update($id_operator) {
        $sekolah = Sekolah::get();
        $operator = User::where(['users.id' => $id_operator])->first();
        if($operator) {
            return view('pages.operator.update-operator')->with(['operator' => $operator, 'sekolah' => $sekolah]);
        } else {
            return redirect()->to('/operator');
        }
    }

    public function save(Request $request) {
        $response['success'] = true;
        $response['message'] = '';
        $response['data'] = [];

        $operator = User::where('email', $request->email)->get();
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'id_sekolah' => $request->id_sekolah,
        ];

        if(count($operator) == 0) {
            $sekolah = User::where('id_sekolah', $request->id_sekolah)->first();
            if ($sekolah) {
                # code...
                $response['success'] = false;
                $response['message'] = 'Operator sekolah sudah ada.';
                $response['data'] = $operator;

                return response()->json($response, 200);
            }

            $save = User::factory()->create($data);

            $save->assignRole('operator');

            if($save) {
                $response['message'] = 'Data berhasil disimpan.';
                $response['data'] = $roles;

                return response()->json($response, 200);
            } else {
                $response['success'] = false;
                $response['message'] = 'Tidak dapat menyimpan data.';
                $response['data'] = $operator;

                return response()->json($response, 200);

            }
        } else {
            $response['success'] = false;
            $response['message'] = 'Email operator sudah ada.';

            return response()->json($response, 200);
        }
    }

    public function edit(Request $request) {
        $response['success'] = true;
        $response['message'] = '';
        $response['data'] = [];

        $id_oeprator = $request->id_operator;
        $email = $request->email;
        $name = $request->name;
        $id_sekolah = $request->id_sekolah;
        $save = User::where(['id' => $id_oeprator])->update([
            'name' => $name,
            'email' => $email,
            'id_sekolah' => $id_sekolah
        ]);

        if($save) {
            $response['success'] = true;
            $response['message'] = 'Data berhasil disimpan.';

            return response()->json($response, 200);
        } else {
            $response['success'] = false;
            $response['message'] = 'Tidak dapat menyimpan data.';

            return response()->json($response, 200);
        }
    }

    public function reset_password(Request $request) {
        $id_operator = $request->id_operator;
        $password = bcrypt($request->password);

        $save = User::where(['id' => $id_operator])->update(['password' => $password]);

        if($save) {
            $response['success'] = true;
            $response['message'] = 'Password berhasil diubah.';

            return response()->json($response, 200);
        } else {
            $response['success'] = false;
            $response['message'] = 'Tidak dapat mengubah password.';

            return response()->json($response, 200);
        }
    }

    public function delete(Request $request) {
        $id_operator = $request->id_operator;

        $delete = User::where('id', $id_operator)
            ->first()
            ->delete();

        if ($delete) {
            return response()
                ->json(
                    [
                        'success' => true,
                        'message' => 'Data operator berhasil dihapus.',
                    ],
                    200,
                );
        } else {
            return response()
                ->json(
                    [
                        'success' => false,
                        'message' => 'Data operator gagal dihapus.',
                    ],
                    200,
                );
        }
    }
}
