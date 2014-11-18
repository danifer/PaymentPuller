#/bin/bash
mysqldump paymentpuller -u root -p | gzip -c | cat > paymentpuller-$(date +%Y-%m-%d-%H.%M.%S).sql.gz
