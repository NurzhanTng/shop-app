.PHONY: help install up down restart logs backend frontend db clean

help: ## Показать это сообщение
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-20s\033[0m %s\n", $$1, $$2}'

install: ## Первая установка проекта
	@echo "🚀 Установка проекта..."
	cp backend/.env.example backend/.env
	cp frontend/.env.example frontend/.env
	docker-compose build
	docker-compose up -d
	@echo "✅ Проект установлен!"
	@echo "Frontend: http://localhost:5173"
	@echo "Backend: http://localhost:8000"

up: ## Запустить все контейнеры
	@echo "🚀 Запуск контейнеров..."
	docker-compose up -d
	@echo "✅ Контейнеры запущены!"

down: ## Остановить все контейнеры
	@echo "🛑 Остановка контейнеров..."
	docker-compose down
	@echo "✅ Контейнеры остановлены!"

restart: ## Перезапустить все контейнеры
	@echo "🔄 Перезапуск контейнеров..."
	docker-compose restart
	@echo "✅ Контейнеры перезапущены!"

logs: ## Показать логи всех контейнеров
	docker-compose logs -f

backend: ## Показать логи backend
	docker-compose logs -f backend

frontend: ## Показать логи frontend
	docker-compose logs -f frontend

db: ## Показать логи базы данных
	docker-compose logs -f db

clean: ## Удалить все контейнеры и volumes
	@echo "🧹 Очистка..."
	docker-compose down -v
	@echo "✅ Очистка завершена!"

rebuild: ## Пересобрать и запустить контейнеры
	@echo "🔨 Пересборка контейнеров..."
	docker-compose down
	docker-compose build --no-cache
	docker-compose up -d
	@echo "✅ Пересборка завершена!"

shell-backend: ## Войти в контейнер backend
	docker-compose exec backend bash

shell-frontend: ## Войти в контейнер frontend
	docker-compose exec frontend sh

migrate: ## Запустить миграции
	docker-compose exec backend php artisan migrate

migrate-fresh: ## Пересоздать БД с seed данными
	docker-compose exec backend php artisan migrate:fresh --seed

composer-install: ## Установить composer зависимости
	docker-compose exec backend composer install

npm-install: ## Установить npm зависимости
	docker-compose exec frontend npm install

test-backend: ## Запустить backend тесты
	docker-compose exec backend php artisan test

test-frontend: ## Запустить frontend тесты
	docker-compose exec frontend npm run test