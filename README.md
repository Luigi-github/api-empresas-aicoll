# API de Gestión de Empresas - Desafío Técnico Aicoll

Este proyecto es una API RESTful desarrollada con **Laravel 10** para gestionar empresas. Forma parte del desafío técnico propuesto por Aicoll y cumple con los requisitos funcionales, técnicos y de calidad del código solicitados.

---

## 🚀 Funcionalidad

La API permite:

- Crear nuevas empresas (con estado "Activo" por defecto)
- Consultar todas las empresas
- Consultar empresa por NIT
- Actualizar datos de una empresa
- Eliminar empresas si están inactivas

---

## 🧱 Estructura del Proyecto

### Patrón de Diseño: Service

El proyecto utiliza el **patrón de diseño Service Layer** para separar la lógica de negocio del controlador:

- `EmpresaService.php`: Contiene toda la lógica relacionada con la gestión de empresas.
- `EmpresaController.php`: Se encarga de manejar las solicitudes HTTP y delegar la lógica al servicio.

Este patrón facilita:
- Reusabilidad de la lógica
- Mejor organización del código
- Facilidad para pruebas unitarias

---

## 🔐 Validaciones

Se usan **Form Requests** (`EmpresaRequest`) para validar:

- NIT: requerido, string, único
- Nombre: requerido, string, máx 255
- Dirección: requerido, string
- Teléfono: requerido, string
- Estado: requerido en actualización, uno de `Activo` o `Inactivo`

---

## 🛠️ Manejo de errores y excepciones

El proyecto implementa manejo robusto de errores mediante:

- **Excepciones personalizadas**
  - `EmpresaNotFoundException`
  - `EmpresaInactivaException`
  - `EmpresaActivaException`

- **HTTP responses apropiadas**
  - 404 para empresa no encontrada
  - 422 para validaciones fallidas
  - 400 para reglas de negocio violadas (ej. intentar borrar empresa activa)

Todas las excepciones se controlan desde el controlador con respuestas claras en formato JSON.

---

## ✅ Requisitos cumplidos

| Requisito                                       | Estado  |
|------------------------------------------------|---------|
| Crear empresa con estado activo por defecto     | ✅      |
| Validar NIT único                               | ✅      |
| Validaciones de tipo, longitud, valores         | ✅      |
| Laravel + PHP                                   | ✅      |
| Uso de patrón Service                           | ✅      |
| Manejo de errores con excepciones personalizadas| ✅      |
| Subida a repositorio público                    | ✅      |
| Pruebas unitarias con PHPUnit                   | ✅      |

---

## 🧪 Pruebas Unitarias

Se desarrollaron pruebas para validar los siguientes casos:

- ✅ Puede crear una empresa
- ✅ No puede crear empresa con NIT duplicado
- ✅ Puede obtener empresa por NIT
- ✅ Lanza excepción si empresa no existe
- ✅ Puede actualizar empresa
- ✅ Puede eliminar empresa inactiva
- ✅ No puede eliminar empresa activa (lógica de negocio)

Ejecutar con:

```bash
php artisan test
```

---

## 📡 Endpoints de la API

| Método | Endpoint              | Descripción                         |
|--------|------------------------|-------------------------------------|
| POST   | /api/empresas          | Crear nueva empresa                 |
| GET    | /api/empresas          | Obtener todas las empresas          |
| GET    | /api/empresas/{nit}    | Obtener empresa por NIT             |
| PUT    | /api/empresas/{nit}    | Actualizar empresa por NIT          |
| DELETE | /api/empresas/{nit}    | Eliminar empresa (solo si inactiva) |

---

## 🛠️ Instalación y ejecución local

1. Clona el repositorio:
   ```bash
   git clone https://github.com/Luigi-github/api-empresas-aicoll.git
   cd api-empresas-aicoll
   ```

2. Instala dependencias:
   ```bash
   composer install
   ```

3. Configura el entorno:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. Usa SQLite para pruebas locales o configura tu base de datos en `.env`:
   ```
   DB_CONNECTION=sqlite
   DB_DATABASE=/ruta/a/database.sqlite
   ```

5. Ejecuta migraciones:
   ```bash
   php artisan migrate
   ```

6. Corre el servidor:
   ```bash
   php artisan serve
   ```

---

## 💡 Notas Finales

Este proyecto demuestra buenas prácticas como:

- Arquitectura limpia (Service Layer)
- Código estructurado y legible
- Separación de responsabilidades
- Pruebas unitarias completas
- Manejo de errores controlado
- Validaciones robustas

---

## 🧑‍💻 Autor

Desarrollado por **Luigi Fernando Barraza Di Filippo** como parte del proceso técnico de Aicoll.
