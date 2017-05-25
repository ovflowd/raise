#/bin/bash

SWAGGER_REPLACE="http://petstore.swagger.io/v2/swagger.json"
SWAGGER_UIOT="https://raw.githubusercontent.com/UIoT/RAISe/sbr/docs/swagger.json"

cp -R vendor/swagger-api/swagger-ui/dist/* docs/swagger
sed -i -e "s#$SWAGGER_REPLACE#$SWAGGER_UIOT#g" docs/swagger/index.html docs/swagger/*.js
rm docs/swagger/index.html-e 2> /dev/null
rm docs/swagger/*.js-e 2> /dev/null
