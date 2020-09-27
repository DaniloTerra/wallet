WALLET_DEV_DOCKER_IMAGE = wallet_api:latest
WALLET_DEV_DOCKER_RUN = docker run --rm -v ${PWD}:${PWD} -w ${PWD} ${WALLET_DEV_DOCKER_IMAGE}

# Docker
docker-build-dev-image:
	- @docker build --target dev -t ${WALLET_DEV_DOCKER_IMAGE} .

# Dependencies
dependencies-install:
	- @${WALLET_DEV_DOCKER_RUN} composer install

dependencies-update:
	- @${WALLET_DEV_DOCKER_RUN} composer update

# Tests
test-unit:
	- @${WALLET_DEV_DOCKER_RUN} composer test-unit

test-unit-coverage:
	- @${WALLET_DEV_DOCKER_RUN} composer test-unit-coverage

test-unit-mutation: test-unit-coverage
	- @${WALLET_DEV_DOCKER_RUN} composer test-unit-mutation

test-file:
	- @${WALLET_DEV_DOCKER_RUN} php vendor/bin/codecept run ${FILE}

test-file-coverage:
	- @${WALLET_DEV_DOCKER_RUN} php vendor/bin/codecept run ${FILE} --coverage --coverage-xml=clover.xml --coverage-html=html

# Quality Tools
php-stan:
	- @${WALLET_DEV_DOCKER_RUN} composer php-stan

php-cpd:
	- @${WALLET_DEV_DOCKER_RUN} composer php-cpd

php-md:
	- @${WALLET_DEV_DOCKER_RUN} composer php-md

php-cs:
	- @${WALLET_DEV_DOCKER_RUN} composer php-cs

php-dephpend:
	- @${WALLET_DEV_DOCKER_RUN} composer php-dephpend

# Hook
pre-push: php-stan php-cpd php-md php-cs php-dephpend test-unit-coverage test-unit-mutation

# API
api-up:
	- @docker-compose up -d

api-down:
	- @docker-compose down