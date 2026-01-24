.PHONY: cub
cub:
	docker compose -f docker-compose.yaml -f docker-compose-dev.yaml up --build

.PHONY: cub-prod
cub-prod:
	docker compose -f docker-compose.yaml -f docker-compose-prod.yaml up --build

.PHONY: cd
cd:
	docker compose -f docker-compose.yaml -f docker-compose-dev.yaml down

.PHONY: cd-prod
cd-prod:
	docker compose -f docker-compose.yaml -f docker-compose-prod.yaml down
