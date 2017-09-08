#! /bin/bash
# @author brentertz <brentertz@github.com>
# @see https://gist.github.com/brentertz/2216466
# @modifiedby Feighen Oosterbroek <foosterbroek@bwtrans.co.za>

# @author Rishad Omar <rishad@kaluma.com>
# @modified_by Feighen Oosterbroek <foosterbroek@bwtrans.co.za>
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
	echo $API
	OUTPUT=$4

	RESPONSE=$(curl --write-out "%{http_code}" --silent --header "Content-Type:application/json" --header $AUTHENTICATION_HEADER --request POST $POSTDATA $API --output $OUTPUT)
	echo $RESPONSE
}

COOKIE_NAME="PHPSESSID"
TEST_PAGE_URI=("${TESTSITE_MOBILIZE}/#/planningboard", "${TESTSITE_MOBILIZE}/#/api-request/DataView/getDetailView?objectRegistry=461&instance=5214")

echo "Logging in and storing session id."

RESPONSE=$(postCall "" postdata.json /api_request/Process/step?process=signIn__Process__20050101090000 responsePostSignIn.json)

TOKEN=`cat ./responsePostSignIn.json | jq -r '.data.login.accessToken'`

echo "Performing load test."
# ab -n 10 -c 5 -C "$COOKIE_NAME=$SESSION_ID" $TEST_PAGE_URI
for i in ${TEST_PAGE_URI[@]}; do
	ab -n 10 -c 5 -l -v1 -H "Authentication:$TOKEN" -C "$COOKIE_NAME=$TOKEN" $i
done
#
