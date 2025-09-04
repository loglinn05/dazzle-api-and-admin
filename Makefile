.PHONY: cub
cub:
	docker compose up --build

.PHONY: cd
cd:
	docker compose down

.PHONY: db
db:
	docker container exec -it dazzle-db mariadb -u example -p"password"
