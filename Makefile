DEBIAN_JESSIE_SOURCES_MIRROR?=
DOCKER_REGISTRY?=localhost:5000
MAIN_NAMESPACE?=$(shell git symbolic-ref --short HEAD | sed -e 's/\//-/g;s/_/-/g')
NAMESPACE:=$(shell echo $(MAIN_NAMESPACE) | sed -e 's/\//-/g;s/_/-/g')
TAG?=$(shell git describe --tags --always --match="v*" 2> /dev/null || cat $(CURDIR)/.version 2> /dev/null || echo v0)
PROJECT?=bebeco/bebeco
IMAGE=$(DOCKER_REGISTRY)/$(PROJECT)
IMAGE_TAG=$(IMAGE):$(TAG)
MAIN_BRANCH ?= master
ENVIRONMENT?=staging
# DEPLOY ?= ./deploy.sh
# BUILD ?= ./build.sh
COMPONENTS ?= api:$(TAG) \
			  mysql:5.7 \
              redis:5.0-alpine


all: deploy

deploy:
	$(DEPLOY) $(ENVIRONMENT) $(NAMESPACE) $(DOCKER_REGISTRY) $(COMPONENTS)

build-docker:
	gcloud builds submit --config=cloudbuild.yaml --substitutions=_IMAGE_TAG=$(IMAGE_TAG)

clean-report:
	docker run --rm -v $(PWD)/reports:/tmp $(IMAGE_TAG) sed -i 's/\/var\/www\/bebeco-api\//\/usr\/src\//g' /tmp/coverage.xml

push:
	docker push $(IMAGE_TAG)

namespace:
	echo $(NAMESPACE)

# Clean image
delete:
	docker rmi $(IMAGE_TAG)

branch-name:
	$(shell git symbolic-ref --short HEAD | sed -e 's/\//-/g;s/_/-/g')

# Local development
local:
	docker start bebeco-mysql-development
	symfony server:start

local-stop:
	docker stop bebeco-mysql-development