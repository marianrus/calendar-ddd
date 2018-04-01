.PHONY: up
up: ## spin up environment
		docker-compose up -d --build

.PHONY: install
install: ## build environment and initialize composer and project dependencies
		docker-compose run --rm php sh -lc 'composer install'

.PHONY: erase
erase: ## stop and delete containers, clean volumes.
		docker-compose stop
		docker-compose rm -v -f

.PHONY: sh
sh: ## gets inside a container, use 's' variable to select a service. make s=php sh
		docker-compose exec $(s) sh -l

.PHONY: db
db: ## recreate database
		docker-compose exec php sh -lc './bin/console d:d:d --force'
		docker-compose exec php sh -lc './bin/console d:d:c'
		docker-compose exec php sh -lc './bin/console doctrine:schema:create'