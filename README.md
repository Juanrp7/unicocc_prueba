# 🧩 Prueba Técnica — Unico CC (Laravel + PostgreSQL + Vue 3)

Este repositorio contiene el desarrollo completo de la **Prueba Técnica**.

---

## ⚙️ Requisitos previos

| Recurso | Versión mínima | Descripción |
|----------|----------------|--------------|
| PHP | 8.2 | Requerido para Laravel |
| Composer | 2.6 | Gestión de dependencias PHP |
| PostgreSQL | 14 | Base de datos relacional |
| Node.js | 18 | Entorno para Vite y Vue |
| npm | 9 | Gestión de dependencias JS |
| Git | -- | Control de versiones |

---

## 🚀 Instalación y configuración

### 1️⃣ Clonar el repositorio

```bash
git clone https://github.com/Juanrp7/unicocc_prueba.git
cd unicocc_prueba
```

---

### 2️⃣ Configurar el **backend**

```bash
cd back
composer install
```

```env
APP_NAME=PruebaTecnica
APP_ENV=local
APP_KEY=base64:CcAW2hc9JUZvLjVSLjGj6+fm82hwP77AeQgGfxXLpTk=
APP_DEBUG=true
APP_URL=http://localhost:8000

LOG_CHANNEL=stack
LOG_LEVEL=debug

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=pruebaunico
DB_USERNAME=postgres
DB_PASSWORD=unico12345

CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync

# Permitir CORS
SANCTUM_STATEFUL_DOMAINS=localhost:5173
SESSION_DOMAIN=localhost

```

Luego ejecuta los siguientes comandos:

```bash
php artisan key:generate
php artisan migrate
php artisan db:seed       
php artisan serve          # Inicia en http://localhost:8000
```

---

### 3️⃣ Configurar el **frontend**

```bash
cd ../front
npm install
```

Crea el archivo `.env` en el directorio `/front` con el siguiente contenido:

```env
VITE_API_URL=http://localhost:8000/api
```

Inicia el servidor de desarrollo:

```bash
npm run dev
```

El proyecto estará disponible en  
👉 `http://localhost:5173`

---

## 🧠 Descripción general del sistema


**Endpoints principales:**
| Método | Ruta | Descripción |
|--------|------|--------------|
| `GET` | `/api/pokemon` | Lista de Pokémon con filtros y paginación |
| `GET` | `/api/pokemon/{id}` | Detalle de un Pokémon |
| `POST` | `/api/favorites` | Guarda un Pokémon como favorito |

---
