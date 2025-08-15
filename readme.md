tạo file php-custom.ini để tăng size khi upload

memory_limit = 512M
upload_max_filesize = 5120M
post_max_size = 5120M
max_execution_time = 300

sau đó chạy lệnh sau để coppy file vào config php
docker cp php-custom.ini <container_id>:/usr/local/etc/php/conf.d/
id container hiện tại : b63e8e52cf98
docker cp php-custom.ini b63e8e52cf98:/usr/local/etc/php/conf.d/
