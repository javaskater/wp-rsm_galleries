#!/bin/bash

#export ORIG=/media/jpmena/EOS_DIGITAL/DCIM/101D3100
#export ORIG=/media/jpmena/F009-64A5/DCIM/101_PANA/
#export ORIG=/media/jpmena/9016-4EF8/DCIM/100NCD40/
#export ORIG=~/Téléchargements/soireedupalmares16052014
export SAUV_BASE=~/Images/RSM
export ARCHIVE_BASE=~/RSM
base_name=Match28022015
largeur_reduite=800
#mkdir -p "${SAUV_BASE}/${base_name}"
ORIG=${SAUV_BASE}/${base_name}
mkdir -p "${SAUV_BASE}/${base_name}"
rm -rf "${SAUV_BASE}/${base_name}/*"
mkdir -p "${ARCHIVE_BASE}/${base_name}"
rm -rf "${ARCHIVE_BASE}/${base_name}/*"
#http://www.cyberciti.biz/tips/handling-filenames-with-spaces-in-bash.html
SAVEIFS=$IFS
IFS=$(echo -en "\n\b")
for i in $(ls -l ${ORIG} | grep -i '\.jpg' | sed -e 's/  */ /gi' | cut -d ' ' -f9- | sort); 
do 
	#J'obtiens la largeuret hauteur le tout en pixels
	image_source=$ORIG/$i
	cp -pv $image_source "${SAUV_BASE}/${base_name}"
        echo "je decode ${i}"	
	largeur_originale=$(identify -format "%[fx:w]" $image_source)
	hauteur_originale=$(identify -format "%[fx:h]" $image_source)
	hauteur_reduite=$(( ${largeur_reduite}*$hauteur_originale/$largeur_originale ))
	#echo "largeur nouvelle: ${hauteur_reduite}"
	nom_image=$i
	convert "${SAUV_BASE}/${base_name}/${nom_image}" -resize ${largeur_reduite}x${hauteur_reduite} "${ARCHIVE_BASE}/${base_name}/${nom_image}"
	description=$(exiftool  "${SAUV_BASE}/${base_name}/${nom_image}" -xmp:all | grep -i title | cut -d':' -f2 | sed -e 's/^[[:space:]]*//g' -e 's/[[:space:]]*\$//g')
	echo "${i} a pour commentaire ${description}"
	if [ -z "$description" ]
	then
		echo "${nom_image}|xxxxxxxxxxxxxxxx|yyyyyyyyyy" >> "${ARCHIVE_BASE}/${base_name}/labels.txt"
	else
		echo "${nom_image}|${description}|yyyyyyyyyy" >> "${ARCHIVE_BASE}/${base_name}/labels.txt"
	fi
done
tar czvf "${ARCHIVE_BASE}/${base_name}.tgz" -C "${ARCHIVE_BASE}" ${base_name}
# restore $IFS
IFS=$SAVEIFS
