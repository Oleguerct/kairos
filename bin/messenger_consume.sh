#!/bin/bash

# Wait to postgress and other containers to start
sleep 15

symfony console messenger:consume async