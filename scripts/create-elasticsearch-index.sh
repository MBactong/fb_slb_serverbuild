#!/bin/bash
docker exec -i fb-elastic curl -s -XPUT -H "Content-Type: application/json" "http://localhost:9200/fbsearch" -d @/fbsearch-settings.json
