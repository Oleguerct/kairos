#!/bin/bash

# Wait to postgress and other containers to start
sleep 5
symfony console messenger:stop-workers
symfony console messenger:consume async