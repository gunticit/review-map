build:
	docker compose build
all-images:
	docker compose up -d --build
down:
	docker compose down
exec-app:
	docker exec -it app bash
exec-pgsql:
	docker exec -it pgsql bash