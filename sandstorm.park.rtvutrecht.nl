server {
    listen 80;
    listen [::]:80;
    server_name sandstorm.park.rtvutrecht.nl; 
    return 301 https://sandstorm.park.rtvutrecht.nl$request_uri;
}

server {

    listen 443 ssl;
    server_name sandstorm.park.rtvutrecht.nl;
    index index.php index.htm index.html;
    ssl_certificate /etc/ssl/sandstorm.park.rtvutrecht.nl/sandstorm.park.rtvutrecht.nl.crt;
    ssl_certificate_key /etc/ssl/sandstorm.park.rtvutrecht.nl/sandstorm.park.rtvutrecht.nl.key;
    ssl_session_timeout 1d;
    ssl_session_tickets off;
    ssl_protocols  TLSv1.2;
    ssl_ciphers ECDH-ECDSA-AES128-GCM-SHA256:ECDH-ECDSA-AES128-SHA:ECDH-ECDSA-AES128-SHA256:ECDH-ECDSA-AES256-GCM-SHA384:ECDH-ECDSA-AES256-SHA:ECDH-ECDSA-AES256-SHA384:ECDH-RSA-AES128-GCM-SHA256:ECDH-RSA-AES128-SHA:ECDH-RSA-AES128-SHA256:ECDH-RSA-AES256-GCM-SHA384:ECDH-RSA-AES256-SHA:ECDH-RSA-AES256-SHA384:ECDH-RSA-CAMELLIA128-SHA256:DH-RSA-AES128-GCM-SHA256:DH-RSA-AES128-SHA:DH-RSA-AES128-SHA256:DH-RSA-AES256-GCM-SHA384:DH-RSA-AES256-SHA:DH-RSA-AES256-SHA256:AES256-GCM-SHA384:AES256-SHA:AES256-SHA256:AES128-GCM-SHA256:AES128-SHA:AES128-SHA256;
    ssl_prefer_server_ciphers on;
    ssl_session_cache shared:SSL:10m;
    ssl_dhparam /etc/ssl/dhparam-4096.pem;

    root /mnt/data/www;

    access_log  /var/log/nginx/sandstorm.park.rtvutrecht.nl.access.log;
    error_log  /var/log/nginx/sandstorm.park.rtvutrecht.nl.error.log;

    proxy_set_header    Host              $host;
    proxy_set_header    X-Real-IP         $remote_addr;
    proxy_set_header    X-Forwarded-For   $proxy_add_x_forwarded_for;
    proxy_set_header    X-Forwarded-SSL on;
    proxy_set_header    X-Forwarded-Proto $scheme;


     location ~ \.php$ {
                include snippets/fastcgi-php.conf;
                fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        }

     location ~ /\.ht {
                deny all;
        }

     location /anwb/endpoint {
            proxy_pass   https://fileservice.anwb.nl;
            proxy_hide_header X-Frame-Options;
            proxy_hide_header X-XSS-Protection;
            proxy_hide_header X-Permitted-Cross-Domain-Policies;
            proxy_hide_header X-Content-Type-Options;
     }


     location / {
            try_files $uri $uri/ =404;
        }




}

