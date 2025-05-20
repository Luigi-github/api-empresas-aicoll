<?php

namespace App\Services;

use App\Models\Empresa;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

class EmpresaService
{
    public function listarEmpresas()
    {
        return Empresa::all();
    }

    public function obtenerPorNit($nit)
    {
        return Empresa::where('nit', $nit)->firstOrFail();
    }

    public function crearEmpresa(array $data)
    {
        $validator = Validator::make($data, [
        'nit' => 'required|string|unique:empresas,nit|max:20',
        'nombre' => 'required|string|max:255',
        'direccion' => 'required|string|max:255',
        'telefono' => 'required|string|max:20',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return Empresa::create(array_merge($validator->validated(), ['estado' => 'Activo']));
    }

    public function actualizarEmpresa(string $nit, array $data)
    {
        $empresa = Empresa::where('nit', $nit)->firstOrFail();

        $validator = Validator::make($data, [
        'nombre' => 'nullable|string|max:255',
        'direccion' => 'nullable|string|max:255',
        'telefono' => 'nullable|string|max:20',
        'estado' => 'nullable|in:Activo,Inactivo',
        ]);

        if ($validator->fails()) {
        throw new ValidationException($validator);
        }

        $empresa->update($validator->validated());
        return $empresa;
    }

    public function eliminarEmpresa(string $nit)
    {
        $empresa = Empresa::where('nit', $nit)->firstOrFail();

        if ($empresa->estado !== 'Inactivo') {
        throw new \Exception('Solo se pueden eliminar empresas inactivas.');
        }

        $empresa->delete();
        return true;
    }
}
