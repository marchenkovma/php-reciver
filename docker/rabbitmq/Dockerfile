ARG RABBITMQ_VERSION

FROM rabbitmq:${RABBITMQ_VERSION}

RUN rabbitmq-plugins enable --offline rabbitmq_management

EXPOSE 4369 5671 5672 15671 15672 25672
