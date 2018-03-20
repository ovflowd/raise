FROM couchbase/server

EXPOSE 8091 8092 8093 11210

ADD couchbase-init.sh /
ADD .env /

RUN sed -i 's/\r$//' /couchbase-init.sh
RUN sed -i 's/\r$//' /.env
RUN bash /couchbase-init.sh