#!/bin/bash
REP_SOURCE="/home/jpmena/Images/PhotosEOS1000CarteVidee"
REP_DEST="/home/jpmena/Images/PhotosEOS1000Sabalos04012013"

for i in $(find ${REP_SOURCE} -mtime -1 -type f) 
do
	mv "$i" "${REP_DEST}/"
done
