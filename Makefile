RUN_ARGS := $(wordlist 2,$(words $(MAKECMDGOALS)),$(MAKECMDGOALS))

console:
	apps/StudentTracker/bin/console $(RUN_ARGS)

mysql:
	docker-compose up -d student_corner.mysql

up:
	docker-compose up -d

down:
	docker-compose down

clear:
	make down && rm -rf var

start-local:
	php -S localhost:8030 apps/StudentTracker/public/index.php

action:
	echo argument is $(argument)
