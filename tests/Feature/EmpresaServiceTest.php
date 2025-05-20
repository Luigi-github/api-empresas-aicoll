<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Services\EmpresaService;
use App\Models\Empresa;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

class EmpresaServiceTest extends TestCase
{
    use RefreshDatabase;

    protected EmpresaService $empresaService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->empresaService = app(EmpresaService::class);
    }

    /** @test */
    public function puede_crear_una_empresa()
    {
        $empresa = $this->empresaService->crearEmpresa([
            'nit' => '999999999',
            'nombre' => 'Prueba S.A.S',
            'direccion' => 'Calle 123',
            'telefono' => '3200000000',
        ]);

        $this->assertDatabaseHas('empresas', [
            'nit' => '999999999',
            'estado' => 'Activo',
        ]);
    }

    /** @test */
    public function no_puede_crear_empresa_con_nit_duplicado()
    {
        $this->empresaService->crearEmpresa([
            'nit' => '123',
            'nombre' => 'Empresa 1',
            'direccion' => 'Dir',
            'telefono' => '300',
        ]);

        $this->expectException(ValidationException::class);

        $this->empresaService->crearEmpresa([
            'nit' => '123',
            'nombre' => 'Empresa 2',
            'direccion' => 'Dir',
            'telefono' => '300',
        ]);
    }

    /** @test */
    public function puede_obtener_empresa_por_nit()
    {
        $this->empresaService->crearEmpresa([
            'nit' => 'ABC123',
            'nombre' => 'Mi Empresa',
            'direccion' => 'Calle 1',
            'telefono' => '3001234567'
        ]);

        $empresa = $this->empresaService->obtenerPorNit('ABC123');

        $this->assertEquals('Mi Empresa', $empresa->nombre);
    }

    /** @test */
    public function lanza_excepcion_si_empresa_no_existe()
    {
        $this->expectException(ModelNotFoundException::class);
        $this->empresaService->obtenerPorNit('NO_EXISTE');
    }

    /** @test */
    public function puede_actualizar_empresa()
    {
        $this->empresaService->crearEmpresa([
            'nit' => '999',
            'nombre' => 'Original',
            'direccion' => 'Dir',
            'telefono' => '300'
        ]);

        $this->empresaService->actualizarEmpresa('999', [
            'nombre' => 'Actualizado',
            'direccion' => 'Nueva Dir',
            'telefono' => '301',
            'estado' => 'Inactivo'
        ]);

        $this->assertDatabaseHas('empresas', [
            'nit' => '999',
            'nombre' => 'Actualizado',
            'estado' => 'Inactivo'
        ]);
    }


    /** @test */
    public function puede_eliminar_empresa_inactiva()
    {
        $this->empresaService->crearEmpresa([
            'nit' => 'del123',
            'nombre' => 'Borrar',
            'direccion' => 'Dir',
            'telefono' => '300'
        ]);

        $this->empresaService->actualizarEmpresa('del123', [
            'estado' => 'Inactivo'
        ]);

        $this->empresaService->eliminarEmpresa('del123');

        $this->assertDatabaseMissing('empresas', ['nit' => 'del123']);
    }


    /** @test */
    public function no_puede_eliminar_empresa_activa()
    {
        $this->empresaService->crearEmpresa([
            'nit' => 'activa',
            'nombre' => 'Activa',
            'direccion' => 'Dir',
            'telefono' => '300'
        ]);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Solo se pueden eliminar empresas inactivas.');

        $this->empresaService->eliminarEmpresa('activa');
    }

}

