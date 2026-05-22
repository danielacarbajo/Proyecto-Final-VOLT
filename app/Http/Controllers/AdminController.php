<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Rutina;
use App\Models\Ejercicio;
use App\Models\Entrenamiento;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * Panel principal del administrador con métricas globales y gráficas.
     */
    public function panel(): View
    {
        $totalUsuarios = Usuario::where('rol_id', 1)->count();
        $totalAdmins = Usuario::where('rol_id', 2)->count();
        $totalRutinas = Rutina::count();
        $totalEjercicios = Ejercicio::count();
        $totalEntrenamientos = Entrenamiento::count();

        $entrenamientosMes = Entrenamiento::whereMonth('fecha_entrenamiento', now()->month)
            ->whereYear('fecha_entrenamiento', now()->year)
            ->count();

        $usuariosRecientes = Usuario::with('rol')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $entrenamientosRecientes = Entrenamiento::with(['usuario', 'rutina'])
            ->orderBy('fecha_entrenamiento', 'desc')
            ->take(5)
            ->get();

        // ====================================================
        // DATOS PARA LAS GRÁFICAS (últimos 6 meses)
        // ====================================================

        $meses = ['enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre'];

        $etiquetasMeses = [];
        $usuariosPorMes = [];
        $entrenamientosPorMes = [];

        for ($i = 5; $i >= 0; $i--) {
            $fecha = Carbon::now()->subMonths($i);
            $anyo = $fecha->year;
            $mes = $fecha->month;

            $etiquetasMeses[] = $meses[$mes - 1] . ' ' . $anyo;

            $usuariosPorMes[] = Usuario::whereYear('fecha_creacion', $anyo)
                ->whereMonth('fecha_creacion', $mes)
                ->count();

            $entrenamientosPorMes[] = Entrenamiento::whereYear('fecha_entrenamiento', $anyo)
                ->whereMonth('fecha_entrenamiento', $mes)
                ->count();
        }

        return view('admin.panel', compact(
            'totalUsuarios',
            'totalAdmins',
            'totalRutinas',
            'totalEjercicios',
            'totalEntrenamientos',
            'entrenamientosMes',
            'usuariosRecientes',
            'entrenamientosRecientes',
            'etiquetasMeses',
            'usuariosPorMes',
            'entrenamientosPorMes'
        ));
    }

    /**
     * Listado completo de usuarios con búsqueda, filtro por rol y paginación.
     */
    public function usuarios(Request $request): View
    {
        $query = Usuario::with('rol');

        if ($request->filled('buscar')) {
            $busqueda = $request->buscar;
            $query->where(function ($q) use ($busqueda) {
                $q->where('nombre', 'like', "%{$busqueda}%")
                  ->orWhere('email', 'like', "%{$busqueda}%");
            });
        }

        if ($request->filled('rol')) {
            $query->where('rol_id', $request->rol);
        }

        $totalGeneral = Usuario::count();

        $usuarios = $query->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.usuarios.index', compact('usuarios', 'totalGeneral'));
    }

    /**
     * Muestra el formulario para crear un nuevo usuario desde el admin.
     */
    public function crearUsuarioForm(): View
    {
        return view('admin.usuarios.create');
    }

    /**
     * Guarda el nuevo usuario creado desde el admin.
     */
    public function crearUsuario(Request $request): RedirectResponse
    {
        $datos = $request->validate([
            'nombre' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150', 'unique:usuarios,email'],
            'contrasena' => ['required', 'string', 'min:6', 'confirmed'],
            'rol_id' => ['required', 'integer', 'in:1,2'],
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico no es válido.',
            'email.unique' => 'Ya existe una cuenta con ese correo.',
            'contrasena.required' => 'La contraseña es obligatoria.',
            'contrasena.min' => 'La contraseña debe tener al menos 6 caracteres.',
            'contrasena.confirmed' => 'Las contraseñas no coinciden.',
            'rol_id.required' => 'Selecciona un rol.',
            'rol_id.in' => 'El rol seleccionado no es válido.',
        ]);

        Usuario::create([
            'nombre' => $datos['nombre'],
            'email' => $datos['email'],
            'contrasena' => $datos['contrasena'],
            'rol_id' => $datos['rol_id'],
            'activo' => true,
            'fecha_creacion' => now(),
        ]);

        return redirect()->route('admin.usuarios')
            ->with('exito', "Usuario {$datos['nombre']} creado correctamente.");
    }

    /**
     * Muestra el detalle de un usuario con sus estadísticas.
     */
    public function verUsuario(Usuario $usuario): View
    {
        $usuario->load('rol');

        $estadisticas = [
            'rutinas' => $usuario->rutinas()->count(),
            'ejercicios' => $usuario->ejercicios()->count(),
            'entrenamientos' => $usuario->entrenamientos()->count(),
            'entrenamientosMes' => $usuario->entrenamientos()
                ->whereMonth('fecha_entrenamiento', now()->month)
                ->whereYear('fecha_entrenamiento', now()->year)
                ->count(),
            'primerEntreno' => $usuario->entrenamientos()
                ->orderBy('fecha_entrenamiento', 'asc')
                ->first()?->fecha_entrenamiento,
            'ultimoEntreno' => $usuario->entrenamientos()
                ->orderBy('fecha_entrenamiento', 'desc')
                ->first()?->fecha_entrenamiento,
        ];

        $entrenamientosPorMes = $usuario->entrenamientos()
            ->selectRaw('YEAR(fecha_entrenamiento) as anyo, MONTH(fecha_entrenamiento) as mes, COUNT(*) as total')
            ->groupBy('anyo', 'mes')
            ->orderBy('anyo', 'desc')
            ->orderBy('mes', 'desc')
            ->take(6)
            ->get();

        $ultimosEntrenamientos = $usuario->entrenamientos()
            ->with('rutina')
            ->orderBy('fecha_entrenamiento', 'desc')
            ->take(5)
            ->get();

        return view('admin.usuarios.show', compact(
            'usuario',
            'estadisticas',
            'ultimosEntrenamientos',
            'entrenamientosPorMes'
        ));
    }

    /**
     * Cambia el rol de un usuario (usuario ↔ administrador).
     */
    public function cambiarRol(Usuario $usuario): RedirectResponse
    {
        if ($usuario->id === auth()->id()) {
            return redirect()->route('admin.usuarios.show', $usuario)
                ->with('error', 'No puedes cambiar tu propio rol.');
        }

        $usuario->rol_id = $usuario->rol_id === 2 ? 1 : 2;
        $usuario->save();

        $nuevoRol = $usuario->rol_id === 2 ? 'administrador' : 'usuario';

        return redirect()->route('admin.usuarios.show', $usuario)
            ->with('exito', "Rol de {$usuario->nombre} cambiado a {$nuevoRol}.");
    }

    /**
     * Resetea la contraseña de un usuario.
     */
    public function resetearContrasena(Request $request, Usuario $usuario): RedirectResponse
    {
        if ($usuario->id === auth()->id()) {
            return redirect()->route('admin.usuarios.show', $usuario)
                ->with('error', 'Para cambiar tu propia contraseña usa la sección de perfil.');
        }

        $datos = $request->validate([
            'contrasena_nueva' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'contrasena_nueva.required' => 'La nueva contraseña es obligatoria.',
            'contrasena_nueva.min' => 'La nueva contraseña debe tener al menos 6 caracteres.',
            'contrasena_nueva.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        $usuario->update([
            'contrasena' => $datos['contrasena_nueva'],
        ]);

        return redirect()->route('admin.usuarios.show', $usuario)
            ->with('exito', "Contraseña de {$usuario->nombre} reseteada correctamente.");
    }

    /**
     * Bloquea o desbloquea una cuenta de usuario.
     * Si está activa la pone como inactiva, y viceversa.
     */
    public function cambiarEstado(Usuario $usuario): RedirectResponse
    {
        // No permitir bloquearse a uno mismo.
        if ($usuario->id === auth()->id()) {
            return redirect()->route('admin.usuarios.show', $usuario)
                ->with('error', 'No puedes bloquear tu propia cuenta.');
        }

        $usuario->activo = !$usuario->activo;
        $usuario->save();

        $accion = $usuario->activo ? 'desbloqueada' : 'bloqueada';

        return redirect()->route('admin.usuarios.show', $usuario)
            ->with('exito', "Cuenta de {$usuario->nombre} {$accion} correctamente.");
    }

    /**
     * Elimina un usuario (junto con todos sus datos por las FK cascade).
     */
    public function eliminarUsuario(Usuario $usuario): RedirectResponse
    {
        if ($usuario->id === auth()->id()) {
            return redirect()->route('admin.usuarios')
                ->with('error', 'No puedes eliminar tu propia cuenta de administrador.');
        }

        $nombre = $usuario->nombre;
        $usuario->delete();

        return redirect()->route('admin.usuarios')
            ->with('exito', "Usuario {$nombre} eliminado correctamente.");
    }
}
