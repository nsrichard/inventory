# Yii2 Inventory

Demo de un proyecto para la Gestión de inventario

## Requisitos

- Docker
- Docker Compose
- Composer (solo para la instalación inicial, opcional)

---

## Instalación

1. Clona este repositorio:

   ```bash
   git clone https://github.com/nsrichard/inventory.git
   cd inventory

   ```

2. Instala Yii 2 en la carpeta src/ (solo si no está instalado):

   ```bash
   cd src
   docker compose run --rm app composer create-project --prefer-dist yiisoft/yii2-app-basic .

   ```

3. Vuelve a la raíz y levanta el entorno:

   ```bash
   docker compose up -d --build

   ```

4. Instalar dependencias PHP

   ```bash
   docker compose exec app composer install

   ```

5. Correr migraciones

   ```bash
   docker compose exec app php yii migrate

   ```

6. Ejecutar las pruebas unitarias

   ```bash
   docker compose exec app vendor/bin/codecept run unit
   docker compose exec app vendor/bin/codecept run functional

   ```

7. Accede a la aplicación en: http://localhost:8080
