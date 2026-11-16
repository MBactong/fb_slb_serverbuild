FROM nginx:stable

ARG TZ
ARG SITE_DOMAIN
ARG CERTBOT
#ARG CERTBOT_EMAIL
#ARG CERTBOT_DOMAIN

RUN echo 'server_tokens off;' > /etc/nginx/conf.d/server_tokens.conf

RUN apt-get update && apt-get install -y cron awstats && rm -rf /var/lib/apt/lists/*

RUN apt-get update \
 && apt-get install --no-install-recommends -y tzdata \
 && apt-get clean \
 && rm -r /var/lib/apt/lists/*

RUN rm /etc/awstats/awstats.conf.local
COPY awstats/awstats.conf.local /etc/awstats/awstats.conf.local
RUN envsubst < /etc/awstats/awstats.conf.local | tee /etc/awstats/awstats.conf.local
RUN mkdir -p /var/www/awstats

RUN echo "*/2 * * * * root export TZ=${TZ}; /usr/share/awstats/tools/awstats_buildstaticpages.pl -update -config=${SITE_DOMAIN} -dir=/var/www/awstats/ > /dev/null 2>&1" >/etc/cron.d/awstats


#RUN if [ "$CERTBOT" = "1" ]; then \
#    apt-get update \
#      && apt-get install -y certbot python-certbot-nginx bash wget openssl \
#      && rm -rf /var/lib/apt/lists/* \
#      && echo "@monthly root certbot renew --webroot -w /var/www/letsencrypt >> /var/log/cron.log 2>&1 && nginx -s reload" >/etc/cron.d/certbot-renew \
#      && crontab /etc/cron.d/certbot-renew \
#; fi

RUN if [ "$CERTBOT" = "1" ]; then \
    apt-get update \
      && apt-get install -y certbot python3-certbot-nginx bash wget openssl \
      && rm -rf /var/lib/apt/lists/* \
      && echo "@monthly root certbot renew --webroot -w /var/www/letsencrypt >> /var/log/cron.log 2>&1 && /usr/sbin/nginx -s reload" >/etc/cron.d/certbot-renew \
      && crontab /etc/cron.d/certbot-renew \
; fi

COPY scripts/certbot.sh /docker-entrypoint.d/01-certbot.sh

RUN chmod 777 /docker-entrypoint.d/01-certbot.sh

RUN mkdir -p /var/www/letsencrypt

RUN service cron start
