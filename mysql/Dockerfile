FROM mysql:8.0.23

RUN apt-get update --allow-insecure-repositories && apt-get install -y curl \
&& curl -s https://repo.mysql.com/RPM-GPG-KEY-mysql-2022 | apt-key add -

RUN apt-get update \
 && apt-get install --no-install-recommends -y tzdata\
 && apt-get clean \
 && rm -r /var/lib/apt/lists/*

COPY conf/fb.cnf /etc/mysql/conf.d/
RUN chmod 644 /etc/mysql/conf.d/fb.cnf
