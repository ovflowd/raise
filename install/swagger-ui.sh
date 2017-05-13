#!/bin/bash

SWAGGER_REPLACE="http://petstore.swagger.io/v2/swagger.json"
SWAGGER_UIOT="https://raw.githubusercontent.com/sant0ro/RAISe/sbr/docs/swagger.json"

cp -r vendor/swagger-api/swagger-ui/dist/* docs/swagger
sed -i -e "s#$SWAGGER_REPLACE#$SWAGGER_UIOT#g" docs/swagger/index.html
rm docs/swagger/index.html-e