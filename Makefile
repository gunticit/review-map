build:
	docker compose build
up all-images:
	docker compose up -d --build
down:
	docker compose down
connect-app:
	docker exec -it app bash
connect-pgsql:
	docker exec -it postgres bash