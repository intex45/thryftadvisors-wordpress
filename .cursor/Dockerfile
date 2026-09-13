FROM ubuntu:24.04

ENV DEBIAN_FRONTEND=noninteractive

# PHP 8.3 CLI + the extensions WordPress needs, plus a SQLite-backed database
# so no MySQL server is required for local development. WP-CLI drives install.
RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        ca-certificates curl unzip less git \
        php-cli php-sqlite3 php-mysql php-xml php-curl php-mbstring \
        php-gd php-zip php-intl php-bcmath \
    && curl -sSL -o /usr/local/bin/wp \
        https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar \
    && chmod +x /usr/local/bin/wp \
    && rm -rf /var/lib/apt/lists/*

# Match the default Cloud Agent runtime user.
RUN id ubuntu >/dev/null 2>&1 || useradd -m -s /bin/bash ubuntu
USER ubuntu
