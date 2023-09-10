### Vars
exec_params=-it

### Development rules

docker.deploy:
	docker-compose pull
	docker stack deploy -c docker-compose.yml $(stack_name)

docker.undeploy:
	docker stack rm $(stack_name)

docker.deploy.ci:
	docker-compose pull
	docker-compose -p $(stack_name) -f docker-compose.yml -f docker-compose-ci.yml up -d

docker.undeploy.ci:
	docker-compose -p $(stack_name) down

docker.wait_stack:
	until $$(curl -s "http://$(project_url)/" | grep -q "Welcome to Symfony") ; do \
    	printf '.' ; \
    	sleep 0.5 ; \
    done

docker.bash:
	docker exec $(exec_params) $(app_container_id) bash

docker.command:
	docker exec $(exec_params) $(app_container_id) bash -c "$(args)"