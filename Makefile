# Vars
stack_name=youl_coin_season
project_url=yc-season.local.barlito.fr
app_container_id = $(shell docker ps --filter name="$(stack_name)_nginx" -q)

# Config paths
config_cs_fixer=vendor/barlito/utils/config/.php-cs-fixer.dist.php
config_phpcs=vendor/barlito/utils/config/phpcs.xml.dist
config_phpmd=vendor/barlito/utils/config/phpmd.xml

# Include all make rules from submodule
include make/entrypoint.mk

###> App commands ###
start-messenger-worker:
	make docker.command exec_params="-t" args="supervisorctl start messenger-consume:*"

stop-messenger-worker:
	make docker.command exec_params="-t" args="supervisorctl stop messenger-consume:*"
###< App commands ###
