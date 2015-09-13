#!/bin/bash

#if you need to reload the non empty database mysql -ursm25 -prsm25 rsm25 < rsm25.sql does the job
#see http://stackoverflow.com/questions/9558867/how-to-fetch-field-from-mysql-query-result-in-bash
#see also man mysql commmand: s=>silent N=>skip column name output
ROOT_MYSQL_ID=root
WP_MYSQL_ID=db480167647
REMOSITORY_LOCAL_ROOT=/home/jpmena/workspace/RSM/2_5_RespRSM/remos_downloads

res=$(mysql -u${ROOT_MYSQL_ID} -p${ROOT_MYSQL_ID} ${WP_MYSQL_ID} -s -N -e "SELECT ID, guid FROM wp_posts where post_type='attachment' order by ID desc;")
#echo "resultat:"$res
#http://stackoverflow.com/questions/10586153/split-string-into-an-array-in-bash
array=(${res// / })
prec=0
for i in "${!array[@]}"
do
	if [ $(( $i % 2)) -eq 1 ]
	then
		prec=$((i - 1))
		id_post=${array[$prec]}
		url=${array[i]}
		fichier_image=${url##*/} #http://stackoverflow.com/questions/1199613/extract-filename-and-path-from-url-in-bash-script
		clean_url_attachment="http://rollersports93.fr/uploads/${fichier_image}"
		sql_command="update wp_posts set guid='${clean_url_attachment}' where id=${id_post}"
		echo "on passe la commande: $sql_command à la base worpdress du CDRS"
		res=$(mysql -u${ROOT_MYSQL_ID} -p${ROOT_MYSQL_ID} ${WP_MYSQL_ID} -s -N -e "${sql_command}")
	fi
done
