<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Roles;

class UsersController extends Controller
{
	public function index()
	{
		$usuarios=User::where('id','<>','1')->paginate(20);
		return view('usuario.index')->with('usuarios',$usuarios);
	}
	public function create()
	{
		$roles=Roles::orderby('id')->get();
		return view('usuario.create')->with("roles",$roles);
	}
	public function store(Request $request)
	{
		$rules = [
			'email' => 'required|email|unique:users,email',
			'password' => 'required|string|min:6|confirmed',
		];
		try {
			$validator = \Validator::make($request->all(), $rules);
			if ($validator->fails()){
				return back()->withErrors($validator)->withInput();
			}
			//dd($request);
			$usuario               = new User($request->all());
			$usuario->name         = $request["name"];
			$usuario->email        = $request["email"];
			$usuario->password     = $request["password"];
            $usuario->rol_id       = $request["rol_id"];
			$usuario->alto_nivel   = $request["altonivel"];
			$usuario->contratados  = $request["contratados"];	
			$usuario->empleados    = $request["empleados"];	
            $usuario->obreros      = $request["obreros"];
            $usuario->jubilados    = $request["jubilados"];		
            $usuario->save();
			return redirect()->route('usuarios.edit', $usuario->id)->with("notificacion","Se ha guardado correctamente su información");
		} catch (Exception $e) {
			\Log::info('Error creating item: '.$e);
			return \Response::json(['created' => false], 500);
		}
	}
	public function show($id)
	{
        //
	}
	public function edit($id)
	{
		$roles=Roles::orderby('id')->get();
		$usuario=User::find($id);
		return view('usuario.edit')->with('usuario',$usuario)
		->with('roles',$roles);
	}
	public function update(Request $request, $id)
	{
		$rules = [
			'email' => 'required|email',
		];
		try {
			$validator = \Validator::make($request->all(), $rules);
			if ($validator->fails()){
				return back()->withErrors($validator)->withInput();
			}
			$usuarios = User::find($id);
            $usuarios->name        = $request->name;
            $usuarios->rol_id      = $request->rol_id;
            $usuarios->alto_nivel  = $alto_nivel;
            $usuarios->contratados = $request->contratados;
            $usuarios->empleados   = $request->empleados;
            $usuarios->obreros     = $request->obreros;
            $usuarios->jubilados   = $request->jubilados;
            $usuarios->save();
			return redirect()->route('usuarios.edit', $id)->with("notificacion","Se ha guardado correctamente su información");
		} catch (Exception $e) {
			\Log::info('Error creating item: '.$e);
			return \Response::json(['created' => false], 500);
		}
	}
	public function destroy($id)
	{
		
		try{
			User::find($id)->delete();
			return redirect()->route('usuarios.index');
		} catch (\Illuminate\Database\QueryException $e) {
			return back()->with("notificacion_error","Se ha producido un error, es probable que exista contenido relacionado a este registro que impide que se elimine");
		}
	}
	public function cambiar($id)
	{
        //dd($id);
		$usuario=User::find($id);
		return view('usuario.cambiarp')->with('usuario',$usuario);
	}
	public function update_password(Request $request, $valor)
	{
			//dd($valor);
			$id=$valor;
			$password = bcrypt($request->password);
			$usuarios=User::find($id);
            $usuarios->password = $password;

            $usuarios->save();
            return redirect()->route('usuarios.index')->with("notificacion","Se ha guardado correctamente su información");            
	}
}