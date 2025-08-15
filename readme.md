tạo file php-custom.ini để tăng size khi upload

memory_limit = 512M
upload_max_filesize = 5120M
post_max_size = 5120M
max_execution_time = 300

sau đó chạy lệnh sau để coppy file vào config php
docker cp php-custom.ini <container_id>:/usr/local/etc/php/conf.d/

restart container

kiểm tra lại xem
docker exec -it <container_id> php -i | grep memory_limit
hiển thi memory_limit => 512M => 512M là okie

kiểm tra dùng logs
docker logs <container_name> --tail 50 -f


id container hiện tại : b63e8e52cf98
docker cp php-custom.ini b63e8e52cf98:/usr/local/etc/php/conf.d/
docker exec -it b63e8e52cf98 php -i | grep memory_limit
docker logs b63e8e52cf98 --tail 50 -f