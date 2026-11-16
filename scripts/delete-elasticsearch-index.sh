#!/bin/bash
docker exec -i fb-elastic curl -s -XDELETE "http://localhost:9200/fbsearch"
