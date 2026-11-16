#!/bin/bash -e
if [[ -z "${CERTBOT}" ||  "${CERTBOT}" = "0" ]]
then
  echo "CERTBOT not run"
  exit 0
fi

if [[ -z "${CERTBOT_EMAIL}" ]]
then
  echo "CERTBOT_EMAIL needs to be set"
  exit 1
fi

if [[ -z "${CERTBOT_DOMAIN}" ]]
then
  echo "CERTBOT_DOMAIN needs to be set"
  exit 1
fi


(
flock -s 200

if [ ! -e /etc/letsencrypt/live ]; then
  # see https://security.stackexchange.com/a/95184/26281
  openssl dhparam -dsaparam -out /etc/letsencrypt/dhparam.pem 4096 > /dev/null 2>&1 &
  #certbot -n -q certonly --standalone --staging --email ${CERTBOT_EMAIL} --agree-tos -d ${CERTBOT_DOMAIN}
  certbot -n certonly --standalone --email ${CERTBOT_EMAIL} --agree-tos -d ${CERTBOT_DOMAIN}
  wait
fi

) 200>/etc/letsencrypt/lock

# run cron
service cron start

