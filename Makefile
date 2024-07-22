TARGET := $(firstword $(MAKECMDGOALS))
ARGS := $(wordlist 2, $(words $(MAKECMDGOALS)), $(MAKECMDGOALS))

ifneq ($(filter exec in,$(TARGET)),)
$(eval $(ARGS):;@:)
#previous line can't start with tab
	SERVICE := $(if $(ARGS),$(firstword $(ARGS)),php)
	ARGS := $(wordlist 2, $(words $(ARGS)), $(ARGS))
endif


down: stop

exec:
	docker compose exec $(SERVICE) bash

fix:
	docker compose exec php composer cmd:fix

in:
	@$(MAKE) --silent exec $(SERVICE) $(ARGS)

migrate:
	docker compose exec db db/migrations/migrate.sh

restart:
	docker compose restart

start:
	docker compose up --detach

stop:
	docker compose down

test: qa

qa:
	docker compose exec php composer cmd:qa

up: start

.PHONY: exec in restart start stop qa
