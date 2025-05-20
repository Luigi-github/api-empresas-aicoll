<?php

namespace App\Http\Controllers;

use App\Services\EmpresaService;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

class EmpresaController extends Controller
{
    protected $empresaService;

    public function __construct(EmpresaService $empresaService)
    {
        $this->empresaService = $empresaService;
    }

    public function index()
    {
        return response()->json($this->empresaService->listarEmpresas());
    }

    public function show($nit)
    {
        try {
            $empresa = $this->empresaService->obtenerPorNit($nit);
            return response()->json($empresa);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Empresa no encontrada'], 404);
        }
    }

    public function store(Request $request)
    {
        try {
            $empresa = $this->empresaService->crearEmpresa($request->all());
            return response()->json($empresa, 201);
        } catch (ValidationException $e) {
            return response()->json(['error' => 'Validación fallida', 'messages' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al crear la empresa'], 500);
        }
    }

    public function update(Request $request, $nit)
    {
        try {
            $empresa = $this->empresaService->actualizarEmpresa($nit, $request->all());
            return response()->json($empresa);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Empresa no encontrada'], 404);
        } catch (ValidationException $e) {
            return response()->json(['error' => 'Validación fallida', 'messages' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al actualizar la empresa'], 500);
        }
    }

    public function destroy($nit)
    {
        try {
            $this->empresaService->eliminarEmpresa($nit);
            return response()->json(['message' => 'Empresa eliminada correctamente']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Empresa no encontrada'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 403);
        }
    }
}


