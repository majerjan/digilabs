up:
	docker compose -f .docker/docker-compose.yml up -d --build

down:
	docker compose -f .docker/docker-compose.yml down --volumes

to:
	docker exec -it digilabs bash