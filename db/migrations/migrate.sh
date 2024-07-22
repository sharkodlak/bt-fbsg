#!/bin/bash
substituteVariables () {
	sql=$(cat "$file")
	if [ -f "$file.input" ]; then
		. "$file.input"
	fi
	for varName in $matches
	do
		if [ -z ${!varName+empty} ]; then
			echo "$sql"
			echo -e "\n\e[36mInsert value for $varName\e[0m: "
			read input
			echo "local $varName=\"$input\"" >> "$file.input"
		else
			input=${!varName}
		fi
		sql=$(echo "$sql" | sed "s~{\$$varName}~$input~")
	done
}

getCurrentVersion () {
	q="SELECT year, version FROM _migrations ORDER BY year DESC, version DESC LIMIT 1"
	yearVersion=$(psql -tAX -U ${POSTGRES_USER} -c "$q")
}

setCurrentVersion () {
	q="INSERT INTO _migrations (year, version) VALUES (%d, %d)"
}


if psql -U "${DB_USER}" -lqt | cut -d \| -f 1 | grep -qw "${DB_NAME}"; then
	echo "Database »${DB_NAME}« exists."
else
	echo "Database »${DB_NAME}« does not exist."
	echo "Creating database »${DB_NAME}«..."
	SCRIPT_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" &> /dev/null && pwd )"
	sql=$(cat "$SCRIPT_DIR/../init.sql")
	echo "$(echo "$sql" | envsubst)" | psql -U ${POSTGRES_USER}
	echo "Database »${DB_NAME}« created."
fi
echo ""

DIR=$(dirname "$0")
files=$(find $DIR -name '*.sql' | sort)
for file in $files
do
	echo -e "Processing \e[93m$file\e[0m:"
	matches=$(grep -P '(?<=\{\$)[^}]+' -o $file | sort -u)
	if [ $? -eq 0 ]; then
		substituteVariables
		echo "$sql" | psql -U ${MAIN_ROLE} -d ${DB_NAME}
	else
		psql -U ${MAIN_ROLE} -d ${DB_NAME} < $file
	fi
	echo -e ""
done