#! /bin/bash

postCall()
{
	ACCESS_TOKEN=$1
	if [[ $ACCESS_TOKEN != "" ]]; then
		AUTHENTICATION_HEADER="Authentication:$ACCESS_TOKEN"
	else
		AUTHENTICATION_HEADER="Content-Type:application/json"
	fi

	if [ ! -f $2 ]; then
		echo "Oops. File $2 does not exist"
		return
	fi
	POSTDATA="--data-binary @${2}"
	API="${TESTSITE_MOBILIZE}${3}&responseFormat=json"
	OUTPUT=$4

	RESPONSE=$(curl --write-out "%{http_code}" --silent --header "Content-Type:application/json" --header $AUTHENTICATION_HEADER --request POST $POSTDATA $API --output $OUTPUT)
	echo $RESPONSE
}