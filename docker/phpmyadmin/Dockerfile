ARG PMA_VERSION

FROM phpmyadmin:${PMA_VERSION}

# Add volume for sessions to allow session persistence
VOLUME /sessions

# We expose phpMyAdmin on port 80
EXPOSE 80