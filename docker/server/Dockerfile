FROM nginx:1.13-alpine

WORKDIR /var/www/html/public

COPY ./site.conf /etc/nginx/conf.d/default.conf
#COPY public ./

# Make container runnable on OpenShift

EXPOSE 8080
