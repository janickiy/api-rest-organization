OS := $(shell uname)

APP_CONTAINER := backend
ENV_FILE := .env

ifeq ($(OS), Darwin)
  CP_CMD := cp -n
else
  CP_CMD := cp -u
endif

start:
	@echo "🔄 Starting the project..."
	$(CP_CMD) .env.example $(ENV_FILE) || true
	@docker-compose up -d
	@docker-compose exec $(APP_CONTAINER) composer install
	@docker-compose exec $(APP_CONTAINER) php artisan key:generate
	@docker-compose exec $(APP_CONTAINER) php artisan migrate --seed
	@echo "✅ Project started successfully!"

up:
	@echo "🚀 Starting containers..."
	@docker-compose up -d
	@echo "✅ Containers started!"

down:
	@echo "🛑 Stopping containers..."
	@docker-compose down
	@echo "✅ Containers stopped!"

build:
	@echo "🔧 Building containers..."
	@docker-compose build
	@echo "✅ Build complete!"

restart:
	@echo "🔄 Restarting containers..."
	@docker-compose down && docker-compose up -d
	@echo "✅ Containers restarted!"

logs:
	@echo "📜 Showing logs..."
	@docker-compose logs -f

composer-install:
	@echo "📦 Installing Composer dependencies..."
	@docker-compose exec $(APP_CONTAINER) composer install
	@echo "✅ Dependencies installed!"

migrate:
	@echo "🛠️ Running migrations..."
	@docker-compose exec $(APP_CONTAINER) php artisan migrate
	@echo "✅ Migrations complete!"

seed:
	@echo "🌱 Running seeders..."
	@docker-compose exec $(APP_CONTAINER) php artisan db:seed
	@echo "✅ Seeding complete!"

permissions:
	@echo "🔑 Fixing permissions..."
	@sudo chmod -R 777 storage bootstrap/cache
	@echo "✅ Permissions fixed!"

bash:
	@echo "🐚 Accessing container bash..."
	@docker-compose exec $(APP_CONTAINER) bash

test:
	@echo "🧪 Running tests..."
	@docker-compose exec $(APP_CONTAINER) php artisan test
	@echo "✅ Tests complete!"
