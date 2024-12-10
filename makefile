DC = docker compose
D = docker
DB = docker build
DR = docker run
EXEC = docker exec -it
APP_CONTAINER = php


ifeq ($(OS),Windows_NT)
    # Windows
    CUR_DIR := $(shell cd)
    VOLUME_PATH := $(subst \,/,$(CUR_DIR))
else
    # Linux, macOS
    CUR_DIR := $(shell pwd)
    VOLUME_PATH := $(CUR_DIR)
endif

FIXER_VERSION ?= 3-php8.3

.PHONY: app app-down app-shell storages-shell app-migrations create-migrate

app:
	${DC} up --build -d

app-down:
	${DC} down

app-php-cs-fixer:
	${D} run -it --rm -v $(VOLUME_PATH):/code ghcr.io/php-cs-fixer/php-cs-fixer:$(FIXER_VERSION) fix src